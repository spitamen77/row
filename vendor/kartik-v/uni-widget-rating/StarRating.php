<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package uni-widgets
 * @subpackage uni-widget-rating
 * @version 1.0.0
 */

namespace kartik\rating;

use Uni;
use uni\helpers\Html;
use uni\helpers\ArrayHelper;
use uni\base\InvalidConfigException;
use uni\web\View;
use uni\web\JsExpression;

/**
 * StarRating widget is a wrapper widget for the Bootstrap Star Rating plugin by Krajee.
 * This plugin is a simple star rating yet powerful control that converts a  'number' input
 * to a star rating control using JQuery. The widget is styled for Bootstrap 3.0.
 *
 * Upgraded for the new plugin support. Includes fractional ratings with editable star
 * symbol, RTL inputs, and custom styling.
 *
 * @see http://plugins.krajee.com/star-rating
 * @see http://github.com/kartik-v/bootstrap-star-rating
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class StarRating extends \kartik\base\InputWidget
{
    /**
     * @inherit doc
     * @throw InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->registerAssets();
        if ($this->pluginLoading) {
            Html::addCssClass($this->options, 'rating-loading');
        }
        echo $this->getInput('textInput');
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        StarRatingAsset::register($view);
        $this->registerPlugin('rating');
    }
}
