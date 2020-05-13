<?php


if ( ! defined('ABSPATH')) exit;  // if direct access 
	
	
//add_action('wpls_stats_tabs_content_url','wpls_stats_tabs_content_url_date');
//add_action('wpls_stats_tabs_content_os','wpls_stats_tabs_content_url_date');
//add_action('wpls_stats_tabs_content_browser','wpls_stats_tabs_content_url_date');
//add_action('wpls_stats_tabs_content_screensize','wpls_stats_tabs_content_url_date');
//add_action('wpls_stats_tabs_content_referer','wpls_stats_tabs_content_url_date');
//add_action('wpls_stats_tabs_content_city','wpls_stats_tabs_content_url_date');
//add_action('wpls_stats_tabs_content_country','wpls_stats_tabs_content_url_date');
//add_action('wpls_stats_tabs_content_link_type','wpls_stats_tabs_content_url_date');



function wpls_stats_tabs_content_url_date($tab){

    wp_enqueue_style( 'jquery-ui');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-datepicker');

    $date_range = isset($_GET['date_range']) ? sanitize_text_field($_GET['date_range']) : '7_day';
    $tab = isset($_GET['tab']) ? $_GET['tab'] : 'url';

    $before_date = isset($_GET['before']) ? sanitize_text_field($_GET['before']):'';
    $after_date = isset($_GET['after']) ? sanitize_text_field($_GET['after']):'';

    $date_format = 'yy-mm-dd';


    ?>
    <div class="date-range">
        <a class="<?php echo ($date_range == 'year') ? 'active' : ''; ?>" href="<?php echo admin_url(); ?>edit.php?post_type=job&page=job_bm_stats&tab=<?php echo $tab; ?>&date_range=year"><?php echo __('Year','job-board-manager'); ?></a>
        <a class="<?php echo ($date_range == 'last_month') ? 'active' : ''; ?>" href="<?php echo admin_url(); ?>edit.php?post_type=job&page=job_bm_stats&tab=<?php echo $tab; ?>&date_range=last_month"><?php echo __('Last Month','job-board-manager'); ?></a>
        <a class="<?php echo ($date_range == 'this_month') ? 'active' : ''; ?>" href="<?php echo admin_url(); ?>edit.php?post_type=job&page=job_bm_stats&tab=<?php echo $tab; ?>&date_range=this_month"><?php echo __('This Month','job-board-manager'); ?></a>
        <a class="<?php echo ($date_range == 'last_30_day') ? 'active' : ''; ?>" href="<?php echo admin_url(); ?>edit.php?post_type=job&page=job_bm_stats&tab=<?php echo $tab; ?>&date_range=last_30_day"><?php echo __('Last 30 Days','job-board-manager'); ?></a>
        <a class=" <?php echo ($date_range == '7_day') ? 'active' : ''; ?>" href="<?php echo admin_url(); ?>edit.php?post_type=job&page=job_bm_stats&tab=<?php echo $tab; ?>&date_range=7_day"><?php echo __('Last 7 Days','job-board-manager'); ?></a>

        <form class="date-range-custom <?php echo ($date_range == 'custom') ? 'active' : ''; ?>" style="display:inline-block" method="GET" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
            <label><?php echo __('Custom:','job-board-manager'); ?></label>
            <input size="8" title="<?php echo __('Start date','job-board-manager'); ?>" type="text" class="job_bm_date" autocomplete="off" name="after" value="<?php echo $after_date; ?>" placeholder="<?php echo date('Y-m-d'); ?>" />
            <input size="8" title="<?php echo __('End date','job-board-manager'); ?>" type="text" class="job_bm_date" autocomplete="off" name="before" value="<?php echo $before_date; ?>" placeholder="<?php echo date('Y-m-d'); ?>" />
            <input type="hidden"  name="post_type" value="job" />
            <input type="hidden"  name="page" value="job_bm_stats" />
            <input type="hidden"  name="tab" value="<?php echo $tab; ?>" />
            <input type="hidden"  name="date_range" value="custom" />
            <input class="button" value="<?php echo __('Submit','job-board-manager'); ?>" type="submit">
        </form>


    </div>

    <script>jQuery(document).ready(function($) { $(".job_bm_date").datepicker({ dateFormat: "<?php echo $date_format; ?>" });});</script>

    <?php


}


