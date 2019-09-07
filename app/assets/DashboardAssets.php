<?php
namespace app\assets;
use uni\web\AssetBundle;

class DashboardAssets extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'themes/ui/components/chartist/dist/chartist.min.css',
        'themes/ui/components/weather-icons/css/weather-icons.min.css',
        'themes/ui/components/metrics-graphics/dist/metricsgraphics.css',
        'themes/ui/assets/css/main.min.css',
        'themes/ui/assets/css/themes/themes_combined.min.css',
        'themes/ui/assets/css/custom.css',
    ];
    public $js = [
        "themes/ui/components/d3/d3.min.js",
        "themes/ui/components/metrics-graphics/dist/metricsgraphics.min.js",
        "themes/ui/components/chartist/dist/chartist.min.js",
        "themes/ui/components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js",
        "themes/ui/components/peity/jquery.peity.min.js",
        "themes/ui/components/countUp.js/dist/countUp.min.js",
        "themes/ui/components/handlebars/handlebars.min.js",
        "themes/ui/assets/js/custom/handlebars_helpers.min.js",
        "themes/ui/components/clndr/clndr.min.js",
        "themes/ui/assets/js/pages/dashboard.js",
    ];

    public $depends = [
        'app\assets\CoreAssets'
    ];
}