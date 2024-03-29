<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package uni-widgets
 * @subpackage uni-widget-touchspin
 * @version 1.2.0
 */

namespace kartik\touchspin;

use uni\helpers\ArrayHelper;
use uni\helpers\Html;
use uni\helpers\Json;

/**
 * TouchSpin widget is a Uni2 wrapper for the bootstrap-touchspin plugin by
 * István Ujj-Mészáros. This input widget is a mobile and touch friendly input
 * spinner component for Bootstrap 3.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see http://www.virtuosoft.eu/code/bootstrap-touchspin/
 */
class TouchSpin extends \kartik\base\InputWidget
{
    /**
     * Initializes the widget
     *
     * @throw InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->setPluginOptions();
        $this->registerAssets();
        echo $this->getInput('textInput');
    }

    /**
     * Set the plugin options
     */
    protected function setPluginOptions()
    {
        $css = $this->disabled ? 'btn btn-default disabled' : 'btn btn-default';
        $defaults = [
            'buttonup_class' => $css,
            'buttondown_class' => $css,
            'buttonup_txt' => '<i class="glyphicon glyphicon-forward"></i>',
            'buttondown_txt' => '<i class="glyphicon glyphicon-backward"></i>',
        ];
        $this->pluginOptions = array_replace_recursive($defaults, $this->pluginOptions);
        if (ArrayHelper::getValue($this->pluginOptions, 'verticalbuttons', false) 
            && empty($this->pluginOptions['prefix'])) {
            Html::addCssClass($this->options, 'input-left-rounded');
        }
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        TouchSpinAsset::register($view);
        $this->registerPlugin('TouchSpin');
    }
}