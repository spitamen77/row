<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2015
 * @package uni-widgets
 * @subpackage uni-widget-select2
 * @version 2.0.6
 */

namespace kartik\select2;

use kartik\base\AssetBundle;

/**
 * Bootstrap Select2 theme
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class ThemeBootstrapAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/select2-bootstrap']);
        parent::init();
    }
}
