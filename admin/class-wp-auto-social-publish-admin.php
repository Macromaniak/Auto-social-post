<?php

if (!defined('ABSPATH')) {
	exit;
}

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://www.phases.io
 * @since      1.0.0
 *
 * @package    Wp_Auto_Social_Publish
 * @subpackage Wp_Auto_Social_Publish/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Auto_Social_Publish
 * @subpackage Wp_Auto_Social_Publish/admin
 * @author     Phases <mail@phases.io>
 */
class Wp_Auto_Social_Publish_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->load_dashboard_settings();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Auto_Social_Publish_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Auto_Social_Publish_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, WP_AUTO_SOCIAL_URL_PATH . 'admin/assets/css/wp-auto-social-publish-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Auto_Social_Publish_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Auto_Social_Publish_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, WP_AUTO_SOCIAL_URL_PATH . 'admin/assets/js/wp-auto-social-publish-admin.js', array('jquery'), $this->version, false);
	}

	private function load_dashboard_settings()
	{
		/**
		 * 
		 * The class responsible for enabling all the settings
		 * 
		 */
		require_once WP_AUTO_SOCIAL_DIR . 'admin/settings/settings.php';
		require_once WP_AUTO_SOCIAL_DIR . 'admin/core/core-init.php';

	}
}
