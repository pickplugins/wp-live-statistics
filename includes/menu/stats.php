<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 



wp_enqueue_style( 'font-awesome-5' );
//wp_enqueue_script( 'settings-tabs' );
wp_enqueue_style( 'settings-tabs' );
wp_enqueue_script('chart.js');




$current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'url';


$stats_tabs = array();





$stats_tabs[] = array(
    'id' => 'os',
    'title' => sprintf(__('%s Operating System','job-board-manager'),'<i class="fas fa-desktop"></i>'),
    'priority' => 5,
    'active' => ($current_tab == 'os') ? true : false,
);


$stats_tabs[] = array(
    'id' => 'browser',
    'title' => sprintf(__('%s Browser','job-board-manager'),'<i class="fab fa-internet-explorer"></i>'),
    'priority' => 10,
    'active' => ($current_tab == 'browser') ? true : false,
);

$stats_tabs[] = array(
    'id' => 'screensize',
    'title' => sprintf(__('%s Screensize','job-board-manager'),'<i class="fas fa-mobile-alt"></i>'),
    'priority' => 15,
    'active' => ($current_tab == 'screensize') ? true : false,
);

$stats_tabs[] = array(
    'id' => 'referer',
    'title' => sprintf(__('%s Referer','job-board-manager'),'<i class="fas fa-link"></i>'),
    'priority' => 20,
    'active' => ($current_tab == 'referer') ? true : false,
);

$stats_tabs[] = array(
    'id' => 'city',
    'title' => sprintf(__('%s City','job-board-manager'),'<i class="fas fa-map-pin"></i>'),
    'priority' => 25,
    'active' => ($current_tab == 'city') ? true : false,
);

$stats_tabs[] = array(
    'id' => 'country',
    'title' => sprintf(__('%s Country','job-board-manager'),'<i class="fas fa-globe-americas"></i>'),
    'priority' => 30,
    'active' => ($current_tab == 'country') ? true : false,
);

$stats_tabs[] = array(
    'id' => 'url',
    'title' => sprintf(__('%s URL','job-board-manager'),'<i class="fas fa-external-link-alt"></i>'),
    'priority' => 35,
    'active' => ($current_tab == 'url') ? true : false,
);

$stats_tabs[] = array(
    'id' => 'link_type',
    'title' => sprintf(__('%s Link Type','job-board-manager'),'<i class="fas fa-map-signs"></i>'),
    'priority' => 40,
    'active' => ($current_tab == 'link_type') ? true : false,
);




//
//$stats_tabs[] = array(
//    'id' => 'invitation',
//    'title' => sprintf(__('%s Invitation','job-board-manager'),'<i class="far fa-copy"></i>'),
//    'priority' => 2,
//    'active' => ($tab == 'invitation') ? true : false,
//);
//
//$stats_tabs[] = array(
//    'id' => 'resume',
//    'title' => sprintf(__('%s Resume','job-board-manager'),'<i class="far fa-copy"></i>'),
//    'priority' => 2,
//    'active' => ($tab == 'resume') ? true : false,
//);

$stats_tabs = apply_filters('wpls_stats_tabs', $stats_tabs);

$tabs_sorted = array();
foreach ($stats_tabs as $page_key => $tab) $tabs_sorted[$page_key] = isset( $tab['priority'] ) ? $tab['priority'] : 0;
array_multisort($tabs_sorted, SORT_ASC, $stats_tabs);



?>
<div class="wrap">
    <h2><?php echo sprintf(__('%s  - Stats', 'job-board-manager'), wpls_plugin_name); ?></h2><br>

    <div class="settings-tabs vertical">

        <ul class="tab-navs">
            <?php
            foreach ($stats_tabs as $tab){
                $id = $tab['id'];
                $title = $tab['title'];
                $active = $tab['active'];
                $data_visible = isset($tab['data_visible']) ? $tab['data_visible'] : '';
                $hidden = isset($tab['hidden']) ? $tab['hidden'] : false;
                ?>
                <li <?php if(!empty($data_visible)):  ?> data_visible="<?php echo $data_visible; ?>" <?php endif; ?> class="tab-nav <?php if($hidden) echo 'hidden';?> <?php if($active) echo 'active';?>" data-id="<?php echo $id; ?>">
                    <a href="<?php echo admin_url().'admin.php?page=wpls_admin_filter&tab='.$id;?>"><?php echo $title; ?></a>

                </li>
                <?php
            }
            ?>
        </ul>



        <?php
        foreach ($stats_tabs as $tab){
            $id = $tab['id'];
            $title = $tab['title'];
            $active = $tab['active'];
            ?>

            <div class="tab-content <?php if($active) echo 'active';?>" id="<?php echo $id; ?>">
                <?php //echo $id; ?>

                <?php
                if($current_tab == $id)
                do_action('wpls_stats_tabs_content_'.$id, $tab);
                ?>


            </div>

            <?php
        }
        ?>

    </div>


</div>


<style type="text/css">

    .settings-tabs .tab-navs {
        background: #fafafa;

    }
    .settings-tabs .tab-nav {
        background: #ececec !important;
        padding:0px !important;

    }

    .settings-tabs .tab-nav.active {
        background: #fafafa !important;
    }

    .settings-tabs .tab-nav a {
        display: block;
        text-decoration: none;
        padding: 12px 10px;

    }

    .date-range{
        padding: 15px 20px;
        margin-bottom:15px ;
    }
    .date-range a{
        padding: 5px 10px;
        text-decoration: none;
        margin: 0px 0 5px 0;
        display: inline-block;
    }
    .date-range a.active{
        padding: 5px 10px;
    }


    .date-range .active{
        background: #ececec;
        padding: 2px 10px;
        border-radius: 3px;
        border: 1px solid #d7d8da;
    }

    .date-range-custom{}

    .date-range-custom input[type="text"]{
        width: 130px !important;
    }

</style>
		
		
		