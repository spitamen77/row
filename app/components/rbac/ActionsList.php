<?php
/**
 * Created by PhpStorm.
 * User: Rashidov
 * Date: 02.03.2015
 * Time: 19:26
 */

namespace app\components\rbac;


use app\controllers\SiteController;

class ActionsList {
    public static function getClass(){
        $classes=[];
        $dir = new  \DirectoryIterator(dirname(SiteController::$dir."/controllers"));
        foreach ($dir as $fileinfo) {
            if ($fileinfo->isFile()) {
                $file=preg_replace("/.php/","",$fileinfo->getBasename());
                $classes[$file]=self:: getMethodNameAndDoc($file);

            }
        }
        return $classes;
    }
    public static function getMethodNameAndDoc($class){
    $result=[];
        $reflect=new \ReflectionClass("app\\controllers\\".$class);
        foreach($reflect->getMethods() as $method){
            if(preg_match("/action([A-Z]+?)/",$method->getShortName())){
                if($method->getDocComment()){
                    $doc=$method->getDocComment();
                    $matches=null;
                    if(preg_match("/(@comment=)([a-zA-Z ]+[^\\*]+?)/",$doc,$matches)){
                        $result[$method->getShortName()]=$matches[2];
                    }
                }
            }
        }
    return $result;
    }
} 