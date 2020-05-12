<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

if(!class_exists('WPLiveStatisticsEvents')){
    class WPLiveStatisticsEvents{

        public function __construct(){



            add_action( 'publish_post', array( $this, '_publish_post' ), 10, 2 );
            add_action( 'save_post', array( $this, '_save_post' ), 10, 3 );
            add_action( 'deleted_post', array( $this, '_deleted_post' ) );
            add_action( 'trashed_post', array( $this, '_trashed_post' ) );
            add_action( 'untrashed_post', array( $this, '_untrashed_post' ) );

            add_action( 'delete_attachment', array( $this, '_delete_attachment' ) );
            add_action( 'edit_attachment', array( $this, '_edit_attachment' ) );
            add_action( 'add_attachment', array( $this, '_add_attachment' ) );

            add_action( 'wp_insert_comment', array( $this, '_insert_comment' ) );
            add_action( 'edit_comment', array( $this, '_edit_comment' ) );
            add_action( 'trash_comment', array( $this, '_trash_comment' ) );
            add_action( 'untrash_comment', array( $this, '_untrash_comment' ) );
            add_action( 'spam_comment', array( $this, '_spam_comment' ) );
            add_action( 'unspam_comment', array( $this, '_unspam_comment' ) );
            add_action( 'delete_comment', array( $this, '_delete_comment' ) );

            add_action( 'switch_theme', array( $this, '_switch_theme' ) );
            //add_action( 'delete_site_transient_update_themes', array( $this, '_delete_site_transient_update_themes' ) );
            //add_action( 'upgrader_process_complete', array( $this, 'wp_a_log_upgrader_process_complete' ), 10, 2 );

            add_action( 'activated_plugin', array( $this, '_activated_plugin' ) );
            add_action( 'deactivated_plugin', array( $this, '_deactivated_plugin' ) );
            //add_action( 'delete_plugins', array( $this, '_delete_plugins' ) );

            add_action( 'wp_login', array( $this, '_wp_login' ) );
            add_action( 'wp_logout', array( $this, '_wp_logout' ) );


            add_action( 'profile_update', array( $this, '_profile_update' ) );
            add_action( 'delete_user', array( $this, '_delete_user' ) );
            add_action( 'user_register', array( $this, '_user_register' ) );
            add_action( 'wp_login_failed', array( $this, '_login_failed' ) );




        }


        function _save_post( $post_id, $post, $update ) {

            // Only want to set if this is a new post!
            if ( $update ){

                $args = array();

                $args['event'] = 'post_updated';
                $args['url_id'] = $post_id;


                $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
                $WPLiveStatisticsFunctions->wpls_insert_visit($args);

                //return;
            }

        }


        function _publish_post($ID, $post){

            $args = array();
            $args['event'] = 'publish_post';
            $args['url_id'] = $ID;

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);


        }






        function _deleted_post($ID){

            $args = array();
            $args['event'] = 'deleted_post';
            $args['url_id'] = $ID;

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);

        }


        function _trashed_post($ID){

            $args = array();
            $args['event'] = 'trashed_post';
            $args['url_id'] = $ID;

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }


        function _untrashed_post($ID){

            $args = array();
            $args['event'] = 'untrashed_post';
            $args['url_id'] = $ID;

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);

        }



        function _insert_comment($ID){

            $args = array();
            $args['event'] = 'new_comment';
            $args['url_id'] = $ID;

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);

        }



        function _edit_comment($ID){

            $args = array();
            $args['event'] = 'edit_comment';
            $args['url_id'] = $ID;

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }



        function _trash_comment($ID){

            $args = array();
            $args['event'] = 'trash_comment';
            $args['url_id'] = $ID;

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }


        function _untrash_comment($ID){

            $args = array();
            $args['event'] = 'untrash_comment';
            $args['url_id'] = $ID;

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }

        function _spam_comment($ID){

            $args = array();
            $args['event'] = 'spam_comment';
            $args['url_id'] = $ID;

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }


        function _unspam_comment($ID){

            $args = array();
            $args['event'] = 'unspam_comment';
            $args['url_id'] = $ID;

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }

        function _delete_comment($ID){

            $args = array();
            $args['event'] = 'delete_comment';
            $args['url_id'] = $ID;

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }



        function _switch_theme($name){

            $args = array();
            $args['event'] = 'switch_theme';

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }


        function _delete_site_transient_update_themes($name){

            $args = array();
            $args['event'] = 'update_themes';

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }


        function wp_a_log_upgrader_process_complete($upgrader, $extra){

            $args = array();
            $args['event'] = 'update_themes';

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }





        function _delete_plugins($plugin_name){


            $args = array();
            $args['event'] = 'delete_plugins';

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }



        function _activated_plugin($plugin_name){


            $args = array();
            $args['event'] = 'activated_plugin';

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }


        function _deactivated_plugin($plugin_name){

            $args = array();
            $args['event'] = 'deactivated_plugin';

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }


        function _wp_login($ID){


            $args = array();
            $args['event'] = 'login';

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }


        function _wp_logout(){

            $args = array();
            $args['event'] = 'logout';

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }





        function _login_failed($ID){

            $args = array();
            $args['event'] = 'login_failed';

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);

        }




        function _user_register($ID){

            $args = array();
            $args['event'] = 'user_register';

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }


        function _delete_user($ID){

            $args = array();
            $args['event'] = 'delete_user';

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }



        function _profile_update($user_id){

            $args = array();
            $args['event'] = 'profile_update';

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }


        function _add_attachment($ID){


            $args = array();
            $args['event'] = 'add_attachment';
            $args['url_id'] = $ID;

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }



        function _edit_attachment($ID){

            $args = array();
            $args['event'] = 'edit_attachment';
            $args['url_id'] = $ID;

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }



        function _delete_attachment($ID){

            $args = array();
            $args['event'] = 'edit_attachment';
            $args['url_id'] = $ID;

            $WPLiveStatisticsFunctions = new WPLiveStatisticsFunctions();
            $WPLiveStatisticsFunctions->wpls_insert_visit($args);
        }








    }
}

new WPLiveStatisticsEvents();