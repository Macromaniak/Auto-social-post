<?php
// Include Metabox Manager and individual Metabox classes
require_once WP_AUTO_SOCIAL_DIR . 'admin/core/social-media/social-media.php';
require_once WP_AUTO_SOCIAL_DIR . 'admin/core/content-options/content-options.php';

function wpasp_init_metabox_manager() {
    $metabox_manager = new Metabox_Manager();
    $metabox_manager->init();
}
add_action('plugins_loaded', 'wpasp_init_metabox_manager');
