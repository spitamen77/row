<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014-2015
 * @package uni-widgets
 * @subpackage uni-widget-spinner
 * @version 1.0.1
 */

namespace kartik\spinner;

use Uni;

/**
 * Asset bundle for Spinner Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class SpinnerAsset extends \kartik\base\AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/spin']);
        $this->setupAssets('js', ['js/spin', 'js/jquery.spin']);
        parent::init();
    }
}