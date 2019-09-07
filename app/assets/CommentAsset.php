<?php
namespace app\assets;

use uni\web\AssetBundle;

/**
 * Class CommentAsset
 *
 * @package uni2mod\comments
 */
class CommentAsset extends AssetBundle
{
    /**
     * {@inheritdoc}
     */
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    /**
     * {@inheritdoc}
     */
    public $js = [
        'themes/comments/js/comment.js',
    ];

    /**
     * {@inheritdoc}
     */
    public $css = [
        'themes/comments/css/comment.css',
    ];

    /**
     * {@inheritdoc}
     */
    public $depends = [
        'uni\web\JqueryAsset',
        'uni\web\UniAsset',
    ];
}
