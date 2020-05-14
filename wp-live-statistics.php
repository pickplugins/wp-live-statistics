<?php
/*
Plugin Name: WP Live Statistics
Plugin URI: 
Description: Live visitor stats and page view stats
Version: 1.3.4
Author: PickPlugins
Author URI: http://pickplugins.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/



if( ! class_exists( 'WPLiveStatistics' ) ) {
    class WPLiveStatistics{

        public function __construct(){

            define('wpls_plugin_url', plugins_url('/', __FILE__));
            define('wpls_plugin_dir', plugin_dir_path(__FILE__));
            define('wpls_plugin_name', 'WP Live Statistics');

            if(!class_exists('Browser')){
                require_once( wpls_plugin_dir . 'includes/Browser.php');
            }

            require_once( wpls_plugin_dir . 'includes/geoplugin.class.php');
            require_once( wpls_plugin_dir . 'includes/wpls-functions.php');
            require_once( wpls_plugin_dir . 'includes/wpls-functions-top-query.php');
            require_once( wpls_plugin_dir . 'includes/wpls-shortcodes.php');
            require_once( wpls_plugin_dir . 'includes/class-settings-tabs.php');
            require_once( wpls_plugin_dir . 'includes/class-settings.php');

            require_once( wpls_plugin_dir . 'includes/functions-settings-hook.php');
            require_once( wpls_plugin_dir . 'includes/functions-stats.php');
            require_once( wpls_plugin_dir . 'includes/class-functions.php');
            require_once( wpls_plugin_dir . 'includes/class-events.php');



            add_action('wp_enqueue_scripts', array($this, '_front_scripts'));
            add_action('admin_enqueue_scripts', array($this, '_admin_scripts'));
            add_action('plugins_loaded', array($this, '_textdomain'));
            add_filter('widget_text', 'do_shortcode');
            register_activation_hook(__FILE__, array($this, '_activation'));
            register_deactivation_hook(__FILE__, array($this, '_deactivation'));
            //register_uninstall_hook(__FILE__, array($this, 'wpls_uninstall'));

            add_filter('cron_schedules', array($this, 'cron_recurrence_interval'));


        }


        public function _textdomain(){

            $locale = apply_filters('plugin_locale', get_locale(), 'wp-live-statistics');
            load_textdomain('wp-live-statistics', WP_LANG_DIR . '/wp-live-statistics/wp-live-statistics-' . $locale . '.mo');

            load_plugin_textdomain('wp-live-statistics', false, plugin_basename(dirname(__FILE__)) . '/languages/');
        }


        public function _activation(){



            global $wpdb;

            $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "wpls"
                ."( UNIQUE KEY id (id),
					id int(100) NOT NULL AUTO_INCREMENT,
					session_id	VARCHAR( 255 )	NOT NULL,
					wpls_date	DATE NOT NULL,
					wpls_time	TIME NOT NULL,
					wpls_endtime	TIME NOT NULL,
					userid	VARCHAR( 50 )	NOT NULL,
					event	VARCHAR( 50 )	NOT NULL,
					browser	VARCHAR( 50 )	NOT NULL,
					platform	VARCHAR( 50 )	NOT NULL,
					ip	VARCHAR( 20 )	NOT NULL,
					city	VARCHAR( 50 )	NOT NULL,
					region	VARCHAR( 50 )	NOT NULL,
					countryName	VARCHAR( 50 )	NOT NULL,
					url_id	VARCHAR( 255 )	NOT NULL,
					url_term	VARCHAR( 255 )	NOT NULL,
					referer_doamin	VARCHAR( 255 )	NOT NULL,
					referer_url	TEXT NOT NULL,
					screensize	VARCHAR( 50 ) NOT NULL,
					isunique	VARCHAR( 50 ) NOT NULL,
					landing	VARCHAR( 10 ) NOT NULL

					)";
            $wpdb->query($sql);



            $sql2 = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "wpls_online"
                ."( UNIQUE KEY id (id),
					id int(100) NOT NULL AUTO_INCREMENT,
					session_id VARCHAR( 255 ) NOT NULL,
					wpls_time  DATETIME NOT NULL,
					userid	VARCHAR( 50 )	NOT NULL,
					url_id	VARCHAR( 255 )	NOT NULL,
					url_term	VARCHAR( 255 )	NOT NULL,
					city	VARCHAR( 50 )	NOT NULL,
					region	VARCHAR( 50 )	NOT NULL,
					countryName	VARCHAR( 50 )	NOT NULL,
					browser	VARCHAR( 50 )	NOT NULL,
					platform	VARCHAR( 50 )	NOT NULL,
					referer_doamin	VARCHAR( 255 )	NOT NULL,
					referer_url	TEXT NOT NULL
					)";
            $wpdb->query($sql2);


            do_action('wpls_activation');

        }


        public function wpls_uninstall(){


            $wpls_settings = get_option('wpls_settings');
            $delete_data = isset($wpls_settings['delete_data']) ? $wpls_settings['delete_data'] :  get_option( 'wpls_delete_data' );


            if($delete_data=='yes') {

                global $wpdb;
                $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}wpls" );
                $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}wpls_online" );

                delete_option( 'wpls_version' );
                delete_option( 'wpls_delete_data' );
                delete_option( 'wpls_customer_type' );
            }

            do_action('wpls_uninstall');
        }

        public function _deactivation(){

            //wp_clear_scheduled_hook('wpls_cron_upgrade_settings');

            do_action('wpls_deactivation');
        }


        function cron_recurrence_interval($schedules){

            $schedules['1minute'] = array(
                'interval' => 40,
                'display' => __('1 Minute', 'team')
            );



            return $schedules;
        }


        public function _front_scripts(){

            wp_enqueue_script('jquery');

            wp_register_style('font-awesome-5', wpls_plugin_url . 'assets/admin/css/fontawesome.css');

            do_action('wpls_front_scripts');
        }

        public function _admin_scripts(){
            $screen = get_current_screen();

            //var_dump($screen);

            wp_enqueue_script('jquery');

            wp_register_style('font-awesome-4', wpls_plugin_url.'assets/global/css/font-awesome-4.css');
            wp_register_style('font-awesome-5', wpls_plugin_url.'assets/global/css/font-awesome-5.css');

            wp_register_style('settings-tabs', wpls_plugin_url.'assets/settings-tabs/settings-tabs.css');
            wp_register_script('settings-tabs', wpls_plugin_url.'assets/settings-tabs/settings-tabs.js'  , array( 'jquery' ));
            wp_register_script('chart.js', wpls_plugin_url. 'assets/admin/js/chart.js', array( 'jquery' ));
            wp_register_script('wp-live-statistics-js', wpls_plugin_url. 'assets/admin/js/scripts.js', array( 'jquery' ));
            wp_localize_script( 'wp-live-statistics-js', 'wpls_ajax', array( 'wpls_ajaxurl' => admin_url( 'admin-ajax.php')));


            wp_enqueue_style('wpls-style', wpls_plugin_url.'assets/admin/css/style.css');

            wp_enqueue_script('jquery-ui-datepicker');
            wp_enqueue_style('wp-live-statistics-flags', wpls_plugin_url.'assets/admin/css/flags.css');
            wp_enqueue_style('jquery-ui', wpls_plugin_url.'assets/admin/css/jquery-ui.css');


            if ($screen->id == 'wp-live-stats_page_wpls_settings'){
                $settings_tabs_field = new settings_tabs_field();
                $settings_tabs_field->admin_scripts();
            }


            do_action('wpls_admin_scripts');
        }

    }
}


new WPLiveStatistics();
