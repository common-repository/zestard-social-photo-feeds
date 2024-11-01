/**
 * Document ready function 
 */
jQuery(document).ready(function() {

    var code = getParameterByName('code');
    var user_id = getParameterByName('user_id');
    var user_name = getParameterByName('username');
    if( code !== '' ) {
        var html = '';
        html += '<div class="spf-popup-wrapper">';
        html +=     '<div class="spf-popup-main">';
        html +=         '<a class="close spf-popup-close" href="javascript:;">×</a>';
        html +=         '<form method="post" action="">';
        html +=            '<table>';
        html +=                '<tr>';
        html +=                    '<th>';
        html +=                        '<label>'+user_name+'</label>';
        html +=                        '<input type="hidden" name="spf_access_token" id="popup_spf_access_token" value="'+code+'">';
        html +=                        '<input type="hidden" name="spf_user_name" id="popup_spf_user_name" value="'+user_name+'">';
        html +=                        '<input type="hidden" name="spf_user_id" id="popup_spf_user_id" value="'+user_id+'">';
        html +=                        '<input type="hidden" name="spf_access_token_exp_time" id="popup_spf_access_token_exp_time" value="'+ Math.round(new Date().getTime()/1000 + 4752000) +'">';
        html +=                    '</th>';        
        html +=               '</tr>';
        html +=               '<tr>';
        html +=                    '<td><input type="submit" name="popup_submit" value="Continue with '+user_name+' account"></td>';
        html +=               '</tr>';
        html +=            '</table>';
        html +=        '</form>';
        html +=     '</div>';
        html +=  '</div>';

        jQuery('.spf-popup-container').append(html);
    }

    jQuery('.spf-popup-close').on('click', function() {
        jQuery('.spf-popup-wrapper').remove();
    });

    /**
     * Tabs onclick event 
     */
    jQuery('.spf-social-feeds-tab .tab-links a').on('click', function(e) {

        var currentAttrValue = jQuery(this).attr('href');

        /**
         * Show & Hide Tabs 
         */
        jQuery('.spf-social-feeds-tab ' + currentAttrValue).show().siblings().hide();

        /**
         * Change & Remove current tab to active 
         */
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');

        /**
         * Active last tab which was select 
         */
        var cookie_name = 'ztpl-tab-select';
        var cookie_value = currentAttrValue;

        /**
         * Create object of Date class
         */
        var date = new Date();
        var exdays = 1;

        date.setTime(date.getTime() + (exdays * 24 * 60 * 60 * 1000));

        var expires = "expires=" + date.toUTCString();

        /**
         * Set cookie 
         */
        document.cookie = cookie_name + "=" + cookie_value + ";" + expires + ";path=/";

        e.preventDefault();
    });

    /**
     * Get current selected layout value 
     */
    var on_load_layout_value = jQuery('input[name=spf_type_of_layout]:checked').val();

    /**
     * Show & Hide carousel layout settings fileds onload 
     */
    if (on_load_layout_value === 'spf_carousel_layout') {

        jQuery('#spf_carousel_settings').show();
        jQuery('#spf_carousel_item_msg').show();
        jQuery('#spf_load_more_tab').hide();

    } else {

        jQuery('#spf_carousel_settings').hide();
        jQuery('#spf_carousel_item_msg').hide();
        jQuery('#spf_load_more_tab').show();
    }

    jQuery(document).on('click', '#spf_refresh_token', function(){
        var old_access_token = jQuery('#spf_access_token').val();
        console.log(old_access_token);
        jQuery.ajax({
            url: 'https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=' + old_access_token,
            type: 'GET',
            success: function(response) {
                jQuery('#spf_access_token').val(response.access_token);
                jQuery('#spf_username_text').append('Your token has been successfully refreshed. Please save to use it further.');
                jQuery('#spf_refresh_token').hide();
            },
            error: function(xhr, textStatus, errorThrown) {
                alert('There is some error in refreshing access token...');
            }
        });

    });

    /**
     * Display carousel layout setting fields 
     */
    jQuery('#customise_tab').change(function() {

        var layout_value = jQuery('input[name=spf_type_of_layout]:checked').val();

        /**
         * Show & Hide carousel layout settings fileds onchange 
         */
        if (layout_value === 'spf_carousel_layout') {

            jQuery('#spf_carousel_settings').show();
            jQuery('#spf_carousel_item_msg').show();
            jQuery('#spf_load_more_tab').hide();

        } else {

            jQuery('#spf_carousel_settings').hide();
            jQuery('#spf_carousel_item_msg').hide();
            jQuery('#spf_load_more_tab').show();
        }
    });
});

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function spf_getAuthCode() {
    /**
     * Get client id, client secret, redirect url fields value 
     */
    var client_id = '843512092821494';
    var redirect_url = jQuery('#generate_access_token').data('redirect_uri');
    var state = jQuery('#generate_access_token').data('state');

    var api_url = 'https://api.instagram.com/oauth/authorize';

    api_url += '?client_id='+ client_id +'&redirect_uri='+ redirect_url +'&scope=user_profile,user_media&response_type=code&state=' + state;

    window.location.href = api_url;
}

/**
 * Copy to clipboard the redirect url 
 */
function spf_copyToClipBoard() {
    /**
     * Get redirect url value 
     */
    var social_redirect_url_copy = jQuery.trim(jQuery('#spf_redirect_url').html());

    if (social_redirect_url_copy) {

        /**
         * Add temporary input tag in body 
         */
        var social_temp_input = jQuery("<input>");
        jQuery("body").append(social_temp_input);

        /**
         * Select redirect url value 
         */
        social_temp_input.val(social_redirect_url_copy).select();

        /**
         * Focus redirect url label 
         */
        if (jQuery(".copy-redirect").length == 0) {

            jQuery('span.click-here').append("<b class='copy-redirect' style='color:#006400;margin-left: 10px;'>Copied!</b>");
        }

        /**
         * Copy to clipboard 
         */
        document.execCommand("copy");

        /**
         * remove temparory input tag
         */
        social_temp_input.remove();
    }
}