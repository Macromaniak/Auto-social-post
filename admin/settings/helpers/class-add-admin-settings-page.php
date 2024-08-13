<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once WP_AUTO_SOCIAL_DIR . 'admin/settings/helpers/class-general-helpers.php';

/**
 * WPAspAddAdminSettingsPage.
 * creates admin settings pages and subpages
 *
 * @link       https://https://www.phases.io
 * @since      1.0.0
 *
 * @package    Wp_Auto_Social_Publish
 * @subpackage Wp_Auto_Social_Publish/admin
 * @author Anandhu <anandhu.nadesh@phases.io>
 */

class WPAspAddAdminSettingsPage {
    public $pageTitle = '';
    public $menuTitle = '';
    public $capability = '';
    public $menuSlug = '';
    public $icon = 'dashicons-admin-generic';
    public $position = 100;
    public $parentSlug = '';
    public $pageId = '';
    public $isMainPage = false;
    public $option_group = '';

    public $callback;

    /**
     * Helper function to add section to admin settings 
     *
     * @param string $pageTitle title for the page
     * @param string $menuTitle title for the menu
     * @param string $capability permission required for the logged-in user to view the page
     * @param string $menuSlug menu slug for the page 
     * @param string $icon icon for the page in the menu 
     * @param string $position position of the page in the dashboard menu
     * @param string $parentSlug the parent page slug if the page is a subpage
     * @param bool $isMain denotes whether the page is a main page
     * @param bool $isSub denotes whether the page is a subpage
     * @param string $pageId custom id to use in the wrap of the settings page
     * @param array $args Additional parameters to pass to the callback function
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Anandhu <anandhu.nadesh@phases.io>
     * @return Void
     */
    function __construct($pageTitle, $menuTitle, $capability, $menuSlug, $icon = NULL, $position = NULL, $parentSlug = NULL, $isMainPage, $pageId = 'wpasp-admin-page-wrap', $option_group)
    {
        $this->pageTitle = $pageTitle?:$this->pageTitle;
        $this->menuTitle = $menuTitle?: $this->menuTitle;
        $this->capability = $capability?: $this->capability;
        $this->menuSlug = $menuSlug?: $this->menuSlug;
        $this->icon = $icon?: $this->icon;
        $this->position = $position?: $this->position;
        $this->parentSlug = $parentSlug?: $this->parentSlug;
        $this->pageId = $pageId;
        $this->isMainPage = $isMainPage;
        $this->option_group = $option_group;


        if($this->isMainPage)
        $this->add_page();

        if(!$this->isMainPage && !empty($this->parentSlug))
        $this->add_sub_page();
    }

    /**
     * add page to admin settings
     *
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Anandhu Anandhu <anandhu.nadesh@phases.io>
     * @return Void
     */
    private function add_page() {
        $menuTitle = $this->menuTitle;
        $menuSlug = $this->menuSlug;
        $pageId = $this->pageId;
        $option_group = $this->option_group;
        // $callback = $this->callback;
        add_menu_page(
            $this->pageTitle, // Page Title
            $this->menuTitle, // Menu Title
            $this->capability, // Capability
            $this->menuSlug, // Menu Slug
            function() use ($menuTitle, $option_group, $menuSlug, $pageId) {
                generalHelpers::wpasp_create_admin_page($menuTitle, $option_group, $menuSlug,$pageId); // Call the callback function with custom argument
            },
            $this->icon, // Icon
            $this->position // Position
        );
    }

     /**
     * add sub page to admin settings
     *
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Anandhu <anandhu.nadesh@phases.io>
     * @return Void
     */
    private function add_sub_page() {
        $menuTitle = $this->menuTitle;
        $menuSlug = $this->menuSlug;
        $pageId = $this->pageId;
        $option_group = $this->option_group;

        // die($this->parentSlug);

        add_submenu_page(
            $this->parentSlug, //Parent slug
            $this->pageTitle, // Page Title
            $this->menuTitle, // Menu Title
            $this->capability, // Capability
            $this->menuSlug, // Menu Slug
            function() use ($menuTitle, $option_group, $menuSlug, $pageId) {
                generalHelpers::wpasp_create_admin_page($menuTitle, $option_group, $menuSlug,$pageId); // Call the callback function with custom argument
            },
            $this->position // Position
        );

    }
}