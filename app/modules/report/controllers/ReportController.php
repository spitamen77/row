<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 12/17/18
 * Time: 11:38
 */

namespace app\modules\report\controllers;

use app\models\Lang;
use app\models\Prixod;
use app\models\Vaksina;
use app\models\VkViloyat;
use Uni;
use app\components\Controller;
use uni\data\ActiveDataProvider;
use uni\helpers\ArrayHelper;

class ReportController extends Controller
{
    public function actionDaily($viloyat_id){
        $user = Uni::$app->getUser()->identity;

        
        $data = new ActiveDataProvider([
            'query' => Vaksina::find()->orderBy(["id"=>SORT_DESC])
        ]);
        $data->pagination->pageSize=15;
        return $this->render("index", [
            'dataProvider' => $data,
        ]);
    }
    public function actionView($id){
        $model=Vaksina::findOne($id);
        return $this->render("view",['model'=>$model]);
    }
}