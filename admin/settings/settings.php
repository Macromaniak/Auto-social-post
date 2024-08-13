<?php

if (!defined('ABSPATH')) {
  exit;
}

require_once WP_AUTO_SOCIAL_DIR . 'admin/settings/pages/social-media-settings.php';
require_once WP_AUTO_SOCIAL_DIR . 'admin/settings/pages/post-type-settings.php';


/**
 * The admin settings initialization.
 * Register all the settings pages / Option groups
 *
 *
 * @package    Wp_Auto_Social_Publish
 * @subpackage Wp_Auto_Social_Publish/admin
 * @author     Phases <mail@phases.io>
 */
class Wp_Auto_Social_Publish_Admin_Settings
{

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   */
  public function __construct()
  {
    add_action('admin_init', array($this, 'init_general_setting'));
    new addSocialMediaSettingsPage();
    new addPostTypesSettingsPage();
  }

  function init_general_setting()
  {
  register_setting( WPASP_OPTIONS_GROUP, WPASP_OPTIONS_NAME /*generalHelpers::sanitize()*/ );
  register_setting( WPASP_POST_TYPE_OPTIONS_GROUP, WPASP_POST_TYPE_OPTIONS_NAME /*generalHelpers::sanitize()*/ );
  }

}


$single_site_settings = new Wp_Auto_Social_Publish_Admin_Settings();
