<?php
if ( ! defined('ABSPATH')) exit;  // if direct access


wp_enqueue_style( 'font-awesome-5' );
?>

<div class="wrap">
    <div id="icon-tools" class="icon32"><br></div><h2><?php echo sprintf(__('%s Dashboard', 'wp-live-statistics'), wpls_plugin_name)?></h2>

    <div class="wpls-dashboard">
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

        <div id="TopOS" style="height:350px;width:100%; "></div>
        <script>
            jQuery(document).ready(function($){
              var data =
                        [
                            <?php echo wpls_TopOS("platform"); ?>
                        ];

              var TopOS = $.jqplot ('TopOS', [data],
                {

                    seriesDefaults: {
                    // Make this a pie chart.

                    shadow:false,
                    renderer: $.jqplot.PieRenderer,
                    rendererOptions: {
                        showDataLabels: true,
                      // Put data labels on the pie slices.
                      // By default, labels show the percentage of the slice.

                    }
                  },

                    highlighter: {
                        show: true,
                        sizeAdjust: 1,
                        tooltipOffset: 9
                    },

                  legend: {
                        show:true,
                        location: 's',
                        renderer: $.jqplot.EnhancedLegendRenderer,
                        rendererOptions:
                            {
                            numberColumns: 3,
                            disableIEFading: false,
                            border: 'none',
                            },
                        },
                    grid: {
                        background: 'transparent',
                        borderWidth: 0,
                        shadow: false,

                        },
                    highlighter: {show: true,formatString:'%s',tooltipLocation:'n',useAxesFormatters:false,},

                }
              );


            });
        </script>


        </div>

        <div class="dash-box">
        <div class="dash-box-title"><?php echo sprintf("%s Top Screen Size", '<i class="fas fa-mobile-alt"></i> ') ?></div>
        <div class="dash-box-info">Top device screen size.</div>
        <div id="TopScreenSize" style="height:350px;width:100%; "></div>

        <script>
            jQuery(document).ready(function($){
              var data =
                        [
                            <?php echo wpls_TopScreenSize("screensize"); ?>
                        ];

              var TopOS = $.jqplot ('TopScreenSize', [data],
                {




                    seriesDefaults: {
                    // Make this a pie chart.

                    shadow:false,
                    renderer: $.jqplot.PieRenderer,
                    rendererOptions: {
                        showDataLabels: true,
                      // Put data labels on the pie slices.
                      // By default, labels show the percentage of the slice.

                    }
                  },

                    highlighter: {
                        show: true,
                        sizeAdjust: 1,
                        tooltipOffset: 9
                    },

                  legend: {
                        show:true,
                        location: 's',
                        renderer: $.jqplot.EnhancedLegendRenderer,
                        rendererOptions:
                            {
                            numberColumns: 3,
                            disableIEFading: false,
                            border: 'none',
                            },
                        },
                    grid: {
                        background: 'transparent',
                        borderWidth: 0,
                        shadow: false,

                        },
                    highlighter: {show: true,formatString:'%s',tooltipLocation:'n',useAxesFormatters:false,},

                }
              );


            });
        </script>



        </div>


        <div class="dash-box">
        <div class="dash-box-title"><?php echo sprintf("%s Top Browsers", '<i class="fas fa-mobile-alt"></i> ') ?></div>
        <div class="dash-box-info">Top broswer by view count.</div>
        <div id="TopBrowsers" style="height:350px;width:100%; "></div>

        <script>
            jQuery(document).ready(function($){
              var data =
                        [
                            <?php echo wpls_TopBrowsers("browser"); ?>
                        ];

              var TopOS = $.jqplot ('TopBrowsers', [data],
                {




                    seriesDefaults: {
                    // Make this a pie chart.

                    shadow:false,
                    renderer: $.jqplot.PieRenderer,
                    rendererOptions: {
                        showDataLabels: true,
                      // Put data labels on the pie slices.
                      // By default, labels show the percentage of the slice.

                    }
                  },

                    highlighter: {
                        show: true,
                        sizeAdjust: 1,
                        tooltipOffset: 9
                    },

                  legend: {
                        show:true,
                        location: 's',
                        renderer: $.jqplot.EnhancedLegendRenderer,
                        rendererOptions:
                            {
                            numberColumns: 3,
                            disableIEFading: false,
                            border: 'none',
                            },
                        },
                    grid: {
                        background: 'transparent',
                        borderWidth: 0,
                        shadow: false,

                        },
                    highlighter: {show: true,formatString:'%s',tooltipLocation:'n',useAxesFormatters:false,},

                }
              );


            });
        </script>



        </div>

        <div class="dash-box">
        <div class="dash-box-title"><?php echo sprintf("%s Top Page Terms", '<i class="fas fa-mobile-alt"></i> ') ?></div>
        <div class="dash-box-info">Top link category.</div>
        <div id="TopPageTerms" style="height:350px;width:100%; "></div>

        <script>
            jQuery(document).ready(function($){
              var data =
                        [
                            <?php echo wpls_TopPageTerms("url_term"); ?>
                        ];

              var TopOS = $.jqplot ('TopPageTerms', [data],
                {




                    seriesDefaults: {
                    // Make this a pie chart.

                    shadow:false,
                    renderer: $.jqplot.PieRenderer,
                    rendererOptions: {
                        showDataLabels: true,
                      // Put data labels on the pie slices.
                      // By default, labels show the percentage of the slice.

                    }
                  },

                    highlighter: {
                        show: true,
                        sizeAdjust: 1,
                        tooltipOffset: 9
                    },

                  legend: {
                        show:true,
                        location: 's',
                        renderer: $.jqplot.EnhancedLegendRenderer,
                        rendererOptions:
                            {
                            numberColumns: 3,
                            disableIEFading: false,
                            border: 'none',
                            },
                        },
                    grid: {
                        background: 'transparent',
                        borderWidth: 0,
                        shadow: false,

                        },
                    highlighter: {show: true,formatString:'%s',tooltipLocation:'n',useAxesFormatters:false,},

                }
              );


            });
        </script>

        </div>


        <div class="dash-box">
        <div class="dash-box-title"><?php echo sprintf("%s Top Countries", '<i class="fas fa-mobile-alt"></i> ') ?></div>
        <div class="dash-box-info">Top country by view count.</div>
        <div id="TopCountries" style="height:350px;width:100%; "></div>

        <script>
            jQuery(document).ready(function($){
              var data =
                        [
                        <?php echo wpls_TopCountries("countryName"); ?>
                        ];

              var TopOS = $.jqplot ('TopCountries', [data],
                {




                    seriesDefaults: {
                    // Make this a pie chart.

                    shadow:false,
                    renderer: $.jqplot.PieRenderer,
                    rendererOptions: {
                        showDataLabels: true,
                      // Put data labels on the pie slices.
                      // By default, labels show the percentage of the slice.

                    }
                  },

                    highlighter: {
                        show: true,
                        sizeAdjust: 1,
                        tooltipOffset: 9
                    },

                  legend: {
                        show:true,
                        location: 's',
                        renderer: $.jqplot.EnhancedLegendRenderer,
                        rendererOptions:
                            {
                            numberColumns: 3,
                            disableIEFading: false,
                            border: 'none',
                            },
                        },
                    grid: {
                        background: 'transparent',
                        borderWidth: 0,
                        shadow: false,

                        },
                    highlighter: {show: true,formatString:'%s',tooltipLocation:'n',useAxesFormatters:false,},

                }
              );


            });
        </script>

        </div>
        <div class="dash-box">
        <div class="dash-box-title"><?php echo sprintf("%s Top Cities", '<i class="fas fa-mobile-alt"></i> ') ?></div>
        <div class="dash-box-info">Top city by view count.</div>
        <div id="TopCities" style="height:350px;width:100%; "></div>

        <script>
            jQuery(document).ready(function($){
              var data =
                        [
                        <?php echo wpls_TopCities("city"); ?>
                        ];

              var TopOS = $.jqplot ('TopCities', [data],
                {




                    seriesDefaults: {
                    // Make this a pie chart.

                    shadow:false,
                    renderer: $.jqplot.PieRenderer,
                    rendererOptions: {
                        showDataLabels: true,
                      // Put data labels on the pie slices.
                      // By default, labels show the percentage of the slice.

                    }
                  },

                    highlighter: {
                        show: true,
                        sizeAdjust: 1,
                        tooltipOffset: 9
                    },

                  legend: {
                        show:true,
                        location: 's',
                        renderer: $.jqplot.EnhancedLegendRenderer,
                        rendererOptions:
                            {
                            numberColumns: 3,
                            disableIEFading: false,
                            border: 'none',
                            },
                        },
                    grid: {
                        background: 'transparent',
                        borderWidth: 0,
                        shadow: false,

                        },
                    highlighter: {show: true,formatString:'%s',tooltipLocation:'n',useAxesFormatters:false,},

                }
              );


            });
        </script>

        </div>

        <div class="dash-box">
        <div class="dash-box-title"><?php echo sprintf("%s Top Refferers", '<i class="fas fa-mobile-alt"></i> ') ?></div>
        <div class="dash-box-info">Top Referer link.</div>
        <div id="TopReferers" style="height:350px;width:100%; "></div>

        <script>
            jQuery(document).ready(function($){
              var data =
                        [
                        <?php echo wpls_TopReferers("referer_doamin"); ?>
                        ];

              var TopOS = $.jqplot ('TopReferers', [data],
                {




                    seriesDefaults: {
                    // Make this a pie chart.

                    shadow:false,
                    renderer: $.jqplot.PieRenderer,
                    rendererOptions: {
                        showDataLabels: true,
                      // Put data labels on the pie slices.
                      // By default, labels show the percentage of the slice.

                    }
                  },

                    highlighter: {
                        show: true,
                        sizeAdjust: 1,
                        tooltipOffset: 9
                    },

                  legend: {
                        show:true,
                        location: 's',
                        renderer: $.jqplot.EnhancedLegendRenderer,
                        rendererOptions:
                            {
                            numberColumns: 3,
                            disableIEFading: false,
                            border: 'none',
                            },
                        },
                    grid: {
                        background: 'transparent',
                        borderWidth: 0,
                        shadow: false,

                        },
                    highlighter: {show: true,formatString:'%s',tooltipLocation:'n',useAxesFormatters:false,},

                }
              );


            });
        </script>

        </div>


        <div class="dash-box">
        <div class="dash-box-title"><?php echo sprintf("%s Top User", '<i class="fas fa-mobile-alt"></i> ') ?></div>
        <div class="dash-box-info">Top active user(by id) on your site.</div>
        <div id="TopUser" style="height:350px;width:100%; "></div>

        <script>
            jQuery(document).ready(function($){
              var data =
                        [
                        <?php echo wpls_TopUser("userid"); ?>
                        ];

              var TopOS = $.jqplot ('TopUser', [data],
                {




                    seriesDefaults: {
                    // Make this a pie chart.

                    shadow:false,
                    renderer: $.jqplot.PieRenderer,
                    rendererOptions: {
                        showDataLabels: true,
                      // Put data labels on the pie slices.
                      // By default, labels show the percentage of the slice.

                    }
                  },

                    highlighter: {
                        show: true,
                        sizeAdjust: 1,
                        tooltipOffset: 9
                    },

                  legend: {
                        show:true,
                        location: 's',
                        renderer: $.jqplot.EnhancedLegendRenderer,
                        rendererOptions:
                            {
                            numberColumns: 3,
                            disableIEFading: false,
                            border: 'none',
                            },
                        },
                    grid: {
                        background: 'transparent',
                        borderWidth: 0,
                        shadow: false,

                        },
                    highlighter: {show: true,formatString:'%s',tooltipLocation:'n',useAxesFormatters:false,},

                }
              );


            });
        </script>

        </div>
        <div class="dash-box">
            <div class="dash-box-title"><?php echo sprintf("%s Top Pages", '<i class="fas fa-mobile-alt"></i> ') ?></div>
            <div class="dash-box-info">Top page list by view count.</div>
            <?php echo wpls_TopPages("url_id"); ?>
        </div>

    </div> <!-- para-dashboard -->


		

</div>

