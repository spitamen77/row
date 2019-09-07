<?php
/**
 * Created by PhpStorm.
 * User: Rashidov
 * Date: 01.07.2015
 * Time: 22:58
 */

namespace app\assets;

use app\modules\cpanel\CPanel;
use uni\web\AssetBundle;

class CoreAssets extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'themes/ui/assets/skins/dropify/css/dropify.css',
        'themes/ui/components/uikit/css/uikit.almost-flat.min.css',
        'themes/ui/assets/icons/flags/flags.min.css',
        'themes/ui/assets/css/main.min.css',
        'themes/ui/assets/css/themes/themes_combined.min.css',
        'themes/ui/components/fullcalendar/dist/fullcalendar.min.css',
        'themes/ui/assets/css/custom.css',
        //'themes/ui/components/c3js-chart/c3.min.css'
    ];
    public $js = [
        "themes/ui/assets/js/common.min.js",
        "themes/ui/assets/js/uikit_custom.min.js",
        "themes/ui/assets/js/altair_admin_common.min.js",
        "themes/ui/assets/js/custom/dropify/dist/js/dropify.min.js",
        "themes/ui/assets/js/pages/forms_file_input.min.js",
        "themes/ui/components/fullcalendar/dist/fullcalendar.min.js",
        "themes/ui/assets/js/pages/plugins_fullcalendar.min.js",
        "themes/ui/assets/js/pages/plugins_idle_timeout.js",
        "themes/ui/components/jquery-idletimer/dist/idle-timer.min.js",
        "themes/ui/assets/js/muxr.js",
        "themes/ui/assets/js/vaksina.js",
        "themes/ui/assets/js/handlebars.min.js",
        "themes/ui/core/main.js",
        "themes/ui/assets/js/pages/components_notifications.min.js",
    ];

    public $depends = [
        'uni\web\UniAsset'
    ];
} 