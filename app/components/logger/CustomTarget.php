<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 21.01.2015
 * Time: 17:22
 */
namespace app\components\logger;

use Uni;
use app\models\LogType;
use app\models\AuthLog;
use app\models\LoggerAction as Logger;
class CustomTarget{
    private static $tag=null;

    public static function actionlog($message,$type,$response=""){
//        $logger= new Logger();
//        if(in_array($type,self::getLevels())) {
//            $logger->action_id =$type;
//            $logger->type_id = $type;
//            $logger->ip = GetIP::getIP();
//            $logger->message = $message;
//            $logger->date = time();
//            $user = Uni::$app->user;
//            $logger->user_id = $user->id ?: 0;
//            $logger->tag_id=self::$tag;
//            $logger->save(true);
//        }
    }
    public static function authlog($username,$password,$result=false){
//        $logger=new AuthLog();
//        $logger->login=$username;
//        $logger->ip=Uni::$app->getRequest()->getUserIP();
//        $logger->offtime=time();
//        $logger->ontime=time();
//        $logger->password=$password;
//        $logger->result=$result;
//        $logger->tag=self::$tag;
//
//        $logger->save();
    }
    public static function errorlog($message,$type,$response="")
    {
//        $loging = new Logger();
//
//        if (in_array($type, self::getLevels())) {
//            $url=Uni::$app->request->url;
//            $ip=GetIP::getIP();
//            $log=$loging->find()->where(['url'=>$url])->andWhere(['ip'=>$ip])->one();
//            if($log){
//                $log->date = time();
//                $log->save();
//            }else{
//            $logger=new Logger();
//            $logger->action_id = $type;
//            $logger->type_id = $type;
//            $logger->ip =$ip;
//            $logger->message = $message;
//            $logger->date = time();
//            $user = Uni::$app->user;
//            $logger->user_id = $user->id ?: 0;
//            $logger->tag_id = self::$tag;
//            $logger->save(true);
//            }
//        }
    }

    public static function setTag($tag){
    self::$tag=$tag;
}
}