<?php

namespace app\modules\cpanel;

use app\models\Configuration;
use app\models\Modules;

class CPanel extends \uni\base\Module
{
    public $controllerNamespace = 'app\modules\cpanel\controllers';
    public $id="cpanel";
    public function init()
    {
        if(!Modules::find()->where(["code"=>$this->id])->one()){
            $module=new Modules();
            $module->code=$this->id;
            $module->title="Control Panel";
            $module->icon="fa fa-cog";
            $module->sort=9;
            $module->active=1;
            $module->save();
        }
        parent::init();

    }
    public function getName(){
        return "cpanel";
    }
    public static function getTheme(){
        $conf=Configuration::find()->where(["name"=>"theme"])->one();
        if($conf){return $conf->value;}else{
            return "theme_light.css";
        }
    }
}
