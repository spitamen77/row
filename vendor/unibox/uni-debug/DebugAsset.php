<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\debug;

use uni\web\AssetBundle;

/**
 * Debugger asset bundle
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class DebugAsset extends AssetBundle
{
    public $sourcePath = '@uni/debug/assets';
    public $css = [
        'main.css',
        'toolbar.css',
    ];
    public $depends = [
        'uni\web\UniAsset',
        'uni\ui\UIAsset',
    ];
}
