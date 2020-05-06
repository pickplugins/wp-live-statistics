<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

add_action('wpls_settings_content_general', 'wpls_settings_content_general');

function wpls_settings_content_general(){
    $settings_tabs_field = new settings_tabs_field();

    $wpls_settings = get_option('wpls_settings');

    $wpls_refresh_time = get_option( 'wpls_refresh_time' );
    $wpls_delete_data = get_option( 'wpls_delete_data' );
    $wpls_google_api_key = get_option( 'wpls_google_api_key' );



    $font_aw_version = isset($wpls_settings['font_aw_version']) ? $wpls_settings['font_aw_version'] : 'none';
    $refresh_time = isset($wpls_settings['refresh_time']) ? $wpls_settings['refresh_time'] : $wpls_refresh_time;
    $google_api_key = isset($wpls_settings['google_api_key']) ? $wpls_settings['google_api_key'] : $wpls_google_api_key;
    $delete_data = isset($wpls_settings['delete_data']) ? $wpls_settings['delete_data'] : $wpls_delete_data;

    //echo '<pre>'.var_export($wpls_settings, true).'</pre>';

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('General', 'wp-live-statistics'); ?></div>
        <p class="description section-description"><?php echo __('Choose some general options.', 'wp-live-statistics'); ?></p>

        <?php



        $args = array(
            'id'		=> 'font_aw_version',
            'parent'		=> 'wpls_settings',
            'title'		=> __('Font-awesome version','wp-live-statistics'),
            'details'	=> __('Choose font awesome version you want to load.','wp-live-statistics'),
            'type'		=> 'select',
            'value'		=> $font_aw_version,
            'default'		=> '',
            'args'		=> array('v_5'=>__('Version 5+','wp-live-statistics'), 'v_4'=>__('Version 4+','wp-live-statistics'), 'none'=>__('None','wp-live-statistics')  ),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'refresh_time',
            'parent'		=> 'wpls_settings',
            'title'		=> __('Refresh time','wp-live-statistics'),
            'details'	=> __('Automatic refresh to check online, ex: 1000 = 1 second.','wp-live-statistics'),
            'type'		=> 'text',
            'value'		=> $refresh_time,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'		=> 'google_api_key',
            'parent'		=> 'wpls_settings',
            'title'		=> __('Google map api key','wp-live-statistics'),
            'details'	=> __('Write Google map api key here, <a href="https://developers.google.com/maps/documentation/javascript/adding-a-google-map#key"> Get an API key</a>','wp-live-statistics'),
            'type'		=> 'text',
            'value'		=> $google_api_key,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'delete_data',
            'parent'		=> 'wpls_settings',
            'title'		=> __('Font-awesome version','wp-live-statistics'),
            'details'	=> __('Choose font awesome version you want to load.','wp-live-statistics'),
            'type'		=> 'select',
            'value'		=> $delete_data,
            'default'		=> 'no',
            'args'		=> array('no'=>__('No','wp-live-statistics'), 'yes'=>__('Yes','wp-live-statistics')  ),
        );

        $settings_tabs_field->generate_field($args);


        ?>

    </div>

    <?php





}


add_action('wpls_settings_content_help_support', 'wpls_settings_content_help_support');

if(!function_exists('wpls_settings_content_help_support')) {
    function wpls_settings_content_help_support($tab){

        $settings_tabs_field = new settings_tabs_field();

        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Get support', 'wp-live-statistics'); ?></div>
            <p class="description section-description"><?php echo __('Use following to get help and support from our expert team.', 'wp-live-statistics'); ?></p>

            <?php


            ob_start();
            ?>

            <p><?php echo __('Ask question for free on our forum and get quick reply from our expert team members.', 'wp-live-statistics'); ?></p>
            <a class="button" href="https://www.pickplugins.com/create-support-ticket/"><?php echo __('Create support ticket', 'wp-live-statistics'); ?></a>

            <p><?php echo __('Read our documentation before asking your question.', 'wp-live-statistics'); ?></p>
            <a class="button" href="https://www.pickplugins.com/documentation/wp-live-statistics/"><?php echo __('Documentation', 'wp-live-statistics'); ?></a>

            <p><?php echo __('Watch video tutorials.', 'wp-live-statistics'); ?></p>
            <a class="button" href="https://www.youtube.com/playlist?list=PL0QP7T2SN94b6bbzvUBK_7pK9TfqQqy6E"><i class="fab fa-youtube"></i> <?php echo __('All tutorials', 'wp-live-statistics'); ?></a>

            <ul>
<!--                <li><i class="far fa-dot-circle"></i> <a href="https://youtu.be/YVtsIbEb9zs">Latest Version 2.0.46 Overview</a></li>-->

            </ul>



            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'get_support',
                //'parent'		=> '',
                'title'		=> __('Ask question','wp-live-statistics'),
                'details'	=> '',
                'type'		=> 'custom_html',
                'html'		=> $html,

            );

            $settings_tabs_field->generate_field($args);


            ob_start();
            ?>

            <p class="">We wish your 2 minutes to write your feedback about the <b>Post Grid</b> plugin. give us <span style="color: #ffae19"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>

            <a target="_blank" href="https://wordpress.org/support/plugin/wp-live-statistics/reviews/#new-post" class="button"><i class="fab fa-wordpress"></i> Write a review</a>


            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'reviews',
                //'parent'		=> '',
                'title'		=> __('Submit reviews','wp-live-statistics'),
                'details'	=> '',
                'type'		=> 'custom_html',
                'html'		=> $html,

            );

            $settings_tabs_field->generate_field($args);



            ?>


        </div>
        <?php


    }
}














add_action('wpls_settings_save', 'wpls_settings_save');

function wpls_settings_save(){

    $wpls_settings = isset($_POST['wpls_settings']) ?  stripslashes_deep($_POST['wpls_settings']) : array();
    update_option('wpls_settings', $wpls_settings);
}
