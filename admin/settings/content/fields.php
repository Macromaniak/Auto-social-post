<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * formFields.
 * includes different form field templates
 *
 * @link       https://https://www.phases.io
 * @since      1.0.0
 *
 * @package    Wp_Auto_Social_Publish
 * @subpackage Wp_Auto_Social_Publish/admin
 * @author Anandhu <anandhu.nadesh@phases.io>
 */

class formFields {

    static function text($args, $options) {
        // var_dump($options);
        echo '<input type="'.$args['field_type'].'" id="'.$args['label_for'].'" name="'.$args['option_group'].'['.$args['label_for'].']" value="' . esc_attr($options[$args['label_for']]) . '" />';
    }

    static function checkbox($args, $options) {
        // var_dump($args['options_name']);
        $value = $options[$args['label_for']];
        $checked = $value ? 'checked' : '';
        echo '<label class="switch">';
        echo '<input type="'.$args['field_type'].'" id="'.$args['label_for'].'" name="'.$args['option_group'].'['.$args['label_for'].']" value="1" ' .$checked. '>';
        echo '<span class="slider round"></span>';
        echo '</label>';
    }

    static function textarea($args, $options) {
        echo '<textarea id="'.$args['label_for'].'" name="'.$args['option_group'].'['.$args['label_for'].']">'.esc_attr($options[$args['label_for']]).'</textarea>';
    }

    static function radio($args, $options) {
        echo '<input type="'.$args['field_type'].'" id="'.$args['label_for'].'" name="'.$args['option_group'].'['.$args['label_for'].']" value="' . esc_attr($options[$args['label_for']]) . '" checked="'.$options[$args['label_for']].'">';
    }

    static function number($args, $options) {
        echo '<input type="'.$args['field_type'].'" id="'.$args['label_for'].'" name="'.$args['option_group'].'['.$args['label_for'].']" value="' . esc_attr($options[$args['label_for']]) . '" />';
    }

    static function email($args, $options) {
        echo '<input type="'.$args['field_type'].'" id="'.$args['label_for'].'" name="'.$args['option_group'].'['.$args['label_for'].']" value="' . esc_attr($options[$args['label_for']]) . '" />';
    }
}

?>