<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\grid;

use uni\web\AssetBundle;

/**
 * This asset bundle provides the javascript files for the [[GridView]] widget.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class GridViewAsset extends AssetBundle
{
    public $sourcePath = '@uni/assets';
    public $js = [
        'uni.gridView.js',
    ];
    public $depends = [
        'uni\web\UniAsset',
    ];
}
