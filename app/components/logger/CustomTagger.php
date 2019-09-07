<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 27.01.2015
 * Time: 15:44
 */
namespace app\components\logger;
 class CustomTagger{
public $tagger=false;
     public function start(){
         $logsession=new \app\models\LogSession();
         $this->tagger=$logsession->getUniqTag();
     }
     public function getTag(){
         return $this->tagger;
     }
}