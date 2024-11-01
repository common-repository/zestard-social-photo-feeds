<?php
/**
 * trigger this file on plugin uninstallation
 *  @package  Zestard_spf_Photo_Feeds
 */

/**
 * Security check to prevent unauthorised user
 */
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

/**
 * Delete option fields from database on uninstallation of plugin
 */
delete_option('spf_status');
delete_option('spf_client_id');
delete_option('spf_client_secret');
delete_option('spf_redirect_url');
delete_option('spf_access_token');
delete_option('spf_access_token_exp_time');
delete_option('spf_user_name');
delete_option('spf_user_id');
delete_option('spf_type_of_layout');
delete_option('spf_no_of_photos');
delete_option('spf_no_of_column');
delete_option('spf_space_around_images');
delete_option('spf_image_resolution');
delete_option('spf_show_load_button');
delete_option('spf_button_bg_color');
delete_option('spf_button_text_color');
delete_option('spf_button_text');
delete_option('spf_show_navigation_arrow');
delete_option('spf_enable_autoplay');
delete_option('spf_interval_time');
?>