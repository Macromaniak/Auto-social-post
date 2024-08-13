<?php

if (!defined('ABSPATH')) {
  exit;
}

require_once WP_AUTO_SOCIAL_DIR . 'admin/settings/content/fields.php';
require_once WP_AUTO_SOCIAL_DIR . 'admin/settings/content/layouts.php';

/**
 * generalHelpers.
 * includes general helper functions
 *
 * @link       https://https://www.phases.io
 * @since      1.0.0
 *
 * @package    Wp_Auto_Social_Publish
 * @subpackage Wp_Auto_Social_Publish/admin
 * @author Anandhu <anandhu.nadesh@phases.io>
 */

class generalHelpers
{

  static function wpasp_create_admin_page($page_title, $option_group, $option_name, $pageId)
  {
    layouts::adminPageWrap($page_title, $option_group, $option_name, $pageId);
  }

  static function wpasp_add_section_cb($args)
  {
    // Print any section information if needed
    echo $args['content'];
  }

  static function wpasp_add_field_cb($args)
  {
    $options = get_option($args['option_group']);

    switch ($args['field_type']) {

      case 'textarea':
        formFields::textarea($args, $options);
        break;
      case 'text':
        formFields::text($args, $options);
        break;
      case 'number':
        formFields::number($args, $options);
        break;
      case 'checkbox':
        formFields::checkbox($args, $options);
        break;
      case 'email':
        formFields::email($args, $options);
        break;
      case 'radio':
        formFields::radio($args, $options);
        break;
      default:
        formFields::text($args, $options);
    }
  }

  static function sanitize($input)
  {
    // Sanitize input here if necessary
    return $input;
  }

  static function sanitize_network_settings($input)
  {
    // Sanitize input here if necessary
    return $input;
  }

  static function get_post_types_list()
  {
    // Define post types to exclude
    $exclude_post_types = [
      'revision', 'nav_menu_item', 'custom_css', 'customize_changeset', 'oembed_cache', 'user_request',
      'wp_block', 'wp_font_face', 'wp_options_page', 'acf-field-group', 'acf-field',
      'wp_template', 'contact-form', 'wp_block_pattern', 'wp_template', 'wp_template_part', 'wp_global_styles',
      'wp_navigation', 'wp_font_family', 'wp_taxonomy', 'wp_post_type', 'acf-field', 'elementor_library', 'acf-taxonomy', 'acf-post-type', 'acf-ui-options-page', 'fl-builder-template', 'wpcf7_contact_form', 'header_slider_image', 
    ];

    // Get all registered post types
    $post_types = get_post_types([], 'objects');
    // echo '<pre>';
    // var_dump($post_types);
    // die();

    // Initialize an empty array to hold the post type data
    $post_types_array = [];

    // Loop through each post type and format the array
    foreach ($post_types as $post_type) {
      if (!in_array($post_type->name, $exclude_post_types)) {
        $post_types_array[] = [
          'id' => 'wpasp_post_type_' . $post_type->name,
          'title' => $post_type->label
        ];
      }
    }

    return $post_types_array;
  }
}
