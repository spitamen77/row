<?php
namespace app\components\widgets;

use uni\web\AssetBundle;

class TinyMceAsset extends AssetBundle
{
    public $sourcePath = '@app/components/widgets/assets/tinymce';
    public $js = [
        'js/tinymce/jquery.tinymce.min.js',
        'js/tinymce/tinymce.min.js',

    ];
    public $depends = ['uni\web\JqueryAsset'];
} 
