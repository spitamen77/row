<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 12.06.2017
 * Time: 14:03
 */

namespace app\modules\diagnose\controllers;

use app\components\manager\Url;
use app\models\Vaksina;
use app\models\VaksinaTuri;
use app\models\UserModel;
use Uni;
use uni\web\UploadedFile;
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
use app\components\widgets\FormGenerator;

class DefaultController extends Controller
{
    public $cm="diagnose";
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        if(!$this->access('VET')){
            //throw new ForbiddenHttpException('Sizda bu sahifa uchun ruxsat mavjud emas');
            return ['status' => 'Guest'];
        }
        return parent::beforeAction($action);
    }
    public function actionIndex(){
//        $user = Uni::$app->getUser()->identity;
//        if($this->access('LAB')||$this->access('ADMIN')||$this->access('HEAD'))
//            $query = DiagnozPerform::find()->orderBy(["id"=>SORT_DESC]);
//        if($this->access('LAB_VIL')||$this->access('ADMIN_VIL'))
//            $query = DiagnozPerform::find()->where(['viloyat_id'=>$user->viloyat_id])->orderBy(["id"=>SORT_DESC]);
//        if($this->access('LAB_TUM')||$this->access('ADMIN_TUM'))
//            $query = DiagnozPerform::find()->where(['tuman_id'=>$user->tuman_id])->orderBy(["id"=>SORT_DESC]);
        $query = new DiagnozPerform();
        $disease = DiagnozPerform::find()->where(['status'=>DiagnozPerform::STATUS_ACTIVE])->orWhere(['status'=>DiagnozPerform::STATUS_INACTIVE])->orderBy(["id"=>SORT_DESC])->all();
        $data =$query->search(Uni::$app->request->queryParams);
        $data->pagination->pageSize=15;
        return $this->render("index", [
            'dataProvider' => $data, 'disease'=>$disease
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