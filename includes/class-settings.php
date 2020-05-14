<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

class class_wpls_settings{

    public function __construct(){

		add_action( 'admin_menu', array( $this, 'wpls_menu_init' ), 12 );

		}



	
	public	function wpls_menu_init(){

        add_menu_page(__('WP Live Stats', 'breadcrumb'), __('WP Live Stats', 'breadcrumb'), 'manage_options', 'wp-live-statistics', array( $this, 'dashboard' ), 'dashicons-chart-line');
        add_submenu_page( 'wp-live-statistics', __( 'Settings', 'accordions' ), __( 'Settings', 'accordions' ), 'manage_options', 'wpls_settings', array( $this, 'wpls_settings' ) );
        add_submenu_page( 'wp-live-statistics', __( 'Visitors - Online', 'accordions' ), __( 'Visitors - Online', 'accordions' ), 'manage_options', 'wpls_visitors_online', array( $this, 'wpls_visitors_online' ) );
        add_submenu_page( 'wp-live-statistics', __( 'Visitors', 'accordions' ), __( 'Visitors', 'accordions' ), 'manage_options', 'wpls_visitors', array( $this, 'wpls_visitors' ) );
        add_submenu_page( 'wp-live-statistics', __( 'Filter', 'accordions' ), __( 'Filter', 'accordions' ), 'manage_options', 'wpls_filter', array( $this, 'wpls_filter' ) );
        add_submenu_page( 'wp-live-statistics', __( 'Page View', 'accordions' ), __( 'Page View', 'accordions' ), 'manage_options', 'wpls_page_view', array( $this, 'wpls_page_view' ) );



    }

    function wpls_settings(){
        include('menu/settings.php');
    }


    function dashboard(){
        include('menu/dashboard.php');
    }



    function wpls_visitors_online(){
        include('menu/visitors-online.php');
    }

    function wpls_visitors(){
        include('menu/visitors.php');
    }

    function geo(){
        include('menu/geo.php');
    }

    function wpls_filter(){
        include('menu/stats.php');
    }
    function wpls_page_view(){
        include('menu/page-view.php');
    }

}
	
new class_wpls_settings();