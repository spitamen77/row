<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 12/17/18
 * Time: 11:38
 */

namespace app\modules\arrival\controllers;

use app\models\Lang;
use app\models\Prixod;
use app\models\Vaksina;
use app\models\VkViloyat;
use Uni;
use app\components\Controller;
use uni\data\ActiveDataProvider;
use uni\helpers\ArrayHelper;

class DefaultController extends Controller
{
    public function actionIndex(){
        $user = Uni::$app->getUser()->identity;

        $search = new Prixod();
        $provider = $search->search(\Uni::$app->request->queryParams);
        return $this->render('index',[
            "dataProvider"=>$provider,
            "search"=>$search
        ]);
    }
    
    public function actionView($id){
        $model=Vaksina::findOne($id);
        return $this->render("view",['model'=>$model]);
    }
}