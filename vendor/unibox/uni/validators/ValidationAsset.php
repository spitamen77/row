<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\validators;

use uni\web\AssetBundle;

/**
 * This asset bundle provides the javascript files for client validation.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class ValidationAsset extends AssetBundle
{
    public $sourcePath = '@uni/assets';
    public $js = [
        'validation.js',
    ];
    public $depends = [
        'uni\web\UniAsset',
    ];
}
