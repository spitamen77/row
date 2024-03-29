<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2015
 * @package uni-widgets
 * @subpackage uni-widget-depdrop
 * @version 1.0.3
 */

namespace kartik\depdrop;

use kartik\base\AssetBundle;

/**
 * Asset bundle for Dependent Dropdown widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class DepDropAsset extends AssetBundle
{
    public function init()
    {
        $this->setSourcePath('@vendor/kartik-v/dependent-dropdown');
        $this->setupAssets('css', ['css/dependent-dropdown']);
        $this->setupAssets('js', ['js/dependent-dropdown']);
        parent::init();
    }
}
