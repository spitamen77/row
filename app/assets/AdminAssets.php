<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://www.websar.uz
 * Project: admin
 * Date: 29.09.2019 18:21
 */

namespace app\assets;


class AdminAssets extends \uni\web\AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'themes/joli/css/theme-blue.css',
    ];

    public $js = [
        'themes/joli/js/plugins/jquery/jquery.min.js',
        'themes/joli/js/plugins/jquery/jquery-ui.min.js',
        'themes/joli/js/plugins/bootstrap/bootstrap.min.js',
        'themes/joli/js/plugins/icheck/icheck.min.js',
        'themes/joli/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js',
        'themes/joli/js/plugins/scrolltotop/scrolltopcontrol.js',
        'themes/joli/js/plugins/morris/raphael-min.js',
        'themes/joli/js/plugins/morris/morris.min.js',
        'themes/joli/js/plugins/rickshaw/d3.v3.js',
        'themes/joli/js/plugins/rickshaw/rickshaw.min.js',
        'themes/joli/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
        'themes/joli/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
        'themes/joli/js/plugins/bootstrap/bootstrap-datepicker.js',
        'themes/joli/js/plugins/owl/owl.carousel.min.js',
        'themes/joli/js/plugins/moment.min.js',
        'themes/joli/js/plugins/daterangepicker/daterangepicker.js',
        'themes/joli/js/settings.js',
        'themes/joli/js/plugins.js',
        'themes/joli/js/actions.js',
        'themes/joli/js/demo_dashboard.js',
    ];

    public $depends = [
//        'uni\web\JqueryAsset',
    ];
}