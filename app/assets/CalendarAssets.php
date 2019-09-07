<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 27.04.2017
 * Time: 18:39
 */

namespace app\assets;


use uni\web\AssetBundle;

class CalendarAssets extends AssetBundle
{
    public $css = [
        "themes/widgets/fullcalendar/fullcalendar.min.css",
    ];
    public $js = [
        "themes/widgets/fullcalendar/fullcalendar.min.js",
        "themes/widgets/fullcalendar/calendar.js",

    ];
    public $depends = [
        'app\assets\CoreAssets',
    ];
}