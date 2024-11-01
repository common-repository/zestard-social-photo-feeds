<?php
defined('ABSPATH') or die('You can not access this file');

/**
 * @package           Zestard_spf_Photo_Feeds
 */

/*
 * Plugin Name:       Zestard Social Photo Feeds
 * Description:       Display customizable and responsive Instagram feeds.
 * Version:           1.0.2
 * Author:            Zestard Technologies
 * Author URI:        https://profiles.wordpress.org/zestardtechnologies/
 * License:           GPLv2 or later
 * Text Domain:       spf-social-feeds
 */

/**
*  Copyright 2020  Zestard Technology

*  This program is free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License, version 2, as
*  published by the Free Software Foundation.

*  This program is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.

*  You should have received a copy of the GNU General Public License
*  along with this program; if not, write to the Free Software
*  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Global variable for register options 
 */
define('SPF_REGISTER_OPTIONS','spf_options_group');

/**
 * Global variable for text-domain 
 */
define('SPF_TEXT_DOMAIN','spf-social-feeds');

/**
 * Define Zestard Social Photo Feeds main class 
 */
if ( ! class_exists( 'SPF_SocialPhotoFeeds' ) ) :

    /**
     * Main SPF_SocialPhotoFeeds Class
     * @since 1.0.0
     */
    class SPF_SocialPhotoFeeds {

        public $plugin;

        /**
        * Define constructor
        */
        function __construct() {
            $this->plugin = plugin_basename(__FILE__);
        }

       /**
        * All required actions and filters
        */
        function SPF_register() {

            /**
             * Plugin hooks for set setting page link
             */
            add_filter("plugin_action_links_$this->plugin", array($this, 'SPF_settingsLink'));

            /**
             * Admin actions and filters
             */
            add_action('admin_enqueue_scripts', array($this, 'SPF_admin_enqueue'));
            add_action('admin_enqueue_scripts', array($this, 'SPF_addColorPicker'));
            add_action('admin_menu', array($this, 'SPF_registerOptionsPage'));
            add_action('admin_init', array($this, 'SPF_registerSettings'));

            /**
             * Frontend actions and filters
             */
            add_action('wp_enqueue_scripts', array($this, 'SPF_frontEnqueue'));
            add_action('wp_head', array($this, 'SPF_getAceessToken'));
            add_action('wp_footer', array($this, 'SPF_gridViewFeeds'));
            add_action('wp_footer', array($this, 'SPF_carousel'));
        }

        /**
         * Include activation file
         */
        function SPF_activate() {
            include_once('inc/activation.php');
        }

        /**
         * Include deactivation file
         */
        function SPF_deactivate() {
           include_once('inc/deactivation.php');
        }

        /**
         * Add option page in setting menu 
         */
        function SPF_registerOptionsPage() {
           add_options_page('Zestard Social Photo Feeds', esc_html__('Social Photo Feeds', SPF_TEXT_DOMAIN), 'manage_options', 'spf_social_photo_feeds', array($this, 'SPF_OptionPage'));
        }

        /**
         * Option settings when activate the plugin 
         * @param string $links
         * @return string $links
         */
        function SPF_settingsLink($links) {

            $settings_link = '<a href="options-general.php?page=spf_social_photo_feeds">'. esc_html__('Settings', SPF_TEXT_DOMAIN). '</a>';

            array_push($links, $settings_link);
            return $links;

        }

        /**
         * Enqueue Admin styles and scripts
         */
        function SPF_admin_enqueue() {

            //CSS
            wp_enqueue_style('spf-admin-setttings', plugins_url('admin/css/spf-admin-settings.css', __FILE__));

            //JS
            //wp_enqueue_script('spf-admin-setttings', plugins_url('admin/js/spf-admin-settings.js', __FILE__));
            wp_register_script( 'spf-admin-setttings', plugins_url('admin/js/spf-admin-settings.js', __FILE__), array(), 1.20     , true);
            wp_enqueue_script( 'spf-admin-setttings' );
        }

        /**
         * Frontend styles and scripts 
         */
        function SPF_frontEnqueue() {

            //CSS
            if(get_option('spf_type_of_layout') == 'spf_carousel_layout'):

                wp_enqueue_style('spf-owl-carousel', plugins_url('public/css/owl.carousel.min.css', __FILE__) );
                wp_enqueue_style('spf-owl-theme', plugins_url('public/css/owl.theme.default.min.css', __FILE__));

            endif;

            wp_enqueue_style('spf-style', plugins_url('public/css/spf-style.css', __FILE__));

            //JS
            wp_enqueue_script( 'jquery' );
            if(get_option('spf_type_of_layout') == 'spf_carousel_layout')

            wp_enqueue_script('spf-owl-carousel-js', plugins_url('public/js/owl.carousel.js', __FILE__), array('jquery'));
            //wp_enqueue_script('spf-plugin-init', plugins_url('public/js/spf-plugin-init.js', __FILE__), array('jquery'));

            wp_register_script( 'spf-plugin-init', plugins_url('public/js/spf-plugin-init.js', __FILE__), array(), '' , true);
            wp_enqueue_script( 'spf-plugin-init' );
        }

        /**
         * Including admin layout file 
         */
        function SPF_OptionPage() {
            include_once('admin/inc/admin-layout.php');
        }

        /**
         * Including admin option page 
         */
        function SPF_registerSettings() {
            include_once('admin/inc/add-option.php');
        }

        /**
         * Enqueue Color picker JS and CSS
         */
        function SPF_addColorPicker($hook) {

            if (is_admin()) {
                //Color picker CSS
                wp_enqueue_style('wp-color-picker');

                //Color picker JS
                wp_enqueue_script('custom-script-handle', plugins_url('admin/js/ztpl-clr-picker.js', __FILE__), array('wp-color-picker'), false, true);
            }
        }

        /**
         * Including View file of Instagram feeds
         */
        function SPF_gridViewFeeds() {
            require_once 'public/inc/feeds-view.php';
        }

        /**
         * Including Carousel files for frontend
         */
        function SPF_carousel() {            
            if(get_option('spf_type_of_layout') == 'spf_carousel_layout') {
                require_once 'public/inc/carousel-feeds.php';
            }                
        }

        /**
         * Including Frontend files for access token
         */
        function SPF_getAceessToken() {            
            if(get_option('spf_type_of_layout') == 'spf_grid_layout') {
                require_once 'public/inc/get-access-token.php';
            }
        }

    }

endif; 

/**
 * Defining class to fetch Instagram Photo feeds
 */
if (class_exists('SPF_SocialPhotoFeeds')) {

    $spf_spf_photo_feeds = new SPF_SocialPhotoFeeds();

    $spf_spf_photo_feeds->SPF_register();
    $spf_spf_photo_feeds->SPF_gridViewFeeds();
}

/**
 * Register Activation hook 
 */
register_activation_hook(__FILE__, array($spf_spf_photo_feeds, 'SPF_activate'));

/**
 * Register Deactivation hook 
 */
register_deactivation_hook(__FILE__, array($spf_spf_photo_feeds, 'SPF_deactivate'));