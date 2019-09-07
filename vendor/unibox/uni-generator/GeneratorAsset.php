<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\generator;

use uni\web\AssetBundle;

/**
 * This declares the asset files required by Gii.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class GeneratorAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@uni/generator/assets';
    /**
     * @inheritdoc
     */
    public $css = [
        'main.css',
        'typeahead.js-bootstrap.css',
    ];
    /**
     * @inheritdoc
     */
    public $js = [
        'generator.js',
        'typeahead.js',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'uni\web\UniAsset',
        'uni\ui\UIAsset',
        'uni\ui\BootstrapPluginAsset',
    ];
}
