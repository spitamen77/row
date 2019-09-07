<?php
/**
 * Created by PhpStorm.
 * User: Rashidov
 * Date: 10.04.2015
 * Time: 11:25
 */

namespace app\components\manager;


use app\components\Model;

class Url {
public static function to($url){
return "/".Model::getLang()."/".$url;
}
    public static function getMain(){
        $url=\Uni::$app->request->url;
        $m=explode("?",$url);
        if(!empty($m))$url=$m[0];
        return $url;
    }
} 