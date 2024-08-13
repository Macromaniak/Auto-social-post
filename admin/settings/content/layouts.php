<?php
/**
 * layouts.
 * includes admin settings page layouts and tempplate wraps
 *
 * @link       https://https://www.phases.io
 * @since      1.0.0
 *
 * @package    Wp_Auto_Social_Publish
 * @subpackage Wp_Auto_Social_Publish/admin
 * @author Anandhu <anandhu.nadesh@phases.io>
 */
class layouts {
    static function adminPageWrap($page_title, $option_group, $option_name, $pageId) {
    // var_dump($option_name);
        ?>
        <div class="wpasp-admin-page-wrap" id="<?php echo $pageId; ?>">
        <h2><?php echo $page_title ?></h2>
        <?php settings_errors(); ?>
  
        <form method="post" action="options.php">
            <?php
            settings_fields($option_group);
            do_settings_sections($option_name);
            submit_button();
            ?>
        </form>
    </div>
    <?php
    }
}