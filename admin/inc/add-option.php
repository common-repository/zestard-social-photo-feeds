<?php

/**
 * Add default value to admin options
 */
add_option('spf_status');
add_option('spf_access_token');
add_option('spf_access_token_exp_time');
add_option('spf_user_name');
add_option('spf_user_id');
add_option('spf_show_from');
add_option('spf_type_of_layout', esc_html('spf_box_layout'));
add_option('spf_show_navigation_arrow');
add_option('spf_enable_autoplay');
add_option('spf_interval_time', esc_html('5000'));
add_option('spf_no_of_photos', esc_html('8'));
add_option('spf_no_of_column', esc_html('4'));
add_option('spf_space_around_images', esc_html('5'));
add_option('spf_show_load_button');
add_option('spf_button_bg_color', esc_html('#ffffff'));
add_option('spf_button_text_color', esc_html('#000000'));
add_option('spf_button_text'); 

/**
 * Register admin options 
 */
register_setting(SPF_REGISTER_OPTIONS, 'spf_status');
register_setting(SPF_REGISTER_OPTIONS, 'spf_access_token');
register_setting(SPF_REGISTER_OPTIONS, 'spf_access_token_exp_time');
register_setting(SPF_REGISTER_OPTIONS, 'spf_user_name');
register_setting(SPF_REGISTER_OPTIONS, 'spf_user_id');
register_setting(SPF_REGISTER_OPTIONS, 'spf_show_from');
register_setting(SPF_REGISTER_OPTIONS, 'spf_type_of_layout');
register_setting(SPF_REGISTER_OPTIONS, 'spf_show_navigation_arrow');
register_setting(SPF_REGISTER_OPTIONS, 'spf_enable_autoplay');
register_setting(SPF_REGISTER_OPTIONS, 'spf_interval_time');
register_setting(SPF_REGISTER_OPTIONS, 'spf_no_of_photos');
register_setting(SPF_REGISTER_OPTIONS, 'spf_no_of_column');
register_setting(SPF_REGISTER_OPTIONS, 'spf_space_around_images');
register_setting(SPF_REGISTER_OPTIONS, 'spf_show_load_button');
register_setting(SPF_REGISTER_OPTIONS, 'spf_button_bg_color');
register_setting(SPF_REGISTER_OPTIONS, 'spf_button_text_color');
register_setting(SPF_REGISTER_OPTIONS, 'spf_button_text');
?>