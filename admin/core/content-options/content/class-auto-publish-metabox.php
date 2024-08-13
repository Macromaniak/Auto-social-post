<?php
class Auto_Publish_Metabox {
    private $id = 'wpasp_auto_publish_metabox';
    private $title = 'Auto social publish settings';

    public function get_id() {
        return $this->id;
    }

    public function get_title() {
        return $this->title;
    }

    private function get_all_custom_fields($post_type) {
        return [];
        global $wpdb;
        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT DISTINCT meta_key FROM $wpdb->postmeta WHERE post_id IN (SELECT ID FROM $wpdb->posts WHERE post_type = %s)", $post_type
        ), ARRAY_A);

        $fields = [];
        if ($results) {
            foreach ($results as $result) {
                $fields[$result['meta_key']] = $result['meta_key'];
            }
        }

        return $fields;
    }

    private function get_all_acf_fields($post_type) {
        if (!function_exists('acf_get_field_groups')) {
            return [];
        }

        $field_groups = acf_get_field_groups(['post_type' => $post_type]);
        $acf_fields = [];

        foreach ($field_groups as $group) {
            $fields = acf_get_fields($group['ID']);
            if ($fields) {
                foreach ($fields as $field) {
                    $acf_fields[$field['name']] = $field['label'];
                }
            }
        }

        return $acf_fields;
    }

    private function get_all_fields($post_type) {
        $default_fields = [
            'post_title' => 'Post Title',
            'post_content' => 'Post Content',
            'post_excerpt' => 'Post Excerpt',
            'post_thumbnail' => 'Post Thumbnail'
        ];

        $custom_fields = $this->get_all_custom_fields($post_type);
        $acf_fields = $this->get_all_acf_fields($post_type);

        return array_merge($default_fields, $custom_fields, $acf_fields);
    }

    public function render($post) {
        wp_nonce_field('wpasp_auto_publish_nonce_action', 'wpasp_auto_publish_nonce');

        // Retrieve current values if they exist
        $facebook = get_post_meta($post->ID, '_wpasp_auto_publish_facebook', true);
        $linkedin = get_post_meta($post->ID, '_wpasp_auto_publish_linkedin', true);
        $instagram = get_post_meta($post->ID, '_wpasp_auto_publish_instagram', true);
        $twitter = get_post_meta($post->ID, '_wpasp_auto_publish_twitter', true);

        $title_source = get_post_meta($post->ID, '_wpasp_title_source', true) ?: 'post_title';
        $content_source = get_post_meta($post->ID, '_wpasp_content_source', true) ?: 'post_content';
        $image_source = get_post_meta($post->ID, '_wpasp_image_source', true) ?: 'post_thumbnail';

        $all_fields = $this->get_all_fields($post->post_type);

        // Metabox content
        echo '<table>';

        // Facebook
        echo '<tr>';
        echo '<td><label for="wpasp_auto_publish_facebook">Facebook</label></td>';
        echo '<td>';
        echo '<label class="switch">';
        echo '<input type="checkbox" id="wpasp_auto_publish_facebook" name="wpasp_auto_publish_facebook" value="1" ' . checked(1, $facebook, false) . ' />';
        echo '<span class="slider round"></span>';
        echo '</label>';
        echo '</td>';
        echo '</tr>';

        // LinkedIn
        echo '<tr>';
        echo '<td><label for="wpasp_auto_publish_linkedin">LinkedIn</label></td>';
        echo '<td>';
        echo '<label class="switch">';
        echo '<input type="checkbox" id="wpasp_auto_publish_linkedin" name="wpasp_auto_publish_linkedin" value="1" ' . checked(1, $linkedin, false) . ' />';
        echo '<span class="slider round"></span>';
        echo '</label>';
        echo '</td>';
        echo '</tr>';

        // Instagram
        echo '<tr>';
        echo '<td><label for="wpasp_auto_publish_instagram">Instagram</label></td>';
        echo '<td>';
        echo '<label class="switch">';
        echo '<input type="checkbox" id="wpasp_auto_publish_instagram" name="wpasp_auto_publish_instagram" value="1" ' . checked(1, $instagram, false) . ' />';
        echo '<span class="slider round"></span>';
        echo '</label>';
        echo '</td>';
        echo '</tr>';

        // Twitter
        echo '<tr>';
        echo '<td><label for="wpasp_auto_publish_twitter">Twitter</label></td>';
        echo '<td>';
        echo '<label class="switch">';
        echo '<input type="checkbox" id="wpasp_auto_publish_twitter" name="wpasp_auto_publish_twitter" value="1" ' . checked(1, $twitter, false) . ' />';
        echo '<span class="slider round"></span>';
        echo '</label>';
        echo '</td>';
        echo '</tr>';

        echo '</table>';

        // Title source
        echo '<p>' . __('Select the source of the title:', 'textdomain') . '</p>';
        echo '<select name="wpasp_title_source" id="wpasp_title_source">';
        foreach ($all_fields as $source => $label) {
            echo '<option value="' . esc_attr($source) . '" ' . selected($title_source, $source, false) . '>' . esc_html($label) . '</option>';
        }
        echo '</select><br>';

        // Content source
        echo '<p>' . __('Select the source of the content:', 'textdomain') . '</p>';
        echo '<select name="wpasp_content_source" id="wpasp_content_source">';
        foreach ($all_fields as $source => $label) {
            echo '<option value="' . esc_attr($source) . '" ' . selected($content_source, $source, false) . '>' . esc_html($label) . '</option>';
        }
        echo '</select><br>';

        // Image source
        echo '<p>' . __('Select the source of the image:', 'textdomain') . '</p>';
        echo '<select name="wpasp_image_source" id="wpasp_image_source">';
        foreach ($all_fields as $source => $label) {
            echo '<option value="' . esc_attr($source) . '" ' . selected($image_source, $source, false) . '>' . esc_html($label) . '</option>';
        }
        echo '</select><br>';
    }

    public function save($post_id) {
        if (!isset($_POST['wpasp_auto_publish_nonce'])) {
            return $post_id;
        }
        $nonce = $_POST['wpasp_auto_publish_nonce'];

        if (!wp_verify_nonce($nonce, 'wpasp_auto_publish_nonce_action')) {
            return $post_id;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        if (wp_is_post_autosave($post_id)) {
            return $post_id;
        }

        if (wp_is_post_revision($post_id)) {
            return $post_id;
        }

        $facebook = isset($_POST['wpasp_auto_publish_facebook']) ? 1 : 0;
        $linkedin = isset($_POST['wpasp_auto_publish_linkedin']) ? 1 : 0;
        $instagram = isset($_POST['wpasp_auto_publish_instagram']) ? 1 : 0;
        $twitter = isset($_POST['wpasp_auto_publish_twitter']) ? 1 : 0;

        $title_source = sanitize_text_field($_POST['wpasp_title_source']);
        $content_source = sanitize_text_field($_POST['wpasp_content_source']);
        $image_source = sanitize_text_field($_POST['wpasp_image_source']);

        error_log('Saving auto publish settings...'); // Debug log
        error_log("Facebook: $facebook, LinkedIn: $linkedin, Instagram: $instagram, Twitter: $twitter"); // Debug log
        error_log("Title source: $title_source, Content source: $content_source, Image source: $image_source"); // Debug log

        update_post_meta($post_id, '_wpasp_auto_publish_facebook', $facebook);
        update_post_meta($post_id, '_wpasp_auto_publish_linkedin', $linkedin);
        update_post_meta($post_id, '_wpasp_auto_publish_instagram', $instagram);
        update_post_meta($post_id, '_wpasp_auto_publish_twitter', $twitter);

        update_post_meta($post_id, '_wpasp_title_source', $title_source);
        update_post_meta($post_id, '_wpasp_content_source', $content_source);
        update_post_meta($post_id, '_wpasp_image_source', $image_source);
    }
}