add_action('wpls_stats_tabs_content_os','wpls_stats_tabs_content_os_chart');

function wpls_stats_tabs_content_os_chart($tab){

    $data = array();
    $date_range = isset($_GET['date_range']) ? sanitize_text_field($_GET['date_range']) : '7_day';

    global $wpdb;
    $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
    $limit = 200;
    $offset = ( $pagenum - 1 ) * $limit;

    $platform = 'platform';

    global $wpdb;
    $table = $wpdb->prefix . "wpls";
    $result = $wpdb->get_results("SELECT $platform FROM $table GROUP BY $platform ORDER BY COUNT($platform) DESC LIMIT 20", ARRAY_A);
    $total_rows = $wpdb->num_rows;

    $count_platform = $wpdb->get_results("SELECT platform, COUNT(*) AS platform FROM $table GROUP BY platform ORDER BY COUNT(platform) DESC LIMIT 10", ARRAY_A);


    $i=0;

    $data['labels'] = "[";
    $data['data'] = "[";

    while($total_rows>$i){

        $platform_os = isset($result[$i][$platform]) ? $result[$i][$platform] : '';
        $platform_total = isset($count_platform[$i]['platform']) ? $count_platform[$i]['platform'] : '';


        $data['labels'] .= '"'.$platform_os.'",';
        $data['data'] .= "$platform_total,";

        $i++;
    }

    $data['labels'] .= "]";
    $data['data'] .= "]";

    ?>

    <canvas id="chart" style="width: 100%; height: 600px !important;"></canvas>

    <script>

        jQuery(document).ready(function($) {

            var ctx = document.getElementById('chart');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo $data['labels']; ?>,
                    datasets: [{
                        label: 'Operating System',
                        data: <?php echo $data['data']; ?>,
                        backgroundColor:'rgba(255, 99, 132, 0.2)',
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


    <?php


}



add_action('wpls_stats_tabs_content_browser','wpls_stats_tabs_content_browser_chart');

function wpls_stats_tabs_content_browser_chart($tab){

    $data = array();
    $date_range = isset($_GET['date_range']) ? sanitize_text_field($_GET['date_range']) : '7_day';

    global $wpdb;
    $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
    $limit = 200;
    $offset = ( $pagenum - 1 ) * $limit;

    $platform = 'browser';

    global $wpdb;
    $table = $wpdb->prefix . "wpls";
    $result = $wpdb->get_results("SELECT $platform FROM $table GROUP BY $platform ORDER BY COUNT($platform) DESC LIMIT 20", ARRAY_A);
    $total_rows = $wpdb->num_rows;

    $count_platform = $wpdb->get_results("SELECT browser, COUNT(*) AS browser FROM $table GROUP BY browser ORDER BY COUNT(browser) DESC LIMIT 10", ARRAY_A);


    $i=0;

    $data['labels'] = "[";
    $data['data'] = "[";

    while($total_rows>$i){

        $platform_os = isset($result[$i][$platform]) ? $result[$i][$platform] : '';
        $platform_total = isset($count_platform[$i]['browser']) ? $count_platform[$i]['browser'] : 0;


        $data['labels'] .= '"'.$platform_os.'",';
        $data['data'] .= "$platform_total,";

        $i++;
    }

    $data['labels'] .= "]";
    $data['data'] .= "]";

    ?>

    <canvas id="chart-browser" style="width: 100%; height: 600px !important;"></canvas>

    <script>

        jQuery(document).ready(function($) {

            var ctx = document.getElementById('chart-browser');
            var myChart = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: <?php echo $data['labels']; ?>,
                    datasets: [{
                        label: 'Browser',
                        data: <?php echo $data['data']; ?>,
                        backgroundColor:'rgba(255, 99, 132, 0.2)',
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


    <?php


}



add_action('wpls_stats_tabs_content_screensize','wpls_stats_tabs_content_screensize_chart');

function wpls_stats_tabs_content_screensize_chart($tab){

    $data = array();
    $date_range = isset($_GET['date_range']) ? sanitize_text_field($_GET['date_range']) : '7_day';

    global $wpdb;
    $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
    $limit = 200;
    $offset = ( $pagenum - 1 ) * $limit;

    $platform = 'screensize';

    global $wpdb;
    $table = $wpdb->prefix . "wpls";
    $result = $wpdb->get_results("SELECT $platform FROM $table GROUP BY $platform ORDER BY COUNT($platform) DESC LIMIT 20", ARRAY_A);
    $total_rows = $wpdb->num_rows;

    $count_platform = $wpdb->get_results("SELECT screensize, COUNT(*) AS screensize FROM $table GROUP BY screensize ORDER BY COUNT(screensize) DESC LIMIT 10", ARRAY_A);


    $i=0;

    $data['labels'] = "[";
    $data['data'] = "[";

    while($total_rows>$i){

        $platform_os = isset($result[$i][$platform]) ? $result[$i][$platform] : '';
        $platform_total = isset($count_platform[$i]['screensize']) ? $count_platform[$i]['screensize'] : 0;


        $data['labels'] .= '"'.$platform_os.'",';
        $data['data'] .= "$platform_total,";

        $i++;
    }

    $data['labels'] .= "]";
    $data['data'] .= "]";

    ?>

    <canvas id="chart-screensize" style="width: 100%; height: 600px !important;"></canvas>

    <script>

        jQuery(document).ready(function($) {

            var ctx = document.getElementById('chart-screensize');
            var myChart = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: <?php echo $data['labels']; ?>,
                    datasets: [{
                        label: 'Screen sizes',
                        data: <?php echo $data['data']; ?>,
                        backgroundColor:'rgba(255, 99, 132, 0.2)',
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


    <?php


}


add_action('wpls_stats_tabs_content_city','wpls_stats_tabs_content_city_chart');

function wpls_stats_tabs_content_city_chart($tab){

    $data = array();
    $date_range = isset($_GET['date_range']) ? sanitize_text_field($_GET['date_range']) : '7_day';

    global $wpdb;
    $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
    $limit = 200;
    $offset = ( $pagenum - 1 ) * $limit;

    $platform = 'city';

    global $wpdb;
    $table = $wpdb->prefix . "wpls";
    $result = $wpdb->get_results("SELECT $platform FROM $table GROUP BY $platform ORDER BY COUNT($platform) DESC LIMIT 20", ARRAY_A);
    $total_rows = $wpdb->num_rows;

    $count_platform = $wpdb->get_results("SELECT city, COUNT(*) AS city FROM $table GROUP BY city ORDER BY COUNT(city) DESC LIMIT 10", ARRAY_A);


    $i=0;

    $data['labels'] = "[";
    $data['data'] = "[";

    while($total_rows>$i){

        $platform_os = isset($result[$i][$platform]) ? $result[$i][$platform] : '';
        $platform_os = !empty($platform_os) ? $platform_os : 'Unknown';
        $platform_total = isset($count_platform[$i]['city']) ? $count_platform[$i]['city'] : 0;


        $data['labels'] .= '"'.$platform_os.'",';
        $data['data'] .= "$platform_total,";

        $i++;
    }

    $data['labels'] .= "]";
    $data['data'] .= "]";

    ?>

    <canvas id="chart-city" style="width: 100%; height: 600px !important;"></canvas>

    <script>

        jQuery(document).ready(function($) {

            var ctx = document.getElementById('chart-city');
            var myChart = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: <?php echo $data['labels']; ?>,
                    datasets: [{
                        label: 'City',
                        data: <?php echo $data['data']; ?>,
                        backgroundColor:'rgba(255, 99, 132, 0.2)',
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


    <?php


}

add_action('wpls_stats_tabs_content_country','wpls_stats_tabs_content_country_chart');

function wpls_stats_tabs_content_country_chart($tab){

    $data = array();
    $date_range = isset($_GET['date_range']) ? sanitize_text_field($_GET['date_range']) : '7_day';

    global $wpdb;
    $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
    $limit = 200;
    $offset = ( $pagenum - 1 ) * $limit;

    $platform = 'countryName';

    global $wpdb;
    $table = $wpdb->prefix . "wpls";
    $result = $wpdb->get_results("SELECT $platform FROM $table GROUP BY $platform ORDER BY COUNT($platform) DESC LIMIT 20", ARRAY_A);
    $total_rows = $wpdb->num_rows;

    $count_platform = $wpdb->get_results("SELECT countryName, COUNT(*) AS countryName FROM $table GROUP BY countryName ORDER BY COUNT(countryName) DESC LIMIT 10", ARRAY_A);


    $i=0;

    $data['labels'] = "[";
    $data['data'] = "[";

    while($total_rows>$i){

        $platform_os = isset($result[$i][$platform]) ? $result[$i][$platform] : '';
        $platform_os = !empty($platform_os) ? $platform_os : 'Unknown';
        $platform_total = isset($count_platform[$i]['countryName']) ? $count_platform[$i]['countryName'] : 0;


        $data['labels'] .= '"'.$platform_os.'",';
        $data['data'] .= "$platform_total,";

        $i++;
    }

    $data['labels'] .= "]";
    $data['data'] .= "]";

    ?>

    <canvas id="chart-country" style="width: 100%; height: 600px !important;"></canvas>

    <script>

        jQuery(document).ready(function($) {

            var ctx = document.getElementById('chart-country');
            var myChart = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: <?php echo $data['labels']; ?>,
                    datasets: [{
                        label: 'Country',
                        data: <?php echo $data['data']; ?>,
                        backgroundColor:'rgba(255, 99, 132, 0.2)',
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


    <?php


}


add_action('wpls_stats_tabs_content_link_type','wpls_stats_tabs_content_link_type_chart');

function wpls_stats_tabs_content_link_type_chart($tab){

    $data = array();
    $date_range = isset($_GET['date_range']) ? sanitize_text_field($_GET['date_range']) : '7_day';

    global $wpdb;
    $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
    $limit = 200;
    $offset = ( $pagenum - 1 ) * $limit;

    $platform = 'url_term';

    global $wpdb;
    $table = $wpdb->prefix . "wpls";
    $result = $wpdb->get_results("SELECT $platform FROM $table GROUP BY $platform ORDER BY COUNT($platform) DESC LIMIT 20", ARRAY_A);
    $total_rows = $wpdb->num_rows;

    $count_platform = $wpdb->get_results("SELECT url_term, COUNT(*) AS url_term FROM $table GROUP BY url_term ORDER BY COUNT(url_term) DESC LIMIT 10", ARRAY_A);


    $i=0;

    $data['labels'] = "[";
    $data['data'] = "[";

    while($total_rows>$i){

        $platform_os = isset($result[$i][$platform]) ? $result[$i][$platform] : '';
        $platform_os = !empty($platform_os) ? $platform_os : 'Unknown';
        $platform_total = isset($count_platform[$i]['url_term']) ? $count_platform[$i]['url_term'] : 0;


        $data['labels'] .= '"'.$platform_os.'",';
        $data['data'] .= "$platform_total,";

        $i++;
    }

    $data['labels'] .= "]";
    $data['data'] .= "]";

    ?>

    <canvas id="chart-url_term" style="width: 100%; height: 600px !important;"></canvas>

    <script>

        jQuery(document).ready(function($) {

            var ctx = document.getElementById('chart-url_term');
            var myChart = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: <?php echo $data['labels']; ?>,
                    datasets: [{
                        label: 'Link type',
                        data: <?php echo $data['data']; ?>,
                        backgroundColor:'rgba(255, 99, 132, 0.2)',
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


    <?php


}



add_action('wpls_stats_tabs_content_referer','wpls_stats_tabs_content_referer_chart');

function wpls_stats_tabs_content_referer_chart($tab){

    $data = array();
    $date_range = isset($_GET['date_range']) ? sanitize_text_field($_GET['date_range']) : '7_day';

    global $wpdb;
    $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
    $limit = 200;
    $offset = ( $pagenum - 1 ) * $limit;

    $platform = 'referer_doamin';

    global $wpdb;
    $table = $wpdb->prefix . "wpls";
    $result = $wpdb->get_results("SELECT $platform FROM $table GROUP BY $platform ORDER BY COUNT($platform) DESC LIMIT 20", ARRAY_A);
    $total_rows = $wpdb->num_rows;

    $count_platform = $wpdb->get_results("SELECT referer_doamin, COUNT(*) AS referer_doamin FROM $table GROUP BY referer_doamin ORDER BY COUNT(referer_doamin) DESC LIMIT 10", ARRAY_A);


    $i=0;

    $data['labels'] = "[";
    $data['data'] = "[";

    while($total_rows>$i){

        $platform_os = isset($result[$i][$platform]) ? $result[$i][$platform] : '';
        $platform_os = !empty($platform_os) ? $platform_os : 'Unknown';
        $platform_total = isset($count_platform[$i]['referer_doamin']) ? $count_platform[$i]['referer_doamin'] : 0;


        $data['labels'] .= '"'.$platform_os.'",';
        $data['data'] .= "$platform_total,";

        $i++;
    }

    $data['labels'] .= "]";
    $data['data'] .= "]";

    ?>

    <canvas id="chart-referer_doamin" style="width: 100%; height: 600px !important;"></canvas>

    <script>

        jQuery(document).ready(function($) {

            var ctx = document.getElementById('chart-referer_doamin');
            var myChart = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: <?php echo $data['labels']; ?>,
                    datasets: [{
                        label: 'Referer domain',
                        data: <?php echo $data['data']; ?>,
                        backgroundColor:'rgba(255, 99, 132, 0.2)',
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


    <?php


}




add_action('wpls_stats_tabs_content_url','wpls_stats_tabs_content_url_chart');

function wpls_stats_tabs_content_url_chart($tab){

    $data = array();
    $date_range = isset($_GET['date_range']) ? sanitize_text_field($_GET['date_range']) : '7_day';

    global $wpdb;
    $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
    $limit = 200;
    $offset = ( $pagenum - 1 ) * $limit;

    $platform = 'url_id';

    global $wpdb;
    $table = $wpdb->prefix . "wpls";
    $result = $wpdb->get_results("SELECT $platform FROM $table GROUP BY $platform ORDER BY COUNT($platform) DESC LIMIT 20", ARRAY_A);
    $total_rows = $wpdb->num_rows;

    $count_platform = $wpdb->get_results("SELECT url_id, COUNT(*) AS url_id FROM $table GROUP BY url_id ORDER BY COUNT(url_id) DESC LIMIT 10", ARRAY_A);


    $i=0;

    $data['labels'] = "[";
    $data['data'] = "[";

    while($total_rows>$i){

        $platform_os = isset($result[$i][$platform]) ? $result[$i][$platform] : '';

        $platform_os = (is_numeric($platform_os)) ? get_the_title($platform_os) : $platform_os;

        $platform_total = isset($count_platform[$i]['url_id']) ? $count_platform[$i]['url_id'] : 0;


        $data['labels'] .= '"'.$platform_os.'",';
        $data['data'] .= "$platform_total,";

        $i++;
    }

    $data['labels'] .= "]";
    $data['data'] .= "]";

    ?>

    <canvas id="chart-url_id" style="width: 100%; height: 600px !important;"></canvas>

    <script>

        jQuery(document).ready(function($) {

            var ctx = document.getElementById('chart-url_id');
            var myChart = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: <?php echo $data['labels']; ?>,
                    datasets: [{
                        label: 'Links',
                        data: <?php echo $data['data']; ?>,
                        backgroundColor:'rgba(255, 99, 132, 0.2)',
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


    <?php


}
