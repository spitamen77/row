<?php

namespace app\modules\filemanager;

use app\models\Modules;

class Filemanager extends \uni\base\Module
{
    public $controllerNamespace = 'app\modules\filemanager\controllers';
    public $id="filemanager";
    public function init()
    {
        if(!Modules::find()->where(["code"=>$this->id])->one()){
            $module=new Modules();
            $module->code=$this->id;
            $module->title="File Manager";
            $module->icon="fa fa-cog";
            $module->sort=12;
            $module->active=1;
            $module->save();
        }
        parent::init();

        // custom initialization code goes here
    }
    public function getName(){
        return "filemanager";
    }
}
