<?php
class Metabox_Manager {
    private $metaboxes = [];

    public function init() {
        $this->register_metabox(new Auto_Publish_Metabox());

        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post', [$this, 'save_post']);
        add_action('save_post', [$this, 'handle_post_publish'], 20, 2); // Set priority and pass arguments
    }

    public function register_metabox($metabox) {
        $this->metaboxes[] = $metabox;
    }

    public function add_meta_boxes() {
        foreach ($this->metaboxes as $metabox) {
            $post_types = get_post_types(['public' => true], 'names');
            $options = get_option(WPASP_POST_TYPE_OPTIONS_NAME);

            foreach ($post_types as $post_type) {
                $option_name = 'wpasp_post_type_' . $post_type;

                if (isset($options[$option_name]) && $options[$option_name] == 1) {
                    add_meta_box(
                        $metabox->get_id(),
                        $metabox->get_title(),
                        [$metabox, 'render'],
                        $post_type,
                        'normal',
                        'default'
                    );
                }
            }
        }
    }

    public function save_post($post_id) {
        foreach ($this->metaboxes as $metabox) {
            $metabox->save($post_id);
        }
    }

    private function get_field_value($post_id, $field, $default_field) {
        if ($field === 'post_title' || $field === 'post_content' || $field === 'post_excerpt') {
            return get_post_field($field, $post_id);
        } elseif ($field && metadata_exists('post', $post_id, $field)) {
            return get_post_meta($post_id, $field, true);
        } elseif ($field && function_exists('get_field')) {
            $field_value = get_field($field, $post_id);
            if (is_array($field_value)) {
                if (isset($field_value['url'])) {
                    return $field_value['url'];
                } elseif (isset($field_value['ID'])) {
                    return get_attached_file($field_value['ID']);
                }
            }
            return $field_value;
        }
        return '';
    }

    public function handle_post_publish($post_id, $post) {
        error_log('handle_post_publish called'); // Debug log
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            error_log('Autosave, returning'); // Debug log
            return;
        }

        // Check if already tweeted
        if (get_post_meta($post_id, '_wpasp_tweeted', true)) {
            error_log('Already tweeted, returning'); // Debug log
            return;
        }

        // Check if Twitter auto-publish is enabled
        $auto_publish_twitter = get_post_meta($post_id, '_wpasp_auto_publish_twitter', true);
        if (!$auto_publish_twitter) {
            error_log('Twitter auto-publish not enabled, returning'); // Debug log
            return;
        }
        error_log('Twitter auto-publish is enabled'); // Debug log

        // Get source fields
        $title_source = get_post_meta($post_id, '_wpasp_title_source', true);
        $content_source = get_post_meta($post_id, '_wpasp_content_source', true);
        $image_source = get_post_meta($post_id, '_wpasp_image_source', true);

        error_log("Title source: $title_source"); // Debug log
        error_log("Content source: $content_source"); // Debug log
        error_log("Image source: $image_source"); // Debug log

        $title = $this->get_field_value($post_id, $title_source, 'post_title');
        $content = $this->get_field_value($post_id, $content_source, 'post_content');
        $imagePaths = [];

        if ($image_source === 'post_thumbnail') {
            if (has_post_thumbnail($post_id)) {
                $thumbnail_id = get_post_thumbnail_id($post_id);
                $image_path = get_attached_file($thumbnail_id);
                if ($image_path) {
                    $imagePaths[] = $image_path;
                }
            }
        } else {
            $image_path = $this->get_field_value($post_id, $image_source, '_custom_image_field');
            if ($image_path) {
                if(!is_array($image_path)){
                    if(str_contains($image_path, 'field'))
                    {
                        $image_field_value = get_field($image_path, $post_id);
                        $image_path = is_array($image_field_value) ? $image_field_value['url'] : $image_field_value; 
                    }
                    else
                    {
                        $image_path = get_post($image_path)->guid;
                        error_log(var_dump($image_path));
                    }
                }
                $imagePaths[] = $image_path;
            }
        }

        error_log("Title: $title"); // Debug log
        error_log("Content: $content"); // Debug log
        error_log("Image paths: " . implode(', ', $imagePaths)); // Debug log

        // Initialize SocialMediaManager and post
        try {
            $socialMediaManager = new SocialMediaManager();
            error_log('SocialMediaManager initialized'); // Debug log

            // Post to Twitter if enabled
            error_log('Posting to Twitter'); // Debug log
            $socialMediaManager->post('twitter', $title . "\n" . $content, $imagePaths);
            update_post_meta($post_id, '_wpasp_tweeted', 1);
        } catch (Exception $e) {
            error_log('SocialMediaManager Error: ' . $e->getMessage());
        }
    }
}
