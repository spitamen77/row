<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\widgets;

use uni\web\AssetBundle;

/**
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class FormAsset extends AssetBundle
{
    public $sourcePath = '@uni/assets';
    public $js = [
        'form.js',
    ];
    public $depends = [
        'uni\web\UniAsset',
    ];
}
