<?php

$wpls_settings = get_option('wpls_settings');
$refresh_time = isset($wpls_settings['refresh_time']) ? $wpls_settings['refresh_time'] : 10000;

$refresh_time = ($refresh_time > 3000) ? $refresh_time : 10000;


wp_enqueue_script( 'wp-live-statistics-js' );

?>



<div class="wrap">
    <h2><?php echo sprintf(__('%s  - Visitors Online', 'job-board-manager'), wpls_plugin_name); ?>: <span class="onlinecount">...</span></h2>

     <style type="text/css">
        .onlinecount{}
        .onlinecount .count{}

    </style>



    <script>
        setInterval(function(){

            jQuery.ajax({
                type: 'POST',
                url: wpls_ajax.wpls_ajaxurl,
                data: {"action": "wpls_ajax_online_total"},
                success: function(data) {
                    jQuery(".onlinecount").html(data);
                }
            });
        }, <?php echo $refresh_time; ?>)

        jQuery(document).ready(function($){

            setInterval(function(){
                $.ajax(
                        {
                    type: 'POST',
                    url: wpls_ajax.wpls_ajaxurl,
                    data: {"action": "wpls_visitors_page"},
                    success: function(data)
                            {
                                $(".visitors").html(data);
                            }
                        });
            }, <?php echo $refresh_time; ?>)


        });

    </script>


    <div class="visitors"></div>

    <style type="text/css">
        .visitors tr:nth-child(even) {background: #f5f5f5}
        .visitors tr:nth-child(odd) {background: #FFF}
    </style>



</div>
