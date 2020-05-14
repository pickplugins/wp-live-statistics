<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

if(!class_exists('WPLiveStatisticsFunctions')){
    class WPLiveStatisticsFunctions{

        public function __construct(){

            //add_action( 'admin_menu', array( $this, 'wpls_menu_init' ), 12 );
            //add_action( 'wp_head', array( $this, 'wpls_visit' ), 12 );

        }


        function wpls_insert_visit($args){

            $wpls_settings = get_option('wpls_settings');
            $exclude_bots = isset($wpls_settings['exclude_bots']) ? $wpls_settings['exclude_bots'] : 'no';


            // date time data
            $wpls_date = wpls_get_date();
            $wpls_time = wpls_get_time();
            $wpls_datetime = wpls_get_datetime();
            $wpls_endtime = $wpls_datetime;


            //device data
            $Browser = new Browser();
            $platform = $Browser->getPlatform();
            $browser = $Browser->getBrowser();
            $screensize = wpls_get_screensize();


            if(strpos($browser,'Bot' ) && $exclude_bots == 'yes') return;

            // geo data
            $ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
            $geoplugin = new geoPlugin();
            $geoplugin->locate();
            $city = isset($geoplugin->city) ? $geoplugin->city : '';
            $region = isset($geoplugin->region) ? $geoplugin->region : '';
            $countryName = isset($geoplugin->countryCode) ? $geoplugin->countryCode : '';

            //referer data
            $referer = wpls_get_referer();
            $referer = explode(',',$referer);
            $referer_doamin = isset($referer['0']) ? $referer['0'] : '';
            $referer_url = isset($referer['1']) ? $referer['1'] : '';


            // url and page data
            $userid = wpls_getuser();
            $url_id_array = wpls_geturl_id();
            $url_id_array = explode(',',$url_id_array);
            $url_id = isset($url_id_array['0']) ?$url_id_array['0'] : '';
            $url_term = isset($url_id_array['1']) ? $url_id_array['1'] : '';

            $session_id = wpls_session();;
            $isunique = wpls_get_unique();;
            $landing = wpls_landing();;



            $session_id = isset($args['session_id']) ? $args['session_id'] : $session_id;
            $wpls_date = isset($args['wpls_date']) ? $args['wpls_date'] : $wpls_date;
            $wpls_datetime = isset($args['wpls_datetime']) ? $args['wpls_datetime'] : $wpls_datetime;

            $wpls_time = isset($args['wpls_time']) ? $args['wpls_time'] : $wpls_time;
            $wpls_endtime = isset($args['wpls_endtime']) ? $args['wpls_endtime'] : $wpls_endtime;
            $userid = isset($args['userid']) ? $args['userid'] : $userid;
            $event = isset($args['event']) ? $args['event'] : '';
            $browser = isset($args['browser']) ? $args['browser'] : $browser;
            $platform = isset($args['platform']) ? $args['platform'] : $platform;
            $ip = isset($args['ip']) ? $args['ip'] : $ip;
            $city = isset($args['city']) ? $args['city'] : $city;
            $region = isset($args['region']) ? $args['region'] : $region;
            $countryName= isset($args['countryName']) ? $args['countryName'] : $countryName;
            $url_id = isset($args['url_id']) ? $args['url_id'] : $url_id;
            $url_term = isset($args['url_term']) ? $args['url_term'] : $url_term;
            $referer_doamin = isset($args['referer_doamin']) ? $args['referer_doamin'] : $referer_doamin;
            $referer_url = isset($args['referer_url']) ? $args['referer_url'] : $referer_url;
            $screensize = isset($args['screensize']) ? $args['screensize'] : $screensize;
            $isunique = isset($args['isunique']) ? $args['isunique'] : $isunique;
            $landing = isset($args['landing']) ? $args['landing'] : $landing;


            global $wpdb;
            $table = $wpdb->prefix . "wpls";

            $wpdb->query( $wpdb->prepare("INSERT INTO $table 
								( id, session_id, wpls_date, wpls_time, wpls_endtime, userid, event, browser, platform, ip, city, region, countryName, url_id, url_term, referer_doamin, referer_url, screensize, isunique, landing )
			VALUES	( %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",
                array	( '', $session_id, $wpls_date, $wpls_time, $wpls_endtime, $userid, $event, $browser, $platform, $ip, $city, $region, $countryName, $url_id, $url_term, $referer_doamin, $referer_url, $screensize, $isunique, $landing )
            ));

        }




        function wpls_insert_online($args){


            // date time data
            $wpls_date = wpls_get_date();
            $wpls_time = wpls_get_time();
            $wpls_datetime = wpls_get_datetime();
            $wpls_endtime = $wpls_datetime;


            //device data
            $Browser = new Browser();
            $platform = $Browser->getPlatform();
            $browser = $Browser->getBrowser();
            $screensize = wpls_get_screensize();



            // geo data
            $ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
            $geoplugin = new geoPlugin();
            $geoplugin->locate();
            $city = isset($geoplugin->city) ? $geoplugin->city : '';
            $region = isset($geoplugin->region) ? $geoplugin->region : '';
            $countryName = isset($geoplugin->countryCode) ? $geoplugin->countryCode : '';

            //referer data
            $referer = wpls_get_referer();
            $referer = explode(',',$referer);
            $referer_doamin = isset($referer['0']) ? $referer['0'] : '';
            $referer_url = isset($referer['1']) ? $referer['1'] : '';


            // url and page data
            $userid = wpls_getuser();
            $url_id_array = wpls_geturl_id();
            $url_id_array = explode(',',$url_id_array);
            $url_id = isset($url_id_array['0']) ?$url_id_array['0'] : '';
            $url_term = isset($url_id_array['1']) ? $url_id_array['1'] : '';

            $session_id = wpls_session();;
            $isunique = wpls_get_unique();;
            $landing = wpls_landing();;



            $session_id = isset($args['session_id']) ? $args['session_id'] : $session_id;
            $wpls_date = isset($args['wpls_date']) ? $args['wpls_date'] : $wpls_date;
            $wpls_datetime = isset($args['wpls_datetime']) ? $args['wpls_datetime'] : $wpls_datetime;

            $wpls_time = isset($args['wpls_time']) ? $args['wpls_time'] : $wpls_time;
            $wpls_endtime = isset($args['wpls_endtime']) ? $args['wpls_endtime'] : $wpls_endtime;
            $userid = isset($args['userid']) ? $args['userid'] : $userid;
            $event = isset($args['event']) ? $args['event'] : '';
            $browser = isset($args['browser']) ? $args['browser'] : $browser;
            $platform = isset($args['platform']) ? $args['platform'] : $platform;
            $ip = isset($args['ip']) ? $args['ip'] : $ip;
            $city = isset($args['city']) ? $args['city'] : $city;
            $region = isset($args['region']) ? $args['region'] : $region;
            $countryName= isset($args['countryName']) ? $args['countryName'] : $countryName;
            $url_id = isset($args['url_id']) ? $args['url_id'] : $url_id;
            $url_term = isset($args['url_term']) ? $args['url_term'] : $url_term;
            $referer_doamin = isset($args['referer_doamin']) ? $args['referer_doamin'] : $referer_doamin;
            $referer_url = isset($args['referer_url']) ? $args['referer_url'] : $referer_url;
            $screensize = isset($args['screensize']) ? $args['screensize'] : $screensize;
            $isunique = isset($args['isunique']) ? $args['isunique'] : $isunique;
            $landing = isset($args['landing']) ? $args['landing'] : $landing;



            global $wpdb;

            $table = $wpdb->prefix . "wpls_online";
            $result = $wpdb->get_results("SELECT * FROM $table WHERE session_id='$session_id'", ARRAY_A);
            $count = $wpdb->num_rows;


            if(empty($count)) {

                $wpdb->query( $wpdb->prepare("INSERT INTO $table 
								( id, session_id, wpls_time, userid, url_id, url_term, city, region, countryName, browser, platform, referer_doamin, referer_url) VALUES	(%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                    array( '', $session_id, $wpls_datetime, $userid, $url_id, $url_term, $city, $region, $countryName, $browser, $platform, $referer_doamin, $referer_url)
                ));
            }
            else{

                $wpdb->query("UPDATE $table SET wpls_time='$wpls_datetime', url_id='$url_id', referer_doamin='$referer_doamin', referer_url='$referer_url' WHERE session_id='$session_id'");
            }

        }










    }
}

	
//new class_wpls_settings();