<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 12/15/18
 * Time: 17:47
 */

namespace app\assets;


use uni\web\AssetBundle;

class MapAssets extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'themes/ui/components/map/css/leaflet.css',
        'themes/ui/components/map/css/L.Icon.Pulse.css',

    ];
    public $js = [
        "themes/ui/components/map/js/leaflet-src.js",
        "themes/ui/components/map/js/L.Icon.Pulse.js",
        "themes/ui/components/map/js/BoundaryCanvas.js",

    ];

    public $depends = [
        'app\assets\CoreAssets'
    ];
}