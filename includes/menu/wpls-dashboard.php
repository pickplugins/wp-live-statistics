<?php
if ( ! defined('ABSPATH')) exit;  // if direct access


wp_enqueue_style( 'font-awesome-5' );
wp_enqueue_script('chart.js');
?>

<div class="wrap">
    <h2><?php echo sprintf(__('%s  - Dashboard', 'job-board-manager'), wpls_plugin_name); ?></h2><br>

    <div class="wpls-dashboard">



        <div class="page-visit" style="position: relative; height:40vh; width:80vw" >

            <?php
            $page_visit = wpls_page_visit();
            ?>
            <canvas id="page-visit-cart" height="40vh"></canvas>

            <script>

                page_visit = '<?php echo $page_visit; ?>';
                var page_visit = JSON.parse( page_visit );


                backgroundColor = ['#c060a1', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 0.2)'];
                //console.log(typeof labels);

                jQuery(document).ready(function($) {

                    var ctx = document.getElementById('page-visit-cart');
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: page_visit.labels,
                            datasets: [{
                                label: 'Page view',
                                data: page_visit.data,
                                //backgroundColor: backgroundColor,
                                borderColor:'rgb(73, 98, 128)',
                                borderWidth:1,
                                pointHoverBackgroundColor: 'rgb(73, 98, 128)',
                                pointBorderWidth: 1,
                                pointHitRadius: 5,
                                pointHoverBorderWidth: 15,

                            }]
                        },
                    });

                })


            </script>






        </div>



        <div class="dash-box">
            <div class="dash-box-title"><?php echo sprintf("%s Visitor Online", '<i class="fas fa-mobile-alt"></i> ') ?></div>
            <div class="dash-box-info">Estimate total visitor online right now on your website. <?php echo wpls_get_datetime(); ?></div>
            <div class="total-online">0</div>



            <?php

            $wpls_settings = get_option('wpls_settings');
            $refresh_time = isset($wpls_settings['refresh_time']) ? $wpls_settings['refresh_time'] : 10000;

            $refresh_time = ($refresh_time > 3000) ? $refresh_time : 10000;


            ?>

            <script>
                jQuery(document).ready(function($)
                    {

                        setInterval(function(){
                            $.ajax(
                                    {
                                type: 'POST',
                                url: wpls_ajax.wpls_ajaxurl,
                                data: {"action": "wpls_ajax_online_total"},
                                success: function(data)
                                        {
                                            $(".total-online").html(data);
                                        }
                                    });
                        }, <?php echo $refresh_time; ?>)
                                });

            </script>


        </div>






        <div class="dash-box">
            <div class="dash-box-title"><?php echo sprintf("%s Total Visitor", '<i class="fas fa-mobile-alt"></i> ') ?></span></div>
            <div class="dash-box-info">Estimate total visitor session. </div>
            <div class="total-session"><?php echo wpls_TotalSession("session_id"); ?></div>
        </div>


        <div class="dash-box">
            <div class="dash-box-title"><?php echo sprintf("%s Unique Visitor", '<i class="fas fa-mobile-alt"></i> ') ?></div>
            <div class="dash-box-info">Estimate unique visitor. </div>
            <div class="unique-visitor"><?php echo wpls_UniqueVisitor("ip"); ?></div>
        </div>

        <div class="dash-box">
            <div class="dash-box-title"><?php echo sprintf("%s Unique Page View", '<i class="fas fa-mobile-alt"></i> ') ?></div>
            <div class="dash-box-info">Estimate unique page view. </div>
            <div class="unique-visitor"><?php echo wpls_UniquePageView("isunique"); ?></div>
        </div>





        <div class="dash-box">
            <div class="dash-box-title"><?php echo sprintf("%s Top OS", '<i class="fas fa-mobile-alt"></i> ') ?></div>
            <div class="dash-box-info">Stats based on top operating system.</div>

            <?php
            $wpls_top_os = wpls_top_os();
            ?>
            <canvas id="top_os" ></canvas>

            <script>

                wpls_top_os = '<?php echo $wpls_top_os; ?>';
                var wpls_top_os = JSON.parse( wpls_top_os );


                backgroundColor = ['#c060a1', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 0.2)'];
                //console.log(typeof labels);

                jQuery(document).ready(function($) {

                    var ctx = document.getElementById('top_os');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: wpls_top_os.labels,
                            datasets: [{
                                label: 'Operating System',
                                data: wpls_top_os.data,
                                backgroundColor: backgroundColor,
                                borderColor:'rgba(255, 99, 132, 0.2)',
                                borderWidth:1,
                                pointHoverBackgroundColor: 'rgba(0, 115, 169, 0.1)',
                                pointBorderWidth: 1,
                                pointHitRadius: 5,
                                pointHoverBorderWidth: 15,

                            }]
                        },
                    });

                })


            </script>






        </div>

        <div class="dash-box">
        <div class="dash-box-title"><?php echo sprintf("%s Top Screen Size", '<i class="fas fa-mobile-alt"></i> ') ?></div>
        <div class="dash-box-info">Top device screen size.</div>

            <?php
            $wpls_top_screensize = wpls_top_screensize();
            ?>
            <canvas id="top_screensize" ></canvas>

            <script>

                wpls_top_screensize = '<?php echo $wpls_top_screensize; ?>';
                var wpls_top_screensize = JSON.parse( wpls_top_screensize );

                backgroundColor = ['#c060a1', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 0.2)'];
                //console.log(typeof labels);

                jQuery(document).ready(function($) {

                    var ctx = document.getElementById('top_screensize');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels:  wpls_top_screensize.labels,
                            datasets: [{
                                label: 'Screen Size',
                                data: wpls_top_screensize.data,
                                backgroundColor: backgroundColor,
                                borderColor:'rgba(255, 99, 132, 0.2)',
                                borderWidth:1,
                                pointHoverBackgroundColor: 'rgba(0, 115, 169, 0.1)',
                                pointBorderWidth: 1,
                                pointHitRadius: 5,
                                pointHoverBorderWidth: 15,

                            }]
                        },
                    });

                })


            </script>


        </div>


        <div class="dash-box">
        <div class="dash-box-title"><?php echo sprintf("%s Top Browsers", '<i class="fas fa-mobile-alt"></i> ') ?></div>
        <div class="dash-box-info">Top browsers by view count.</div>



            <?php
            $wpls_top_browsers = wpls_top_browsers();
            ?>
            <canvas id="top_browsers" ></canvas>

            <script>

                wpls_top_browsers = '<?php echo $wpls_top_browsers; ?>';
                var wpls_top_browsers = JSON.parse( wpls_top_browsers );


                backgroundColor = ['#c060a1', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 0.2)'];
                //console.log(typeof labels);

                jQuery(document).ready(function($) {

                    var ctx = document.getElementById('top_browsers');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: wpls_top_browsers.labels,
                            datasets: [{
                                label: 'Browser',
                                data: wpls_top_browsers.data,
                                backgroundColor: backgroundColor,
                                borderColor:'rgba(255, 99, 132, 0.2)',
                                borderWidth:1,
                                pointHoverBackgroundColor: 'rgba(0, 115, 169, 0.1)',
                                pointBorderWidth: 1,
                                pointHitRadius: 5,
                                pointHoverBorderWidth: 15,

                            }]
                        },
                    });

                })


            </script>


        </div>

        <div class="dash-box">
        <div class="dash-box-title"><?php echo sprintf("%s Top Page Terms", '<i class="fas fa-mobile-alt"></i> ') ?></div>
        <div class="dash-box-info">Top link category.</div>

            <?php
            $wpls_top_url_terms = wpls_top_url_terms();
            ?>
            <canvas id="top_url_terms" ></canvas>

            <script>

                wpls_top_url_terms = '<?php echo $wpls_top_url_terms; ?>';
                var wpls_top_url_terms = JSON.parse( wpls_top_url_terms );

                backgroundColor = ['#c060a1', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 0.2)'];
                //console.log(typeof labels);

                jQuery(document).ready(function($) {

                    var ctx = document.getElementById('top_url_terms');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: wpls_top_url_terms.labels,
                            datasets: [{
                                label: 'URL terms',
                                data: wpls_top_url_terms.data,
                                backgroundColor: backgroundColor,
                                borderColor:'rgba(255, 99, 132, 0.2)',
                                borderWidth:1,
                                pointHoverBackgroundColor: 'rgba(0, 115, 169, 0.1)',
                                pointBorderWidth: 1,
                                pointHitRadius: 5,
                                pointHoverBorderWidth: 15,

                            }]
                        },
                    });

                })


            </script>

        </div>


        <div class="dash-box">
        <div class="dash-box-title"><?php echo sprintf("%s Top Countries", '<i class="fas fa-mobile-alt"></i> ') ?></div>
        <div class="dash-box-info">Top country by view count.</div>

            <?php
            $wpls_top_countries = wpls_top_countries();
            ?>
            <canvas id="top_countries" ></canvas>

            <script>

                wpls_top_countries = '<?php echo $wpls_top_countries; ?>';
                var wpls_top_countries = JSON.parse( wpls_top_countries );

                backgroundColor = ['#c060a1', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 0.2)'];
                //console.log(typeof labels);

                jQuery(document).ready(function($) {

                    var ctx = document.getElementById('top_countries');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: wpls_top_countries.labels,
                            datasets: [{
                                label: 'Countries',
                                data: wpls_top_countries.data,
                                backgroundColor: backgroundColor,
                                borderColor:'rgba(255, 99, 132, 0.2)',
                                borderWidth:1,
                                pointHoverBackgroundColor: 'rgba(0, 115, 169, 0.1)',
                                pointBorderWidth: 1,
                                pointHitRadius: 5,
                                pointHoverBorderWidth: 15,

                            }]
                        },
                    });

                })


            </script>

        </div>
        <div class="dash-box">
        <div class="dash-box-title"><?php echo sprintf("%s Top Cities", '<i class="fas fa-mobile-alt"></i> ') ?></div>
        <div class="dash-box-info">Top city by view count.</div>

            <?php
            $wpls_top_cities = wpls_top_cities();
            ?>
            <canvas id="top_cities" ></canvas>

            <script>

                wpls_top_cities = '<?php echo $wpls_top_cities; ?>';
                var wpls_top_cities = JSON.parse( wpls_top_cities );

                backgroundColor = ['#c060a1', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 0.2)'];
                //console.log(typeof labels);

                jQuery(document).ready(function($) {

                    var ctx = document.getElementById('top_cities');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: wpls_top_cities.labels,
                            datasets: [{
                                label: 'Cities',
                                data: wpls_top_cities.data,
                                backgroundColor: backgroundColor,
                                borderColor:'rgba(255, 99, 132, 0.2)',
                                borderWidth:1,
                                pointHoverBackgroundColor: 'rgba(0, 115, 169, 0.1)',
                                pointBorderWidth: 1,
                                pointHitRadius: 5,
                                pointHoverBorderWidth: 15,

                            }]
                        },
                    });

                })


            </script>

        </div>

        <div class="dash-box">
        <div class="dash-box-title"><?php echo sprintf("%s Top Refferers", '<i class="fas fa-mobile-alt"></i> ') ?></div>
        <div class="dash-box-info">Top referrer domain.</div>

            <?php
            $top_referrer_doamins = wpls_top_referrer_doamins();
            ?>
            <canvas id="top_referrer_doamins" ></canvas>

            <script>

                top_referrer_doamins = '<?php echo $top_referrer_doamins; ?>';
                var top_referrer_doamins = JSON.parse( top_referrer_doamins );


                backgroundColor = ['#c060a1', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 0.2)'];
                //console.log(typeof labels);

                jQuery(document).ready(function($) {

                    var ctx = document.getElementById('top_referrer_doamins');
                    var myChart = new Chart(ctx, {
                        type: 'horizontalBar',
                        data: {
                            labels: top_referrer_doamins.labels,
                            datasets: [{
                                label: 'Domains',
                                data: top_referrer_doamins.data,
                                backgroundColor: backgroundColor,
                                borderColor:'rgba(255, 99, 132, 0.2)',
                                borderWidth:1,
                                pointHoverBackgroundColor: 'rgba(0, 115, 169, 0.1)',
                                pointBorderWidth: 1,
                                pointHitRadius: 5,
                                pointHoverBorderWidth: 15,

                            }]
                        },
                    });

                })


            </script>

        </div>


        <div class="dash-box">
        <div class="dash-box-title"><?php echo sprintf("%s Top User", '<i class="fas fa-mobile-alt"></i> ') ?></div>
        <div class="dash-box-info">Top active user(by id) on your site.</div>

            <?php
            $wpls_top_userids = wpls_top_userids();
            ?>
            <canvas id="top_userids" style=""></canvas>

            <script>

                wpls_top_userids = '<?php echo $wpls_top_userids; ?>';
                var wpls_top_userids = JSON.parse( wpls_top_userids );

                backgroundColor = ['#c060a1', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 0.2)'];
                //console.log(typeof labels);

                jQuery(document).ready(function($) {

                    var ctx = document.getElementById('top_userids');
                    var myChart = new Chart(ctx, {
                        type: 'horizontalBar',
                        data: {
                            labels: wpls_top_userids.labels,
                            datasets: [{
                                label: 'Users',
                                data: wpls_top_userids.data,
                                backgroundColor: backgroundColor,
                                borderColor:'rgba(255, 99, 132, 0.2)',
                                borderWidth:1,
                                pointHoverBackgroundColor: 'rgba(0, 115, 169, 0.1)',
                                pointBorderWidth: 1,
                                pointHitRadius: 5,
                                pointHoverBorderWidth: 15,

                            }]
                        },
                    });

                })


            </script>

        </div>
        <div class="dash-box">
            <div class="dash-box-title"><?php echo sprintf("%s Top Pages", '<i class="fas fa-mobile-alt"></i> ') ?></div>
            <div class="dash-box-info">Top page list by view count.</div>
            <?php echo wpls_TopPages("url_id"); ?>
        </div>

    </div> <!-- para-dashboard -->


		

</div>

