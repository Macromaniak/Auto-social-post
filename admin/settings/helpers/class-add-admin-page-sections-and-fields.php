<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * WPAspAddAdminSectionsAndFields.
 * adds sections and fields to admin pages
 *
 * @link       https://https://www.phases.io
 * @since      1.0.0
 *
 * @package    Wp_Auto_Social_Publish
 * @subpackage Wp_Auto_Social_Publish/admin
 * @author Anandhu <anandhu.nadesh@phases.io>
 */
class WPAspAddAdminSectionsAndFields
{

    /**
     * Helper function to add section to admin settings page
     *
     * @param string $id id for the section
     * @param string $title title for the section
     * @param function $callback callback function for the section template
     * @param string $page menu slug for the page 
     * @param array $args Additional parameters to pass to the callback function
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Anandhu
     * @return Void
     */
    function add_section($id, $title, $callback, $page, $args)
    {
        add_settings_section(
            $id,
            $title,
            $callback,
            $page,
            $args
        );
    }

    /**
     * Helper function to add section to admin settings page under specific section
     *
     * @param string $id id for the section
     * @param string $title title for the section
     * @param function $callback callback function for the section template
     * @param string $page menu slug for the page 
     * @param string $section name of the section to which the field belongs
     * @param array $args Additional parameters to pass to the callback function
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Anandhu
     * @return Void
     */
    function add_field($id, $title, $callback, $page, $section, $args)
    {
        // var_dump($callback);
        // var_dump($section);
        add_settings_field(
            $id, 
            $title, 
            $callback,
            $page, 
            $section,
            $args
        );
    }
}
