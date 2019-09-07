<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package uni-widgets
 * @subpackage uni-widget-growl
 * @version 1.1.1
 */

namespace kartik\growl;

/**
 * Asset bundle for \kartik\widgets\Growl
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class GrowlAsset extends \kartik\base\AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/kv-bootstrap-notify']);
        $this->setupAssets('js', ['js/bootstrap-notify']);
        parent::init();
    }

    /**
     * Adds a theme CSS file
     *
     * @param string $theme the theme name
     *
     * @return kartik\growl\GrowlAsset object instance
     */
    public function addTheme($theme)
    {
        $ext = UNI_DEBUG ? '.css' : '.min.css';
        $this->css[] = "css/{$theme}{$ext}";
        return $this;
    }
}