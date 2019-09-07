<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 12.06.2017
 * Time: 14:03
 */

namespace app\modules\laboratory\controllers;

use app\components\manager\Url;
use Uni;
use app\components\Controller;
use uni\web\NotFoundHttpException;
use uni\data\ActiveDataProvider;
use app\models\Prixod;
use app\models\Lang;
use app\models\DiagnozPerform;
use app\models\DiagnozXulosa;
class LaboratoryController extends Controller
{
    public $cm="diagnose";
    public function actionIndex(){
        $user = Uni::$app->getUser()->identity;

        

    }
    
    public function actionSave(){
        //Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $this->enableCsrfValidation = false;
        echo "sadasdasd";exit;
        if (isset($_POST)) {
            var_dump($_FILES);exit;
            $model = new DiagnozXulosa();
            $model->matn = "dsajsdkjasbdjk";
            $model->fayl = "dsajsdkjasbdjk";
            $model->user_id = Uni::$app->getUser()->identity->id;
            $model->diagnoz_id = 1;
            var_dump($model);exit;
            //$model->save(false);
            return redirect(['view', 'id' => $model->diagnoz_id]);
        }

    }

}