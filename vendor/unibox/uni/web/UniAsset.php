<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\web;

/**
 * This asset bundle provides the base javascript files for the Uni Framework.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class UniAsset extends AssetBundle
{
    public $sourcePath = '@uni/assets';
    public $js = [
        'core.js',
    ];
    public $depends = [
        'uni\web\JqueryAsset',
    ];
}
