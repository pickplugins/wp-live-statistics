<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

class class_wpls_settings{

    public function __construct(){

		add_action( 'admin_menu', array( $this, 'wpls_menu_init' ), 12 );

		}



	
	public	function wpls_menu_init(){

        add_menu_page(__('WP Live Stats', 'breadcrumb'), __('WP Live Stats', 'breadcrumb'), 'manage_options', 'wp-live-statistics', array( $this, 'wpls_dashboard' ), 'dashicons-arrow-right-alt');
        add_submenu_page( 'wp-live-statistics', __( 'Settings', 'accordions' ), __( 'Settings', 'accordions' ), 'manage_options', 'wpls_settings', array( $this, 'wpls_settings' ) );
        add_submenu_page( 'wp-live-statistics', __( 'Live Visitors', 'accordions' ), __( 'Live Visitors', 'accordions' ), 'manage_options', 'wpls_admin_online', array( $this, 'wpls_admin_online' ) );
        add_submenu_page( 'wp-live-statistics', __( 'Visitors', 'accordions' ), __( 'Visitors', 'accordions' ), 'manage_options', 'wpls_admin_visitors', array( $this, 'wpls_admin_visitors' ) );
        add_submenu_page( 'wp-live-statistics', __( 'Filter', 'accordions' ), __( 'Filter', 'accordions' ), 'manage_options', 'wpls_admin_filter', array( $this, 'wpls_admin_filter' ) );



    }

    function wpls_settings(){
        include('menu/settings.php');
    }


    function wpls_dashboard(){
        include('menu/wpls-dashboard.php');
    }



    function wpls_admin_online(){
        include('menu/wpls-admin-online.php');
    }

    function wpls_admin_visitors(){
        include('menu/wpls-admin-visitors.php');
    }

    function wpls_admin_geo(){
        include('menu/wpls-admin-geo.php');
    }

    function wpls_admin_filter(){
        include('menu/stats.php');
    }


}
	
new class_wpls_settings();