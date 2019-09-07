<?php
/**
 * Created by PhpStorm.
 * User: Rashidov
 * Date: 16.03.2015
 * Time: 23:38
 */

namespace app\components\manager;

use uni\web\UrlManager;
use app\models\Lang;

class LangUrlManager extends UrlManager
{
    public function createUrl($params)
    {

        if( isset($params['lang_id']) ){
            $lang = Lang::findOne($params['lang_id']);
            if( $lang === null ){
                $lang = Lang::getDefaultLang();
            }
            unset($params['lang_id']);
        } else {

            $lang = Lang::getCurrent();
        }
        $url = parent::createUrl($params);
        if( $url == '/' ){
            return '/'.$lang->url;
        }else{
            return $url;
        }
    }
}