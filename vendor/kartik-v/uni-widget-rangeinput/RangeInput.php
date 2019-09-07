<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package uni-widgets
 * @subpackage uni-widget-rangeinput
 * @version 1.0.1
 */

namespace kartik\range;

use Uni;
use uni\helpers\Html;

/**
 * RangeInput widget is an enhanced widget encapsulating the HTML 5 range input.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see http://twitter.github.com/typeahead.js/examples
 */
class RangeInput extends \kartik\base\Html5Input
{
    public $type = 'range';
    public $orientation;
    
    /**
     * @inherit doc
     */
    public function run() {
        if ($this->orientation == 'vertical') {
            Html::addCssClass($this->containerOptions, 'kv-range-vertical');
            $this->html5Options['orient'] = 'vertical';
        }
        parent::run();
    }
}
