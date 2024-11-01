<?php

//Authentication code for get access token
if (sanitize_text_field($_GET['code'] != '')) {

    //Auth code
    $social_auth_code = sanitize_text_field($_GET['code']);  
    $social_client_id = sanitize_key(get_option('social_client_id')); /* Get client id */
    $social_client_secret = sanitize_key(get_option('social_client_secret')); /* Get client secret */
    $social_redirect_url = esc_url(get_site_url()); /* Get redirect url */

    //Get client id from cookie
    if (sanitize_key($_COOKIE["spf_social_feeds_client_id"])) {
        $social_api_client_id = sanitize_key($_COOKIE["spf_social_feeds_client_id"]);
    } else {
        if (!empty($social_client_id)) {
            $social_api_client_id = $social_client_id;
        }
    }

    //Get client secret from cookie
    if (sanitize_key($_COOKIE['spf_social_feeds_client_secret'])) {
        $social_api_client_secret = sanitize_key($_COOKIE['spf_social_feeds_client_secret']);
    } else {
        if (!empty($social_client_secret)) {
            $social_api_client_secret = $social_client_secret;
        }
    }

    //Get redirect url from cookie
    if (sanitize_key($_COOKIE['spf_social_feeds_redirect_url'])) {
        $social_api_redirect_url = sanitize_key($_COOKIE['spf_social_feeds_redirect_url']);
    } else {
        if (!empty($social_redirect_url)) {
            $social_api_redirect_url = $social_redirect_url;
        }
    }

    $social_api_body = array(
        'client_id' => $social_api_client_id,
        'client_secret' => $social_api_client_secret,
        'grant_type' => 'authorization_code',
        'redirect_uri' => $social_api_redirect_url,
        'code' => $social_auth_code
    );

    $args = array(
        'body' => $social_api_body,
        'timeout' => '5',
        'redirection' => '5',
        'httpversion' => '1.0',
        'blocking' => true,
        'headers' => array(),
        'cookies' => array()
    );
  
    //API host url
    $social_api_host = wp_remote_post( 'https://api.instagram.com/oauth/access_token', $args );
    
    echo '<pre>';
    var_dump($social_api_host);
    echo '</pre>';
    exit;
    if($social_api_host['response']['code'] == 200){
        $social_jason_result = json_decode($social_api_host['body']);
    }  
    
    //Display access token
    if (!empty($social_jason_result)) {
        $social_get_access_token = esc_html($social_jason_result->access_token);
    ?>

    <div style="border: 1px solid blue; margin: 10px;"><b><?php echo esc_html__('Your Access Token: ', SPF_TEXT_DOMAIN); ?></b><?php echo $social_get_access_token; ?></div>
    <?php
        exit;

    } else {

        $social_get_access_token_error = $social_jason_result->error_message;
        ?>

        <div style="border: 1px solid red; margin: 10px;"><?php echo esc_html($social_get_access_token_error); ?></div>            
        <?php
        exit;
    }
}
?>