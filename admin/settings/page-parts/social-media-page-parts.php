<?php

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

class socialMediaPageParts
{
    static function sections($option_group)
    {
        return array(
            // array(
            //     'id' => 'wpasp_social_media_section_1',
            //     'title' => 'Facebook',
            //     'callback' => ['generalHelpers', 'wpasp_add_section_cb'],
            //     'page' => $option_group,
            //     'args' => array(
            //         'before_section' => '<div id="wpasp_social_section_tab_1">',
            //         'after_section' => '</div>',
            //         'content' => '<p>configure facebook API</p>',
            //         'section_class' => 'wpasp_social_section_tab'
            //     )
            // ),
            // array(
            //     'id' => 'wpasp_social_media_section_2',
            //     'title' => 'Instagram',
            //     'callback' => ['generalHelpers', 'wpasp_add_section_cb'],
            //     'page' => $option_group,
            //     'args' => array(
            //         'before_section' => '<div id="wpasp_social_section_tab_2">',
            //         'after_section' => '</div>',
            //         'content' => '<p>configure instagram API</p>',
            //         'section_class' => 'wpasp_social_section_tab'
            //     )
            // ),
            // array(
            //     'id' => 'wpasp_social_media_section_3',
            //     'title' => 'LinkedIn',
            //     'callback' => ['generalHelpers', 'wpasp_add_section_cb'],
            //     'page' => $option_group,
            //     'args' => array(
            //         'before_section' => '<div id="wpasp_social_section_tab_3">',
            //         'after_section' => '</div>',
            //         'content' => '<p>configure LinkedIn API</p>',
            //         'section_class' => 'wpasp_social_section_tab'
            //     )
            // ),
            array(
                'id' => 'wpasp_social_media_section_twitter',
                'title' => 'Twitter',
                'callback' => ['generalHelpers', 'wpasp_add_section_cb'],
                'page' => $option_group,
                'args' => array(
                    'before_section' => '<div id="wpasp_social_section_tab_4">',
                    'after_section' => '</div>',
                    'content' => '<p>configure Twitter API</p>',
                    'section_class' => 'wpasp_social_section_tab'
                )
            )
        );
    }

