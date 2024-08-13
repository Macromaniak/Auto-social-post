<?php

if (!defined('ABSPATH')) {
    exit;
}

require_once WP_AUTO_SOCIAL_DIR . 'admin/settings/helpers/class-add-admin-settings-page.php';

require_once WP_AUTO_SOCIAL_DIR . 'admin/settings/helpers/class-add-admin-page-sections-and-fields.php';

require_once WP_AUTO_SOCIAL_DIR . 'admin/settings/helpers/class-general-helpers.php';

require_once WP_AUTO_SOCIAL_DIR . 'admin/settings/page-parts/social-media-page-parts.php';

/**
 * addSocialMediaSettingsPage
 * creates social media settings page, sections and fields with help of 
 * WPAspAddAdminSettingsPage and WPAspAddAdminSectionsAndFields
 *
 * @link       https://https://www.phases.io
 * @since      1.0.0
 *
 * @package    Wp_Auto_Social_Publish
 * @subpackage Wp_Auto_Social_Publish/admin
 * @author Anandhu <anandhu.nadesh@phases.io>
 */

class addSocialMediaSettingsPage extends WPAspAddAdminSectionsAndFields {

    public function __construct()
    {
        add_action('admin_menu', array($this, 'init_plugin_page'));
        add_action('admin_init', array($this, 'init_page_content'));
    }

    /**
     * creates social media settings page using WPAspAddAdminSettingsPage
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Anandhu <anandhu.nadesh@phases.io>
     * @return Void
     */
    function init_plugin_page()
    {
        // Add network settings page for multisite
        if (WP_AUTO_SOCIAL_IS_MULTI_SITE && IS_NETWORK_ADMIN) {
        $createSettingsSubPage = new WPAspAddAdminSettingsPage(
            'WP Auto Social Post Network Settings',
            'WPASP Network Settings',
            'manage_network_options',
            WPASP_OPTIONS_GROUP,
            NULL,
            100,
            'settings.php',
            false,
            'wpasp-admin-page-wrap', //optional id for the page wrap
            WPASP_OPTIONS_GROUP
        );
        }
        else {

          $createSettingsPage = new WPAspAddAdminSettingsPage(
            'WP Auto Social Post Settings',
            'WPASP Settings',
            'manage_options',
            WPASP_OPTIONS_GROUP,
            'dashicons-admin-generic',
            100,
            null,
            true,
            'wpasp-admin-page-wrap', //optional id for the page wrap
            WPASP_OPTIONS_GROUP
            );    
        }
    }

  /**
     * creates sections and fields for social media settings page
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Anandhu <anandhu.nadesh@phases.io>
     * @return Void
     */
  function init_page_content() {

    $sections = socialMediaPageParts::sections(WPASP_OPTIONS_GROUP);

    foreach($sections as $section) {
      $this->add_section(
        $section['id'],
        $section['title'],
        $section['callback'],
        $section['page'],
        $section['args']
      );
    }
    
    $fields = socialMediaPageParts::fields(WPASP_OPTIONS_GROUP);

    foreach($fields as $field) {
      $this->add_field(
        $field['id'],
        $field['title'],
        $field['callback'],
        $field['page'],
        $field['section'],
        $field['args']
      );
    }
  }
}

?>