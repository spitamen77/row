<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 20.07.2017
 * Time: 16:15
 */

namespace app\assets;


use uni\web\AssetBundle;

class DesAsset extends AssetBundle{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [


    ];
    public $js = [
        "themes/ui/des/e-imzo.js",
        "themes/ui/des/e-imzo-client.js",
        "themes/ui/des/startup.js",

    ];

    public $depends = [
        'app\assets\CoreAssets'
    ];
}