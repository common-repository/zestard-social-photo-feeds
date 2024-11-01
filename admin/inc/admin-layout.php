<?php
//ob_clean(); ob_start();
/**
 * Get tab value from cookie 
 */

$spf_tab_select = $_COOKIE['ztpl-tab-select'];

/**
 * Get admin option values 
 */

$status_value = get_option('spf_status'); 

$spf_redirect_url = admin_url('options-general.php?page-spf_social_photo_feeds');

$spf_access_token = get_option('spf_access_token');

$spf_access_token_exp_time = get_option('spf_access_token_exp_time');

$spf_user_name = get_option('spf_user_name');

$spf_user_id = get_option('spf_user_id');

$spf_type_of_layout = get_option('spf_type_of_layout');

$spf_no_of_photos = get_option('spf_no_of_photos');

$spf_no_of_column = get_option('spf_no_of_column');

$spf_space_around_images = get_option('spf_space_around_images');

$spf_show_load_button = get_option('spf_show_load_button');

$spf_button_bg_color = get_option('spf_button_bg_color');

$spf_button_text_color = get_option('spf_button_text_color');

$spf_button_text = get_option('spf_button_text');

$spf_show_navigation_arrow = get_option('spf_show_navigation_arrow');

$spf_enable_autoplay = get_option('spf_enable_autoplay');

$spf_interval_time = get_option('spf_interval_time');

//save instagram accounts's necessary things in option
if ( !empty($_POST['popup_submit']) ) {

    $spf_access_token = isset( $_POST['spf_access_token'] ) ? sanitize_text_field( $_POST['spf_access_token'] ) : false;
    $spf_user_name = isset( $_POST['spf_user_name'] ) ? sanitize_text_field( $_POST['spf_user_name'] ) : false;
    $spf_user_id = isset( $_POST['spf_user_id'] ) ? sanitize_text_field( $_POST['spf_user_id'] ) : false;
    $spf_access_token_exp_time = isset( $_POST['spf_access_token_exp_time'] ) ? sanitize_text_field( $_POST['spf_access_token_exp_time'] ) : false;

    update_option( 'spf_access_token', $spf_access_token );
    update_option( 'spf_user_name', $spf_user_name );
    update_option( 'spf_user_id', $spf_user_id );
    update_option( 'spf_access_token_exp_time', $spf_access_token_exp_time );
?>
<script type="text/javascript">
    window.location.href='<?php echo admin_url("options-general.php?page=spf_social_photo_feeds"); ?>';
</script>
<?php
}
?>

<!--admin setting page html-->