    static function fields($option_group)
    {
        return array(
            // array(
            //     'id' => 'wpasp_social_facebook_field_1',
            //     'title' => 'Field 1',
            //     'callback' => ['generalHelpers', 'wpasp_add_field_cb'],
            //     'page' => $option_group,
            //     'section' => 'wpasp_social_media_section_1',
            //     'args' => array(
            //         'field_type' => 'text',
            //         'label_for' => 'wpasp_social_facebook_field_1',
            //         'class' => 'wpasp_settings_field',
            //     )
            // ),
            // array(
            //     'id' => 'wpasp_social_facebook_field_2',
            //     'title' => 'Field 1',
            //     'callback' => ['generalHelpers', 'wpasp_add_field_cb'],
            //     'page' => $option_group,
            //     'section' => 'wpasp_social_media_section_1',
            //     'args' => array(
            //         'field_type' => 'email',
            //         'label_for' => 'wpasp_social_facebook_field_2',
            //         'class' => 'wpasp_settings_field',
            //     )
            // ),
            // array(
            //     'id' => 'wpasp_social_insta_field_1',
            //     'title' => 'Field 2',
            //     'callback' => ['generalHelpers', 'wpasp_add_field_cb'],
            //     'page' => $option_group,
            //     'section' => 'wpasp_social_media_section_2',
            //     'args' => array(
            //         'field_type' => 'textarea',
            //         'label_for' => 'wpasp_social_insta_field_1',
            //         'class' => 'wpasp_settings_field',
            //     )
            // ),
            // array(
            //     'id' => 'wpasp_social_insta_field_2',
            //     'title' => 'Field 2',
            //     'callback' => ['generalHelpers', 'wpasp_add_field_cb'],
            //     'page' => $option_group,
            //     'section' => 'wpasp_social_media_section_2',
            //     'args' => array(
            //         'field_type' => 'number',
            //         'label_for' => 'wpasp_social_insta_field_2',
            //         'class' => 'wpasp_settings_field',
            //     )
            // ),
            // array(
            //     'id' => 'wpasp_social_linkedin_field_1',
            //     'title' => 'Field 3',
            //     'callback' => ['generalHelpers', 'wpasp_add_field_cb'],
            //     'page' => $option_group,
            //     'section' => 'wpasp_social_media_section_3',
            //     'args' => array(
            //         'field_type' => 'checkbox',
            //         'label_for' => 'wpasp_social_linkedin_field_1',
            //         'class' => 'wpasp_settings_field',
            //     )
            // ),
            // array(
            //     'id' => 'wpasp_social_linkedin_field_2',
            //     'title' => 'Field 3',
            //     'callback' => ['generalHelpers', 'wpasp_add_field_cb'],
            //     'page' => $option_group,
            //     'section' => 'wpasp_social_media_section_3',
            //     'args' => array(
            //         'field_type' => 'radio',
            //         'label_for' => 'wpasp_social_linkedin_field_2',
            //         'class' => 'wpasp_settings_field',
            //     )
            // ),
            array(
                'id' => 'wpasp_social_twitter_api_key',
                'title' => 'API Key',
                'callback' => ['generalHelpers', 'wpasp_add_field_cb'],
                'page' => $option_group,
                'section' => 'wpasp_social_media_section_twitter',
                'args' => array(
                    'field_type' => 'text',
                    'label_for' => 'wpasp_social_twitter_api_key',
                    'class' => 'wpasp_settings_field',
                    'option_group' => WPASP_OPTIONS_NAME
                )
            ),
            array(
                'id' => 'wpasp_social_twitter_api_secret',
                'title' => 'API Secret',
                'callback' => ['generalHelpers', 'wpasp_add_field_cb'],
                'page' => $option_group,
                'section' => 'wpasp_social_media_section_twitter',
                'args' => array(
                    'field_type' => 'text',
                    'label_for' => 'wpasp_social_twitter_api_secret',
                    'class' => 'wpasp_settings_field',
                    'option_group' => WPASP_OPTIONS_NAME
                )
            ),
            array(
                'id' => 'wpasp_social_twitter_bearer_token',
                'title' => 'Bearer Token',
                'callback' => ['generalHelpers', 'wpasp_add_field_cb'],
                'page' => $option_group,
                'section' => 'wpasp_social_media_section_twitter',
                'args' => array(
                    'field_type' => 'text',
                    'label_for' => 'wpasp_social_twitter_bearer_token',
                    'class' => 'wpasp_settings_field',
                    'option_group' => WPASP_OPTIONS_NAME
                )
            ),
            array(
                'id' => 'wpasp_social_twitter_access_token',
                'title' => 'Access Token',
                'callback' => ['generalHelpers', 'wpasp_add_field_cb'],
                'page' => $option_group,
                'section' => 'wpasp_social_media_section_twitter',
                'args' => array(
                    'field_type' => 'text',
                    'label_for' => 'wpasp_social_twitter_access_token',
                    'class' => 'wpasp_settings_field',
                    'option_group' => WPASP_OPTIONS_NAME
                )
            ),
            array(
                'id' => 'wpasp_social_twitter_access_secret',
                'title' => 'Access Secret',
                'callback' => ['generalHelpers', 'wpasp_add_field_cb'],
                'page' => $option_group,
                'section' => 'wpasp_social_media_section_twitter',
                'args' => array(
                    'field_type' => 'text',
                    'label_for' => 'wpasp_social_twitter_access_secret',
                    'class' => 'wpasp_settings_field',
                    'option_group' => WPASP_OPTIONS_NAME
                ),
            )
        );
    }
}
