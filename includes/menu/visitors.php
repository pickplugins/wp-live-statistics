<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

wp_enqueue_style( 'font-awesome-5' );


?>
<div class="wrap">
    <h2><?php echo sprintf(__('%s  - Visitors', 'job-board-manager'), wpls_plugin_name); ?></h2><br>

    <div class="wpls-visitors">
        <?php


        wp_enqueue_style( 'jquery-ui');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-datepicker');

        $date_range = isset($_GET['date_range']) ? sanitize_text_field($_GET['date_range']) : '7_day';
        $tab = isset($_GET['tab']) ? $_GET['tab'] : 'url';

        $before_date = isset($_GET['before']) ? sanitize_text_field($_GET['before']):'';
        $after_date = isset($_GET['after']) ? sanitize_text_field($_GET['after']):'';

        $date_format = 'yy-mm-dd';

        $root_url = admin_url().'admin.php?page=wpls_visitors';

        ?>
        <div class="date-range">
            <a class="<?php echo ($date_range == 'year') ? 'active' : ''; ?>" href="<?php echo $root_url; ?>&tab=<?php echo $tab; ?>&date_range=year"><?php echo __('Year','job-board-manager'); ?></a>
            <a class="<?php echo ($date_range == 'last_month') ? 'active' : ''; ?>" href="<?php echo $root_url; ?>&tab=<?php echo $tab; ?>&date_range=last_month"><?php echo __('Last Month','job-board-manager'); ?></a>
            <a class="<?php echo ($date_range == 'this_month') ? 'active' : ''; ?>" href="<?php echo $root_url; ?>&tab=<?php echo $tab; ?>&date_range=this_month"><?php echo __('This Month','job-board-manager'); ?></a>
            <a class="<?php echo ($date_range == 'last_30_day') ? 'active' : ''; ?>" href="<?php echo $root_url; ?>&tab=<?php echo $tab; ?>&date_range=last_30_day"><?php echo __('Last 30 Days','job-board-manager'); ?></a>
            <a class=" <?php echo ($date_range == '7_day') ? 'active' : ''; ?>" href="<?php echo $root_url; ?>&tab=<?php echo $tab; ?>&date_range=7_day"><?php echo __('Last 7 Days','job-board-manager'); ?></a>

            <form class="date-range-custom <?php echo ($date_range == 'custom') ? 'active' : ''; ?>" style="display:inline-block" method="GET" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                <label><?php echo __('Custom:','job-board-manager'); ?></label>
                <input size="8" title="<?php echo __('Start date','job-board-manager'); ?>" type="text" class="job_bm_date" autocomplete="off" name="after" value="<?php echo $after_date; ?>" placeholder="<?php echo date('Y-m-d'); ?>" />
                <input size="8" title="<?php echo __('End date','job-board-manager'); ?>" type="text" class="job_bm_date" autocomplete="off" name="before" value="<?php echo $before_date; ?>" placeholder="<?php echo date('Y-m-d'); ?>" />
                <input type="hidden"  name="post_type" value="job" />
                <input type="hidden"  name="page" value="wpls_visitors" />
                <input type="hidden"  name="tab" value="<?php echo $tab; ?>" />
                <input type="hidden"  name="date_range" value="custom" />
                <input class="button" value="<?php echo __('Submit','job-board-manager'); ?>" type="submit">
            </form>

            <script>jQuery(document).ready(function($) { $(".job_bm_date").datepicker({ dateFormat: "<?php echo $date_format; ?>" });});</script>
        </div>


        <div class="visitors-list">
            <?php
            global $wpdb;
            $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
            $limit = 10;
            $offset = ( $pagenum - 1 ) * $limit;
            //$entries = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpls ORDER BY id DESC LIMIT $offset, $limit" );

            if($date_range == '7_day'){
                $last_day = date("Y-m-d");
                $first_date = date("Y-m-d", strtotime("7 days ago"));

                $entries = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpls WHERE wpls_date BETWEEN '$first_date' AND '$last_day' ORDER BY id DESC LIMIT $offset, $limit" );


            }elseif($date_range == 'last_30_day'){
                $last_day = date("Y-m-d");
                $first_date = date("Y-m-d", strtotime("30 days ago"));

                $entries = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpls WHERE wpls_date BETWEEN '$first_date' AND '$last_day' ORDER BY id DESC LIMIT $offset, $limit" );


            }
            elseif($date_range == 'last_month'){
                $last_day = date("Y-m-d");

                $first_date = date("Y-m-d", strtotime("1 month ago"));
                $dateBegin = strtotime("first day of last month");
                $first_day = date("Y-m-d", $dateBegin);
                $dateEnd = strtotime("last day of last month");
                $last_day = date("Y-m-d", $dateEnd);


                $entries = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpls WHERE wpls_date BETWEEN '$first_day' AND '$last_day' ORDER BY id DESC LIMIT $offset, $limit" );


            }elseif($date_range == 'this_month'){
                $last_day = date("Y-m-d");

                $month = date("m");
                $year = date("Y");
                $day = date("d");

                $first_date = $year.'-'.$month.'-1';

                $entries = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpls WHERE wpls_date BETWEEN '$first_date' AND '$last_day' ORDER BY id DESC LIMIT $offset, $limit" );


            }elseif($date_range == 'year'){
                $last_day = date("Y-m-d");
                $year = date("Y");

                $first_date = $year.'-01-01';

                $entries = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpls WHERE wpls_date BETWEEN '$first_date' AND '$last_day' ORDER BY id DESC LIMIT $offset, $limit" );


            }elseif($date_range == 'custom'){

                $last_day = isset($_GET['before']) ? $_GET['before'] : date("Y-m-d");

                $first_date = isset($_GET['after']) ? $_GET['after'] : '';

                $entries = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpls WHERE wpls_date BETWEEN '$first_date' AND '$last_day' ORDER BY id DESC LIMIT $offset, $limit" );


            }

            else{
                $entries = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpls ORDER BY id DESC LIMIT $offset, $limit" );
            }






            ?>

            <table class="widefat">
                <thead>
                <tr>
                    <th scope="col" class="manage-column column-name" style=""><strong>Page Title</strong></th>
                    <th scope="col" class="manage-column column-name" style=""><strong>User</strong></th>
                    <th scope="col" class="manage-column column-name" style=""><strong>Event</strong></th>
                    <th scope="col" class="manage-column column-name" style=""><strong>Date - Time</strong></th>
                    <th scope="col" class="manage-column column-name" style=""><strong>Duration</strong></th>
                    <th scope="col" class="manage-column column-name" style=""><strong>Device</strong></th>
                    <th scope="col" class="manage-column column-name" style=""><strong>Location</strong></th>
                    <th scope="col" class="manage-column column-name" style=""><strong>Referer</strong></th>
                    <th scope="col" class="manage-column column-name" style=""><strong>Unique</strong></th>
                    <th scope="col" class="manage-column column-name" style=""><strong>Landing</strong></th>

                </tr>
                </thead>

                <tfoot>
                <tr>
                    <th scope="col" class="manage-column column-name" style=""><strong>Page Title</strong></th>
                    <th scope="col" class="manage-column column-name" style=""><strong>User</strong></th>
                    <th scope="col" class="manage-column column-name" style=""><strong>Event</strong></th>
                    <th scope="col" class="manage-column column-name" style=""><strong>Date - Time</strong></th>
                    <th scope="col" class="manage-column column-name" style=""><strong>Duration</strong></th>
                    <th scope="col" class="manage-column column-name" style=""><strong>Device</strong></th>
                    <th scope="col" class="manage-column column-name" style=""><strong>Location</strong></th>
                    <th scope="col" class="manage-column column-name" style=""><strong>Referer</strong></th>
                    <th scope="col" class="manage-column column-name" style=""><strong>Unique</strong></th>
                    <th scope="col" class="manage-column column-name" style=""><strong>Landing</strong></th>

                </tr>
                </tfoot>

                <tbody>
                <?php if( $entries ) { ?>

                    <?php
                    $count = 1;
                    $class = '';
                    foreach( $entries as $entry ) {
                        $class = ( $count % 2 == 0 ) ? ' class="alternate"' : '';
                        ?>

                        <tr <?php echo $class; ?>>

                            <td style="max-width:200px;">
                                <?php
                                $url_term = $entry->url_term;
                                $url_id = $entry->url_id;

                                if(is_numeric($url_id)){
                                    echo "<a href='".get_permalink($url_id)."'>".get_the_title($url_id)."</a>";
                                }
                                else{
                                    echo "<a href='".$url_id."'>".$url_term."</a>";
                                }

                                ?>
                            </td>
                            <td>
                                <?php
                                $userid = $entry->userid;

                                if(is_numeric($userid)) {
                                    $user_info = get_userdata($userid);
                                    echo "<span title='".$user_info->display_name."' class='avatar'>".get_avatar( $userid, 32 )."<i title='User'></i></span>";
                                }
                                else{
                                    if($userid=='guest'){
                                        echo "<span title='Guest' class='avatar'>".get_avatar( 0, 32 )."</span>";
                                    }
                                    else{
                                        $userid = get_userdatabylogin($userid );
                                        $userid = $userid->ID;
                                        $user_info = get_userdata($userid);
                                        echo "<span title='".$user_info->display_name."' class='avatar'>".get_avatar( $userid, 32 )."<i title='Username'></i></span>";
                                    }
                                }
                                ?>
                            </td>
                            <td><?php echo $entry->event; ?></td>
                            <td>
                                <span><?php echo $entry->wpls_date; ?></span>
                                <span><?php echo $entry->wpls_time; ?></span>

                            </td>
                            <td>
                                <?php

                                $time1 = strtotime($entry->wpls_time);
                                $time2 = strtotime($entry->wpls_endtime);
                                $diff = $time2 - $time1;

                                echo date('H:i:s', $diff);


                                ?>
                            </td>
                            <td>
                                <?php
                                $platform = $entry->platform;
                                $browser = $entry->browser;
                                $screensize = $entry->screensize;

                                echo "<span  title='".$platform."' class='platform ".$platform."'></span>";
                                echo "<span  title='".$browser."' class='browser ".$browser."'></span>";
                                echo "<span  title='".$screensize."' class='screensize'>".$screensize."</span>";


                                ?>
                            </td>
                            <td>

                                <?php
                                $ip = $entry->ip;
                                $countryName = $entry->countryName;
                                $region = $entry->region;
                                $city = $entry->city;

                                echo "<span title='".$ip."' class='ip'>".$ip."</span>";
                                echo "<span title='".$countryName."' class='flag flag-".strtolower($countryName)."'></span><br />";
                                echo "<span title='".$region."' class='region'>".$region."</span><br />";
                                echo "<span title='".$city."' class='city'>".$city."</span>";
                                ?>

                            </td>
                            <td>
                                <?php
                                $referer_url = $entry->referer_url;
                                $referer_doamin = $entry->referer_doamin;

                                if($referer_doamin=='direct'){
                                    echo "Direct Visit";
                                }
                                else{
                                    echo "<a href='".$referer_url."'>URL</a>";
                                    if($referer_doamin=='none'){
                                        echo "<span title='Domain is undefine or missing, might be localhost'> - None</span>";
                                    }
                                    else{
                                        echo " - <a href='http://".$referer_doamin."'>".$referer_doamin."</a>";
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php $isunique = isset($entry->isunique) ? $entry->isunique : ''; ?>
                                <span title="Post View Unique Status: <?php echo $isunique; ?>" class="isunique">
                                    <?php
                                    if($isunique == 'yes'):
                                        ?>
                                        <i class="fas fa-check"></i>
                                        <?php
                                    else:
                                        ?>
                                        <i class="fas fa-times"></i>
                                        <?php
                                    endif;

                                    ?>
                                </span>

                            </td>
                            <td>
                                <?php echo $entry->landing; ?>
                            </td>
                        </tr>

                        <?php
                        $count++;
                    }
                }
                else{
                    ?>
                    <tr>
                        <td colspan="2">No Views Yet</td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>


            <?php





            ?>

        </div>

        <div class="visitors-paginate">
            <?php

            //var_dump($first_date);
            //var_dump($last_day);

            $total = $wpdb->get_var( "SELECT COUNT(`id`) FROM {$wpdb->prefix}wpls WHERE wpls_date BETWEEN '$first_date' AND '$last_day'" );
            $num_of_pages = ceil( $total / $limit );
            $page_links = paginate_links( array(
                'base' => add_query_arg( 'pagenum', '%#%' ),
                'format' => '',
                'prev_text' => __( '&laquo;', 'aag' ),
                'next_text' => __( '&raquo;', 'aag' ),
                'total' => $num_of_pages,
                'current' => $pagenum
            ) );

            if ( $page_links ) {
                echo $page_links;
            }



            ?>
        </div>

    </div>
</div>



<style type="text/css">

    .wpls-visitors{
        background: #fff;
        margin-top: 20px;

    }

    .visitors-list{
        padding: 15px;
    }


    .visitors-list tr:nth-child(even) {background: #f5f5f5}
    .visitors-list tr:nth-child(odd) {background: #FFF}

    .date-range{
        padding: 10px 20px;
        /* margin-bottom: 15px; */
        background: #5865b1;
        color: #fff;
    }
    .date-range a{
        padding: 5px 10px;
        text-decoration: none;
        margin: 0px 0 5px 0;
        display: inline-block;
        color: #fff;
    }
    .date-range a.active{
        padding: 5px 10px;
    }


    .date-range .active{
        background: #4a5594;
        padding: 2px 10px;
        border-radius: 3px;
    }

    .date-range-custom{
        margin: 0 10px;
    }

    .date-range-custom input[type="text"]{
        width: 130px !important;
    }


    .visitors-paginate{
        padding: 10px 20px;
        background: #5865b1;
        color: #fff;
        text-align: center;
    }

    .visitors-paginate a,.visitors-paginate span,.visitors-paginate .page-numbers{
        padding: 8px 15px;
        text-decoration: none;
        /* margin: 0px 0 5px 0; */
        display: inline-block;
        color: #fff;
        background: #4a5594;
    }
    .visitors-paginate .page-numbers.current{
        background: #5865b1;
    }


</style>