<div class="tabs spf-social-feeds-tab">
    <h1 class="spf-heading"><?php  echo esc_html__('Instagram Feed', SPF_TEXT_DOMAIN); ?></h1>
    <ul class="tab-links">

        <li class="<?php

        if ($spf_tab_select == '#configuration_tab' || $spf_tab_select == '') {

            echo esc_html__('active', SPF_TEXT_DOMAIN);

        }

        ?>">

            <a href="#configuration_tab"> 

                <?php  echo esc_html__('Configuration', SPF_TEXT_DOMAIN); ?>

            </a>

        </li>

        <li class="<?php

        if ($spf_tab_select == '#customise_tab') {

            echo esc_html__('active', SPF_TEXT_DOMAIN);

        }

        ?>">

            <a href="#customise_tab">

                <?php  echo esc_html__('Customize', SPF_TEXT_DOMAIN); ?>

            </a>

        </li>

        <li class="<?php

        if ($spf_tab_select == '#how_to_display_feeds_tab') {

            echo esc_html__('active', SPF_TEXT_DOMAIN);

        }

        ?>">

            <a href="#how_to_display_feeds_tab">

                <?php  echo esc_html__('How To Display Feeds', SPF_TEXT_DOMAIN); ?>

            </a>

        </li>

        <li class="<?php

        if ($spf_tab_select == '#support_tab') {

            echo esc_html__('active', SPF_TEXT_DOMAIN);

        }

        ?>">

            <a href="#support_tab" target="_blank">

                <?php  echo esc_html__('Support', SPF_TEXT_DOMAIN); ?>

            </a>

        </li>

    </ul>

    <div class="spf-popup-container"></div>

    <!-- Form configuration -->

    <form method="post" action="options.php" id="spf_admin_layout_form">

        <?php settings_fields('spf_options_group'); ?>

        <!-- Configuration tab -->

        <div id="configuration_tab" style="<?php

        if ($spf_tab_select == '#configuration_tab' || $spf_tab_select == '') {

            echo esc_attr__('display:block', SPF_TEXT_DOMAIN);

        } else {

            echo esc_attr__('display:none', SPF_TEXT_DOMAIN);

        }

        ?>">

            <div class="tab-content">
                <div class="tab active">
                    <table class="form-table">
                        <tr valign="top">
                            <th style="width:250px;">
                                <label for="spf_status"><?php echo esc_html__('Is Currently', SPF_TEXT_DOMAIN); ?></label>
                            </th>
                            <td>
                                <input type="radio" name="spf_status" value="enable" checked="checked"  

                                       <?php if ($status_value == 'enable') { ?> checked="checked" <?php } ?>>

                                       <?php echo esc_html__('Enable', SPF_TEXT_DOMAIN); ?>

                                <input type="radio" name="spf_status" value="disable" 

                                       <?php if ($status_value == 'disable') { ?> checked="checked" <?php } ?>>

                                       <?php echo esc_html__('Disable', SPF_TEXT_DOMAIN); ?>        
                            </td>
                        </tr>
                        <?php
                            if (!empty($spf_user_name)) {
                        ?>                        
                        <tr valign="top">
                            <th>
                                <label><?php echo esc_html__('Connected Instagram Account', SPF_TEXT_DOMAIN); ?></label>
                            </th>
                            <td>
                                <label><?php echo '<b>'.esc_html__($spf_user_name.' ('.$spf_user_id.')', SPF_TEXT_DOMAIN).'</b>'; ?></label>
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                        <tr valign="top">
                            <th>
                                <label for="spf_access_token"><?php echo esc_html__('Access Token', SPF_TEXT_DOMAIN); ?></label>
                            </th>
                            <td>                                
                                <input type="text" style="width: 100%;" class="spf_access_token" name="spf_access_token" id="spf_access_token" <?php if (!empty($spf_access_token)) { echo 'value="'.esc_html__($spf_access_token, SPF_TEXT_DOMAIN).'" readonly'; } ?>>
                                <a href="javascript:;" class="button button-primary generate-token" id="generate_access_token" data-redirect_uri="https://phptasks.com/zestard-instafeed/index.php" data-state="<?php if($spf_redirect_url) { echo $spf_redirect_url; }  ?>" onclick="spf_getAuthCode();"><?php echo esc_html__('Generate Instagram Access Token', SPF_TEXT_DOMAIN); ?></a>
                                <input type="hidden" name="spf_user_name" id="spf_user_name" value="<?php echo (isset($spf_user_name) ? esc_html($spf_user_name) : ''); ?>">
                                <input type="hidden" name="spf_user_id" id="spf_user_id" value="<?php echo (isset($spf_user_id) ? esc_html($spf_user_id) : ''); ?>">
                                <input type="hidden" name="spf_access_token_exp_time" value="<?php echo (isset($spf_access_token_exp_time) ? esc_html($spf_access_token_exp_time) : time() + 4752000); ?>">
                                <p id="spf_username_text"></p>
                                <?php
                                    if (!empty($spf_access_token_exp_time) && time() > $spf_access_token_exp_time) {
                                ?>
                                <a href="javascript:;" id="spf_refresh_token"><?php echo esc_html__('Refresh access token', SPF_TEXT_DOMAIN); ?></a>
                                <?php
                                    }
                                ?>                                
                            </td> 
                        </tr>
                    </table>
                </div>
            </div>
            <?php submit_button(); ?>
        </div>

        <!-- End configuration tab -->

        <!-- Customize tab -->

        <div id="customise_tab" style="<?php

        if ($spf_tab_select == '#customise_tab') {

            echo esc_attr__("display:block", SPF_TEXT_DOMAIN);

        } else {

            echo esc_attr__("display:none", SPF_TEXT_DOMAIN);

        }

        ?>" >

            <div class="tab-content">
                <div class="tab">
                    <table class="form-table">
                        <tbody> 
                            <tr>
                                <td>
                                    <h2><?php echo esc_html__('Layout', SPF_TEXT_DOMAIN); ?></h2>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="spf_type_of_layout"><?php echo esc_html__('Type of Layout', SPF_TEXT_DOMAIN); ?></label>
                                </th>                           
                                <td>
                                    <div class="social-layouts">
                                        <div class="social-layout-box">
                                            <input type="radio" name="spf_type_of_layout" id="spf_layout_grid" value="spf_grid_layout"  
                                                   <?php if($spf_type_of_layout == 'spf_grid_layout') { ?> checked="checked" <?php } ?> checked="checked">
                                            <label class="social-layout-label" for="spf_layout_grid">
                                                <span><?php echo esc_html__('Grid', SPF_TEXT_DOMAIN); ?></span>
                                                <img src="<?php echo plugins_url('zestard-social-photo-feeds/admin/images/grid.jpg'); ?>">
                                            </label>
                                        </div>
                                        <div class="social-layout-box">
                                            <input type="radio" name="spf_type_of_layout" id="spf_layout_carousel" value="spf_carousel_layout" 
                                                   <?php if ($spf_type_of_layout == 'spf_carousel_layout') { ?> checked="checked" <?php } ?>>
                                            <label class="social-layout-label" for="spf_layout_carousel">
                                                <span><?php echo esc_html__('Carousel', SPF_TEXT_DOMAIN); ?></span>
                                                <img src="<?php echo plugins_url('zestard-social-photo-feeds/admin/images/carousel.png'); ?>">
                                            </label> 
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <tbody id="spf_carousel_settings"> 
                            <tr>
                                <th>
                                    <label for="spf_show_navigation_arrow"><?php echo esc_html__('Want to show navigation arrow?', SPF_TEXT_DOMAIN); ?></label>
                                </th>
                                <td>    
                                    <input type="checkbox" name="spf_show_navigation_arrow" id="spf_show_navigation_arrow" value="true"
                                    <?php if ($spf_show_navigation_arrow == 'true') { echo esc_html('checked');}
                                    ?> >
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="spf_enable_autoplay"><?php echo esc_html__('Want to enable autoplay?', SPF_TEXT_DOMAIN); ?></label>
                                </th>
                                <td>    
                                    <input type="checkbox" name="spf_enable_autoplay" id="spf_enable_autoplay" value="true"
                                    <?php if ($spf_enable_autoplay == 'true') { echo esc_html('checked');}
                                    ?> >
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="spf_interval_time"><?php echo esc_html__('Interval Time', SPF_TEXT_DOMAIN); ?></label>
                                </th> 
                                <td>
                                    <input type="number" name="spf_interval_time" value="<?php if (!empty($spf_interval_time)) { echo esc_html($spf_interval_time);}

                                    ?>" > <span><?php echo esc_html__('Milisecond', SPF_TEXT_DOMAIN); ?></span>
                                </td>
                            </tr>
                        </tbody> 

                        <tr>
                            <th>
                                <label for="spf_no_of_photos"><?php echo esc_html__('Number of Photos', SPF_TEXT_DOMAIN); ?></label>
                            </th>
                            <td>
                                <input type="number" name="spf_no_of_photos" value="<?php if (!empty($spf_no_of_photos)) {echo esc_html__($spf_no_of_photos, SPF_TEXT_DOMAIN);}

                                ?>" > <span class="social-feed-comment" id="spf_carousel_item_msg"><?php echo esc_html__('Minimum number of photos for carousel is 5.', SPF_TEXT_DOMAIN); ?></span>

                                <span class="social-feed-comment"><?php echo esc_html__('Number of photos to show initially. Maximum of 30.', SPF_TEXT_DOMAIN); ?></span>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="spf_no_of_column"><?php echo esc_html__('Number of Column', SPF_TEXT_DOMAIN); ?></label>
                            </th>

                            <td>
                                <select name="spf_no_of_column">
                                    <option value="1" <?php if ($spf_no_of_column == '1') { ?> selected <?php } ?>>
                                        <?php echo esc_html__('1', SPF_TEXT_DOMAIN); ?>
                                    </option>

                                    <option value="2" <?php if ($spf_no_of_column == '2') { ?> selected <?php } ?>>
                                        <?php echo esc_html__('2', SPF_TEXT_DOMAIN); ?>
                                    </option>

                                    <option value="3" <?php if ($spf_no_of_column == '3') { ?> selected <?php } ?>>
                                        <?php echo esc_html__('3', SPF_TEXT_DOMAIN); ?>
                                    </option>

                                    <option value="4" <?php if ($spf_no_of_column == '4') { ?> selected <?php } ?>>
                                        <?php echo esc_html__('4', SPF_TEXT_DOMAIN); ?>
                                    </option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="spf_space_around_images"><?php echo esc_html__('Padding around Images', SPF_TEXT_DOMAIN); ?></label>
                            </th>
                            <td>
                                <input type="number" min="1" id="spf_space_around_images" name="spf_space_around_images" value="<?php if(!empty($spf_space_around_images)){
                                    echo esc_html__($spf_space_around_images, SPF_TEXT_DOMAIN);
                                } ?>" > <span><?php echo esc_html__('Pixels', SPF_TEXT_DOMAIN); ?></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div> 
            <div class="tab-content" id="spf_load_more_tab">
                <div class="tab">
                    <table class="form-table">
                        <tbody>
                            <tr>
                        <h2><?php echo esc_html__('Load More Button', SPF_TEXT_DOMAIN); ?></h2>
                        </tr>
                        <tr>
                            <th>
                                <label for="spf_show_load_button"><?php echo esc_html__('Want to show Load More button?', SPF_TEXT_DOMAIN); ?></label>
                            </th>
                            <td>    
                                <input type="checkbox" name="spf_show_load_button" value="true"<?php
                                if ($spf_show_load_button == 'true') { echo esc_html__('checked', SPF_TEXT_DOMAIN);}
                                ?> >
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="spf_button_bg_color"><?php echo esc_html__('Background Color', SPF_TEXT_DOMAIN); ?></label>
                            </th>
                            <td> 
                                <input type="text" name="spf_button_bg_color" class="cpa-color-picker" value="<?php
                                if (!empty($spf_button_bg_color)) {echo esc_html__($spf_button_bg_color, SPF_TEXT_DOMAIN);}
                                ?>" >
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="spf_button_text_color"><?php echo esc_html__('Button Text Color', SPF_TEXT_DOMAIN); ?></label>
                            </th>
                            <td>
                                <input type="text" name="spf_button_text_color" class="cpa-color-picker" value="<?php
                                if (!empty($spf_button_text_color)) {echo esc_html__($spf_button_text_color, SPF_TEXT_DOMAIN);}
                                ?>" >
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="spf_button_text"><?php echo esc_html__('Button Text', SPF_TEXT_DOMAIN); ?></label>
                            </th>
                            <td>
                                <input type="text" name="spf_button_text" value=" <?php
                                if (!empty($spf_button_text)) {echo esc_html__($spf_button_text, SPF_TEXT_DOMAIN);} else { echo esc_html__('Load more', SPF_TEXT_DOMAIN); }
                                ?>">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php submit_button(); ?>
        </div>

        <!-- End customize tab -->

        <!-- How to display feed tab -->

        <div id="how_to_display_feeds_tab" style="<?php
        if ($spf_tab_select == '#how_to_display_feeds_tab' || $spf_tab_select == '') {

            echo esc_attr__("display:block", SPF_TEXT_DOMAIN);

        } else {

            echo esc_attr__("display:none", SPF_TEXT_DOMAIN);

        }

        ?>">

            <div class="tab-content display_feeds_tab">
                <div class="tab active">
                    <table class="form-table">
                        <tr valign="top">
                            <th style="width:250px;">
                                <h2><?php echo esc_html__('Display Your Feeds', SPF_TEXT_DOMAIN); ?></h2>
                                <p><?php echo esc_html__("Copy and paste the following shortcode directly into the page, post or widget where you'd like the feed to show up:", SPF_TEXT_DOMAIN); ?></p>
                            </th>
                        </tr>
                        <tr valign="top">                            
                            <td>
                                <label name="spf_shortcode" readonly="true"><?php echo esc_html__('[zestard-social-photo-feeds]', SPF_TEXT_DOMAIN); ?></label>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- End how to display feed tab -->

        <!-- Support tab -->

        <div id="support_tab" style="<?php
        if ($spf_tab_select == '#support_tab' || $spf_tab_select == '') {echo esc_attr__("display:block", SPF_TEXT_DOMAIN);} else {echo esc_attr__("display:none", SPF_TEXT_DOMAIN);}

        ?>">

            <div class="tab-content">
                <div class="tab active">
                    <table class="form-table">
                        <tr valign="top">
                            <th style="width:250px;">
                                <h2><?php echo esc_html__('Need Help?', SPF_TEXT_DOMAIN); ?></h2>
                                <p><a href="https://www.zestard.com/contact-us/" target="_blank"><?php echo esc_html__("Click Here", SPF_TEXT_DOMAIN); ?></a></p>
                            </th>
                        </tr>                        
                    </table>
                </div>
            </div>
        </div>
        <!-- End Support tab -->       
    </form>
    <!-- End form configuration -->
</div>

