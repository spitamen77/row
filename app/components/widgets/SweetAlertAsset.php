<?php
namespace app\components\widgets;

use uni\web\AssetBundle;

class SweetAlertAsset extends AssetBundle
{
	public $sourcePath = '@app/components/widgets/assets';
    // public $basePath = '@webroot';
    // public $baseUrl = '@web';
    public $css = [
        'css/sweet-alert.css',
    ];
    public $js = [
        'js/sweet-alert.min.js',
    ];
}
