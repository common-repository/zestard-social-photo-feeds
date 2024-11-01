<?php

//Get plugin status
$status_value = get_option('spf_status');

/**
 * Adding frontend main class 
 */
class SPF_shortcode {

    /**
     * Social photo feeds connection 
     * @param string $api_url
     * @return string $spf_json_return
     */
    function SPF_connect($api_url) {
      
        //Call the API
        $spf_response = wp_remote_get($api_url);
        $spf_json_return  = wp_remote_retrieve_body( $spf_response );

        return json_decode($spf_json_return);     
    }

    /**
     * Get access token from database
     * @return string $spf_access_token
     */
    function SPF_getPost() {

        $spf_access_token = get_option('spf_access_token');

        if (!empty($spf_access_token)) {

            return $spf_access_token;
        }
    }

    /**
     * Shortcode callback function
     */
    function SPF_addShortcode() {
       
        //Call member function
        $spf_return_access_token = $this->SPF_getPost();
        $spf_exp_date = esc_html( get_option( 'spf_access_token_exp_time' ) );

        //Admin options
        $spf_user_id = esc_html(get_option('spf_user_id'));
        $spf_show_from = esc_html(get_option('spf_show_from'));
        $spf_hashtag = sanitize_text_field(get_option('spf_hashtag'));
        $spf_type_of_layout = sanitize_text_field(get_option('spf_type_of_layout'));
        $spf_no_of_photos = sanitize_text_field(get_option('spf_no_of_photos'));      
        $spf_no_of_column = sanitize_text_field(get_option('spf_no_of_column'));        
        $spf_space_around_images = sanitize_text_field(get_option('spf_space_around_images'));        
        $spf_image_resolution = sanitize_text_field(get_option('spf_image_resolution'));        
        $spf_show_load_button = sanitize_text_field(get_option('spf_show_load_button'));        
        $spf_button_bg_color = sanitize_hex_color(get_option('spf_button_bg_color'));        
        $spf_button_text_color = sanitize_hex_color(get_option('spf_button_text_color'));        
        $spf_button_text = sanitize_text_field(get_option('spf_button_text'));
        
        //Adding css class based on layout selection
        if ($spf_type_of_layout) {

            if ($spf_type_of_layout == 'spf_grid_layout') {
                $spf_layout_class = sanitize_html_class('spf-grid-layout');
            } elseif ($spf_type_of_layout == 'spf_carousel_layout') {

                $spf_layout_class = sanitize_html_class('spf-carousel-layout');
                $spf_carousel_ul_class = 'owl-carousel owl-theme';
                $spf_carousel_li_class = 'item';

            } else {

                $spf_layout_class = sanitize_html_class('spf-box-layout');
            }
        }

        //Add css class based on no of column selection
        if ($spf_no_of_column) {

            if ($spf_no_of_column == '1') {
                $spf_column_class = sanitize_html_class('spf-1-column');
            } elseif ($spf_no_of_column == '2') {
                $spf_column_class = sanitize_html_class('spf-2-column');
            } elseif ($spf_no_of_column == '3') {
                $spf_column_class = sanitize_html_class('spf-3-column');
            } else {
                $spf_column_class = sanitize_html_class('spf-4-column');
            }

        }

        //Padding for images
        if ($spf_space_around_images) {
            $spf_img_space = 'padding : ' . $spf_space_around_images . 'px;';
        }

        //bg-color for button
        if ($spf_button_bg_color) {
            $spf_bg_color = 'background-color : ' . $spf_button_bg_color . ';';
        }

        //Text color for button
        if ($spf_button_text_color) {
            $spf_text_color = 'color : ' . $spf_button_text_color . ';';
        }

        //Count for no of photos
        if ($spf_no_of_photos) {
            $spf_img_count = '&count=' . $spf_no_of_photos;
        }

        if (time() < $spf_exp_date) {        
            //Call Instagram API
            $spf_post_return = $this->SPF_connect('https://graph.instagram.com/'.$spf_user_id.'/media?fields=media_url,thumbnail_url,caption,id,media_type,timestamp,username,comments_count,like_count,permalink,children{media_url,id,media_type,timestamp,permalink,thumbnail_url}&limit='.$spf_no_of_photos.'&access_token='.$spf_return_access_token);
        } else {
            //Call Instagram API for refresing token
            $spf_return_refresh_token = $this->SPF_connect('https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token='.$spf_return_access_token);          

            $spf_post_return = $this->SPF_connect('https://graph.instagram.com/'.$spf_user_id.'/media?fields=media_url,thumbnail_url,caption,id,media_type,timestamp,username,comments_count,like_count,permalink,children{media_url,id,media_type,timestamp,permalink,thumbnail_url}&limit='.$spf_no_of_photos.'&access_token='.$spf_return_refresh_token->access_token);

            update_option( 'spf_access_token_exp_time', time() + 4752000 );
        }
        
        //Get post data
        if ($spf_post_return && $spf_post_return->data) { ?>

            <!-- social photo feeds frontend view -->
            <div id="spf-feed-display" <?php

            if (!empty($spf_layout_class)) {

                echo "class='" . esc_attr($spf_layout_class) . ' ' . esc_attr($spf_column_class) . "'";
            } ?>>

                <ul id="spf-feed-carousel" class="spf-feed-group test <?php

                if (!empty($spf_carousel_ul_class)) {echo esc_attr($spf_carousel_ul_class);}
                ?>">

                        <?php
                        foreach ($spf_post_return->data as $spf_post) {

                            //Get media data
                            if ($spf_post->media_type == 'IMAGE') {                        
                            	$spf_full_screen_img = $spf_post->media_url; /* URL of image */
                            	$spf_post_url = $spf_post->permalink; /* URL of post */
                            }
                            
                        ?>

                        <li <?php

                        if ($spf_carousel_li_class) {
                            echo "class='" . esc_attr($spf_carousel_li_class) . "'";
                        }

                        if ($spf_img_space) {
                            echo "style='" . esc_attr($spf_img_space) . "'";
                        } ?>>

                            <a href="<?php echo esc_url($spf_post_url); ?>" target="_blank">
                                <img src="<?php echo esc_url($spf_full_screen_img); ?>">
                            </a>
                        </li>

                        <?php
                    }
                    ?>
                </ul>    
            </div>

            <?php

            //Display button if show button value true and layout is grid

            if ($spf_show_load_button == 'true' && $spf_type_of_layout != 'spf_carousel_layout' && $spf_post_return->paging->next != '') {

                //Get next url        
                $spf_post_next_url = esc_url($spf_post_return->paging->next);
                ?>

                <!-- Frontend load more button html-->

                <div class="spf-load-more">
                    <?php if (!empty($spf_button_text)) {
                        ?>
                        <button id="spf_load_more" nextpage="<?php echo esc_url_raw($spf_post_next_url); ?>" style="<?php echo esc_attr($spf_bg_color); ?> <?php echo esc_attr($spf_text_color); ?>" onclick="spf_loadMoreFeeds('<?php echo esc_js($spf_space_around_images); ?>');"><?php echo sanitize_text_field($spf_button_text); ?></button>
                        <?php
                    }
                    ?>
                </div>

                <?php
            }
        } else {
            ?>
            <!--Display error message-->
            <div><?php echo esc_html($spf_post_return->error->message); ?></div>
            <?php
        }
    }
}

//Shortcode class
if (class_exists('SPF_shortcode')) {

    if ($status_value == 'enable') {

        $spf_feeds_shortcode = new SPF_shortcode();

        add_shortcode('zestard-social-photo-feeds', array($spf_feeds_shortcode, 'SPF_addShortcode'));
    }
}