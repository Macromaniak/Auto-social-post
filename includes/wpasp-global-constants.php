<?php

if (!defined('ABSPATH')) {
	exit;
}

define('WP_AUTO_SOCIAL_PUBLISH_VERSION', '1.0.0');


define('WP_AUTO_SOCIAL_URL', plugin_dir_url(__FILE__));


!defined('WP_AUTO_SOCIAL_IS_MULTI_SITE') && define('WP_AUTO_SOCIAL_IS_MULTI_SITE', is_multisite());

define('IS_NETWORK_ADMIN', is_network_admin());

if(IS_NETWORK_ADMIN)
{
define('WPASP_OPTIONS_GROUP', 'wpasp_network_settings');
define('WPASP_OPTIONS_NAME', 'wpasp_network_general_options');

define('WPASP_POST_TYPE_OPTIONS_GROUP', 'wpasp_network_post_types_settings');
define('WPASP_POST_TYPE_OPTIONS_NAME', 'wpasp_network_post_types_options');
}
else
{
define('WPASP_OPTIONS_GROUP', 'wpasp_settings');
define('WPASP_OPTIONS_NAME', 'wpasp_general_options');

define('WPASP_POST_TYPE_OPTIONS_GROUP', 'wpasp_post_types_settings');
define('WPASP_POST_TYPE_OPTIONS_NAME', 'wpasp_post_types_options');
}
?>