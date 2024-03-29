<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2015
 * @package uni-widgets
 * @subpackage uni-widget-datepicker
 * @version 1.3.4
 */

namespace kartik\date;

/**
 * Asset bundle for DatePicker Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class DatePickerAsset extends \kartik\base\AssetBundle
{
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/bootstrap-datepicker3', 'css/datepicker-kv']);
        $this->setupAssets('js', ['js/bootstrap-datepicker', 'js/datepicker-kv']);
        parent::init();
    }
}
