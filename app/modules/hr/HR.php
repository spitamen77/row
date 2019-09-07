<?php

namespace app\modules\hr;

use app\models\SedModules;

class HR extends \uni\base\Module
{
    public $controllerNamespace = 'app\modules\hr\controllers';
    public $id="hr";
    public function init()
    {
        // if(!SedModules::find()->where(["code"=>$this->id])->one()){
        //     $module=new SedModules();
        //     $module->code=$this->id;
        //     $module->title="HR";
        //     $module->icon="fa fa-cog";
        //     $module->sort=2;
        //     $module->active=1;
        //     $module->save();
        // }
        parent::init();

        // custom initialization code goes here
    }
    public function getName(){
        return "hr";
    }
}
