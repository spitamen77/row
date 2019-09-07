<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 12.06.2017
 * Time: 14:03
 */

namespace app\modules\settings\controllers;

use app\components\manager\Url;
use app\models\Vaksina;
use app\models\VaksinaTuri;
use app\models\UserModel;
use Uni;
use app\components\Controller;
use app\models\VkViloyat;
use uni\web\NotFoundHttpException;
use uni\data\ActiveDataProvider;
use app\models\Prixod;
use app\models\Tuman;
use app\models\VaksinaPerform;
use app\models\Viloyat;
use app\models\VkTuman;
use app\models\Lang;
use uni\helpers\ArrayHelper;
use uni\db\Query;
use app\models\DiagnozPerform;
use app\models\DiagnozXulosa;
class DiagnoseController extends Controller
{
    public $cm="diagnose";
    public function actionIndex(){
        $user = Uni::$app->getUser()->identity;

        $data = new ActiveDataProvider([
           'query' => DiagnozPerform::find()->orderBy(["id"=>SORT_DESC])
        ]);
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
    public function actionColcsave(){
        $this->enableCsrfValidation = false;
        if (isset($_POST['colcsave'])) {
            $model = new DiagnozXulosa();
            $model->matn = "dsajsdkjasbdjk";
            $model->fayl = "dsajsdkjasbdjk";
            $model->user_id = Uni::$app->getUser()->identity->id;
            $model->diagnoz_id = 1;
            $model->save(false);
            return redirect(['view', 'id' => $model->diagnoz_id]);
        }
    }

}