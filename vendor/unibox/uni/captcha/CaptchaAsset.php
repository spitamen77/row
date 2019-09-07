<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\captcha;

use uni\web\AssetBundle;

/**
 * This asset bundle provides the javascript files needed for the [[Captcha]] widget.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class CaptchaAsset extends AssetBundle
{
    public $sourcePath = '@uni/assets';
    public $js = [
        'uni.captcha.js',
    ];
    public $depends = [
        'uni\web\UniAsset',
    ];
}
