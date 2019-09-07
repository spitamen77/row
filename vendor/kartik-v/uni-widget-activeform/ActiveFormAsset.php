<?php

/**
 * @copyright  Copyright &copy; Kartik Visweswaran, Krajee.com, 2015
 * @package    uni-widgets
 * @subpackage uni-widget-activeform
 * @version    1.4.7
 */

namespace kartik\form;

/**
 * Asset bundle for ActiveForm Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since  1.0
 */
class ActiveFormAsset extends \kartik\base\AssetBundle
{
    public $depends = [
        'uni\bootstrap\BootstrapPluginAsset'
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/activeform']);
        $this->setupAssets('js', ['js/activeform']);
        parent::init();
    }
}
