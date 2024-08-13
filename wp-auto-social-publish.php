<?php

if (!defined('ABSPATH')) {
	exit;
}

/**
 *
 * @link              https://https://www.phases.io
 * @since             1.0.0
 * @package           Wp_Auto_Social_Publish
 *
 * @wordpress-plugin
 * Plugin Name:       WP Auto-social Publish beta
 * Plugin URI:        https://https://www.phases.io
 * Description:       One click post publish to all your social media accounts.
 * Version:           1.0.2
 * Author:            Phases
 * Author URI:        https://https://www.phases.io/
 * License:           GPL-3.0+
 * License URI:       https://choosealicense.com/licenses/gpl-3.0/
 * Text Domain:       wp-auto-social-publish
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

function wpasp_enqueue_script_and_style() {
    // wp_enqueue_script( 'wpasp_custom_script', plugin_dir_url( __FILE__ ) . 'assets/js/custom-script.js', array('jquery'), '1.0'  );
    wp_enqueue_style('wpasp_custom_style', plugin_dir_url( __FILE__ ) . 'admin/assets/css/wp-auto-social-publish-admin.css');
}
add_action('admin_enqueue_scripts', 'wpasp_enqueue_script_and_style');

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('WP_AUTO_SOCIAL_DIR', plugin_dir_path(__FILE__));
// Constants 
require_once WP_AUTO_SOCIAL_DIR . 'includes/wpasp-global-constants.php';

require_once WP_AUTO_SOCIAL_DIR . 'admin/class-wp-auto-social-publish-admin.php';

new Wp_Auto_Social_Publish_Admin('WP Auto Social Publish', WP_AUTO_SOCIAL_PUBLISH_VERSION);


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-auto-social-publish-activator.php
 */
function activate_wp_auto_social_publish()
{
	require_once WP_AUTO_SOCIAL_DIR . 'includes/class-wp-auto-social-publish-activator.php';
	Wp_Auto_Social_Publish_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-auto-social-publish-deactivator.php
 */
function deactivate_wp_auto_social_publish()
{
	require_once WP_AUTO_SOCIAL_DIR . 'includes/class-wp-auto-social-publish-deactivator.php';
	Wp_Auto_Social_Publish_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_wp_auto_social_publish');

register_deactivation_hook(__FILE__, 'deactivate_wp_auto_social_publish');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
// require WP_AUTO_SOCIAL_DIR . 'includes/class-wp-auto-social-publish.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_auto_social_publish()
{

	$plugin = new Wp_Auto_Social_Publish();
	$plugin->run();
}
// run_wp_auto_social_publish();
