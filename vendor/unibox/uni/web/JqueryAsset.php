<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\web;

/**
 * This asset bundle provides the [jquery javascript library](http://jquery.com/)
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class JqueryAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery/dist';
    public $js = [
        'jquery.js',
    ];
}
