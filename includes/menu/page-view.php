<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

wp_enqueue_style( 'font-awesome-5' );
wp_enqueue_script('chart.js');
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

        $root_url = admin_url().'admin.php?page=wpls_page_view';

        ?>
        <div class="date-range">
            <a class="<?php echo ($date_range == 'this_year') ? 'active' : ''; ?>" href="<?php echo $root_url; ?>&tab=<?php echo $tab; ?>&date_range=this_year"><?php echo __('This Year','job-board-manager'); ?></a>
            <a class="<?php echo ($date_range == 'last_month') ? 'active' : ''; ?>" href="<?php echo $root_url; ?>&tab=<?php echo $tab; ?>&date_range=last_month"><?php echo __('Last Month','job-board-manager'); ?></a>
            <a class="<?php echo ($date_range == 'this_month') ? 'active' : ''; ?>" href="<?php echo $root_url; ?>&tab=<?php echo $tab; ?>&date_range=this_month"><?php echo __('This Month','job-board-manager'); ?></a>
            <a class="<?php echo ($date_range == 'last_30_day') ? 'active' : ''; ?>" href="<?php echo $root_url; ?>&tab=<?php echo $tab; ?>&date_range=last_30_day"><?php echo __('Last 30 Days','job-board-manager'); ?></a>
            <a class=" <?php echo ($date_range == '7_day') ? 'active' : ''; ?>" href="<?php echo $root_url; ?>&tab=<?php echo $tab; ?>&date_range=7_day"><?php echo __('Last 7 Days','job-board-manager'); ?></a>

            <form class="date-range-custom <?php echo ($date_range == 'custom') ? 'active' : ''; ?>" style="display:inline-block" method="GET" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                <label><?php echo __('Custom:','job-board-manager'); ?></label>
                <input size="8" title="<?php echo __('Start date','job-board-manager'); ?>" type="text" class="job_bm_date" autocomplete="off" name="after" value="<?php echo $after_date; ?>" placeholder="<?php echo date('Y-m-d'); ?>" />
                <input size="8" title="<?php echo __('End date','job-board-manager'); ?>" type="text" class="job_bm_date" autocomplete="off" name="before" value="<?php echo $before_date; ?>" placeholder="<?php echo date('Y-m-d'); ?>" />
                <input type="hidden"  name="page" value="wpls_page_view" />
                <input type="hidden"  name="tab" value="<?php echo $tab; ?>" />
                <input type="hidden"  name="date_range" value="custom" />
                <input class="button" value="<?php echo __('Submit','job-board-manager'); ?>" type="submit">
            </form>

            <script>jQuery(document).ready(function($) { $(".job_bm_date").datepicker({ dateFormat: "<?php echo $date_format; ?>" });});</script>
        </div>


        <div class="visitors-list">
            <?php
            global $wpdb;
            $table = $wpdb->prefix . "wpls";

            $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
            $limit = 10;
            $offset = ( $pagenum - 1 ) * $limit;
            //$entries = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpls ORDER BY id DESC LIMIT $offset, $limit" );

            if($date_range == '7_day'){
                $last_date = date("Y-m-d");
                $first_date = date("Y-m-d", strtotime("7 days ago"));

                for ($i=1; $i<=7; $i++){

                    $day = date("d", strtotime($i." days ago"));
                    $month = date("m", strtotime($i." days ago"));
                    $year = date("Y", strtotime($i." days ago"));

                    $dates[] =  $year.'-'.$month.'-'.$day;
                }

                $dates = array_reverse($dates);






            }elseif($date_range == 'last_30_day'){
                $last_date = date("Y-m-d");
                $first_date = date("Y-m-d", strtotime("30 days ago"));

                for ($i=1; $i<=30; $i++){

                    $day = date("d", strtotime($i." days ago"));
                    $month = date("m", strtotime($i." days ago"));
                    $year = date("Y", strtotime($i." days ago"));

                    $dates[] =  $year.'-'.$month.'-'.$day;
                }

                $dates = array_reverse($dates);


            }
            elseif($date_range == 'last_month'){

                $first_date = date("Y-m-d", strtotime("1 month ago"));
                $dateBegin = strtotime("first day of last month");


                $last_month = date("m", $dateBegin);
                $last_month_year = date("Y", $dateBegin);


                $dateEnd = strtotime("last day of last month");
                $last_day = date("d", $dateEnd);


                $last_date = $last_month_year.'-'.$last_month.'-'.$last_day;
                $first_date = $last_month_year.'-'.$last_month.'-1';


                for ($i=1; $i <= $last_day; $i++){

                        $dates[] =  $last_month_year.'-'.$last_month.'-'.$i;

                }

                //$dates = array_reverse($dates);


            }elseif($date_range == 'this_month'){
                $last_date = date("Y-m-d");

                $month = date("m");
                $year = date("Y");
                $day = date("d");

                $first_date = $year.'-'.$month.'-1';

                for ($i=1; $i<=30; $i++){
                    if($i > $day) break;

                    $dates[] =  $year.'-'.$month.'-'.$i;
                }

                //$dates = array_reverse($dates);


            }elseif($date_range == 'this_year'){
                $last_date = date("Y-m-d");
                $year = date("Y");

                $first_date = $year.'-01-01';

                $dates = array();

            }elseif($date_range == 'custom'){

                $last_date = isset($_GET['before']) ? $_GET['before'] : date("Y-m-d");

                $last_date_arr = explode('-', $last_date);
                $last_date_year = $last_date_arr[0];
                $last_date_month = $last_date_arr[1];
                $last_date_day = $last_date_arr[2];

                $first_date = isset($_GET['after']) ? $_GET['after'] : date("Y-m-d");

                $first_date_arr = explode('-', $first_date);
                $first_date_year = $first_date_arr[0];
                $first_date_month = $first_date_arr[1];
                $first_date_day = $first_date_arr[2];


                $date1 = date_create($first_date);
                $date2 = date_create($last_date);
                $diff = date_diff($date1,$date2);
                $date_diff = (int)$diff->format("%a");

                if($date_diff < 60){

                    $period = new DatePeriod(
                        new DateTime($first_date),
                        new DateInterval('P1D'),
                        new DateTime($last_date)
                    );

                    foreach ($period as $key => $value) {
                        $dates[] = $value->format('Y-m-d');
                    }

                }else{
                    $dates = array();
                }




                //$dates = array_reverse($dates);



            }



            //echo '<pre>'.var_export($dates, true).'</pre>';
            //echo '<pre>'.var_export('first_date: '.$first_date, true).'</pre>';
            //echo '<pre>'.var_export('last_date: '.$last_date, true).'</pre>';


            $result = $wpdb->get_results("SELECT wpls_date FROM $table WHERE wpls_date BETWEEN '$first_date' AND '$last_date' AND event='visit' GROUP BY wpls_date ORDER BY COUNT(wpls_date) DESC LIMIT 20", ARRAY_A);
            $count_entries = $wpdb->get_results("SELECT wpls_date,  COUNT(*) AS wpls_date FROM $table WHERE wpls_date BETWEEN '$first_date' AND '$last_date' AND event='visit' GROUP BY wpls_date ORDER BY COUNT(wpls_date) DESC LIMIT 10", ARRAY_A);

            foreach ($result as $item_index => $item):
                $entries[$item['wpls_date']] =isset( $count_entries[$item_index]['wpls_date']) ?  (int) $count_entries[$item_index]['wpls_date'] : 0;
            endforeach;

            $data['labels'] = "[";
            $data['data'] = "[";

            foreach ($dates as $date_index => $date):

                //var_dump($date);

                $data['labels'] .= '"'.$date.'", ';
                $data['data'] .= !empty($entries[$date]) ? $entries[$date].', ' : '0,';


            endforeach;

            $data['labels'] .= "]";
            $data['data'] .= "]";

            //echo '<pre>'.var_export($entries, true).'</pre>';
            //echo '<pre>'.var_export($dates, true).'</pre>';


            //echo '<pre>'.var_export($data, true).'</pre>';


            ?>


            <div class="page-visit" style="position: relative;" >


                <canvas id="page-visit-cart" height="80vh" ></canvas>

                <script>


                    //console.log(typeof labels);

                    jQuery(document).ready(function($) {

                        var ctx = document.getElementById('page-visit-cart');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: <?php echo $data['labels']; ?>,
                                datasets: [{
                                    label: 'Page view',
                                    data: <?php echo $data['data']; ?>,
                                    backgroundColor: 'rgb(88, 101, 177)',
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

            <?php





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



</style>
