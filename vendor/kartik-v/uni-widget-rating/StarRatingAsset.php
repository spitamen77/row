<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package uni-widgets
 * @subpackage uni-widget-rating
 * @version 1.0.0
 */

namespace kartik\rating;

use Uni;

/**
 * Asset bundle for StarRating Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class StarRatingAsset extends \kartik\base\AssetBundle
{
    public function init()
    {
        $this->setSourcePath('@vendor/kartik-v/bootstrap-star-rating');
        $this->setupAssets('css', ['css/star-rating']);
        $this->setupAssets('js', ['js/star-rating']);
        parent::init();
    }
}
