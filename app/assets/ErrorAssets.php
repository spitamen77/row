<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 06.06.2017
 * Time: 22:24
 */

namespace app\assets;


use uni\web\AssetBundle;

class ErrorAssets extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'themes/ui/assets/css/error_page.min.css',

    ];
    public $js = [

    ];

    public $depends = [
        'app\assets\CoreAssets'
    ];
}