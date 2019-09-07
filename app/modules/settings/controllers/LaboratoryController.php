<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 12.06.2017
 * Time: 14:03
 */

namespace app\modules\settings\controllers;

use app\components\manager\Url;
use Uni;
use app\components\Controller;
use uni\web\NotFoundHttpException;
use uni\data\ActiveDataProvider;
use app\models\Prixod;
use app\models\Lang;
use app\models\DiagnozPerform;
class LaboratoryController extends Controller
{
    public $cm="diagnose";
    public function actionIndex(){
        $user = Uni::$app->getUser()->identity;

        if($this->access("ADMIN")){
            $data = new ActiveDataProvider([
               'query' => DiagnozPerform::find()->orderBy(["id"=>SORT_DESC])
            ]);
        }elseif($this->access("VIL")){
            $data = new ActiveDataProvider([
               'query' => DiagnozPerform::find()->where(['viloyat_id'=>$user->viloyat_id])->orderBy(["id"=>SORT_DESC])
            ]);
            
        }
        elseif($this->access("TUM")){
            $data = new ActiveDataProvider([
               'query' => DiagnozPerform::find()->where(['tuman_id'=>$user->tuman_id])->orderBy(["id"=>SORT_DESC])
            ]);
            
        }

        $data->pagination->pageSize=15;
        return $this->render("index", [
            'dataProvider' => $data,
        ]);

    }
    public function actionView($id){
        $model = DiagnozPerform::findOne($id);
        //var_dump($model->uchastka->makeFIO());exit;
        return $this->render("view", [
            'model' => $model,
        ]);
    }

}