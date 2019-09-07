<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 27.06.2017
 * Time: 23:38
 */

namespace app\assets;


class FieldsAsset extends \uni\web\AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'themes/ui/assets/css/fields.css',
    ];
    public $js = [
        'themes/ui/assets/js/fields.js'
    ];
    public $depends = [
        'uni\web\JqueryAsset',
    ];
}
