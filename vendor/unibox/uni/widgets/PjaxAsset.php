<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\widgets;

use uni\web\AssetBundle;

/**
 * This asset bundle provides the javascript files required by [[Pjax]] widget.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class PjaxAsset extends AssetBundle
{
    public $sourcePath = '@bower/uni-pjax';
    public $js = [
        'jquery.pjax.js',
    ];
    public $depends = [
        'uni\web\UniAsset',
    ];
}
