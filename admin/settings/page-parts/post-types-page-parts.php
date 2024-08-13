<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once WP_AUTO_SOCIAL_DIR . 'admin/settings/helpers/class-general-helpers.php';

/**
 * socialMediaPageParts.
 * includes the sections and fields for the social media settings page
 *
 * @link       https://https://www.phases.io
 * @since      1.0.0
 *
 * @package    Wp_Auto_Social_Publish
 * @subpackage Wp_Auto_Social_Publish/admin
 * @author Anandhu <anandhu.nadesh@phases.io>
 */

class PostTypesPageParts
{
    static function sections($option_group)
    {
        return array(
            array(
                'id' => 'wpasp_post_types_settings_section',
                // 'title' => 'Post Types',
                'callback' => ['generalHelpers', 'wpasp_add_section_cb'],
                'page' => $option_group,
                'args' => array(
                    'before_section' => '<div id="wpasp_post_type_settings_section_tab_1">',
                    'after_section' => '</div>',
                    'content' => '<p>Enable/Disable Auto posting for post types</p>',
                    'section_class' => 'wpasp_post_type_section_tab'
                )
            )
        );
    }

    static function fields($option_group)
    {
        $post_types = generalHelpers::get_post_types_list();

        $field_list = array();

        foreach ($post_types as $pt) {

            $field_list[] = [
                'id' => $pt['id'],
                'title' => $pt['title'],
                'callback' => ['generalHelpers', 'wpasp_add_field_cb'],
                'page' => $option_group,
                'section' => 'wpasp_post_types_settings_section',
                'args' => array(
                    'field_type' => 'checkbox',
                    'label_for' => $pt['id'],
                    'class' => 'wpasp_settings_field',
                    'option_group' => WPASP_POST_TYPE_OPTIONS_NAME
                ),
            ];
        }

        return $field_list;
    }
}
