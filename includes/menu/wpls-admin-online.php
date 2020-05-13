<?php

$wpls_settings = get_option('wpls_settings');
$refresh_time = isset($wpls_settings['refresh_time']) ? $wpls_settings['refresh_time'] : 10000;

$refresh_time = ($refresh_time > 3000) ? $refresh_time : 10000;



?>



<div class="wrap">
    <h2><?php echo sprintf(__('%s  - Visitors Online', 'job-board-manager'), wpls_plugin_name); ?></h2><br>

    <div class="onlinecount">

    <span class="count"></span><br />
    <span class="script"><script>var address = []; </script></span><br />

    Total User Online
    </div>





    <script>
        setInterval(function(){

            jQuery.ajax({
                type: 'POST',
                url: wpls_ajax.wpls_ajaxurl,
                data: {"action": "wpls_ajax_online_total"},
                success: function(data) {
                    jQuery(".onlinecount .count").html(data);
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
