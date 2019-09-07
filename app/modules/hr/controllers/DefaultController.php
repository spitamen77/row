<?php

namespace app\modules\hr\controllers;

use app\components\manager\Url;
use app\models\SedGraduatedSchools;
use Uni;

use app\models\SedPersonal;
use uni\web\Controller;
use app\models\forms\LoginForm;
use app\models\UserModel;
use uni\web\ForbiddenHttpException;
use uni\data\ActiveDataProvider;

class DefaultController extends \app\components\Controller
{
    public $cm="hr";
    public function actionIndex()
    {
        // if(!$this->access('ADMIN')){
        //     throw new ForbiddenHttpException('Sizda bu sahifa uchun ruxsat mavjud emas');
        // }
        $user = Uni::$app->getUser()->identity;
        $search = new SedPersonal();
        $data = $search->search(\Uni::$app->request->queryParams);
        
        // if($this->access('ADMIN_TUM')) $query = SedPersonal::find()->where(['tuman_id'=>$user->tuman_id])->orderBy(["per_id"=>SORT_DESC]);
        // if($this->access('ADMIN_VIL')) $query = SedPersonal::find()->where(['viloyat_id'=>$user->viloyat_id])->orderBy(["per_id"=>SORT_DESC]);
        // if($this->access('ADMIN')) $query = SedPersonal::find()->orderBy(["per_id"=>SORT_DESC]);
        // $data = new ActiveDataProvider([
        //    'query' => $query
        // ]);
        // $data->pagination->pageSize=15;
        return $this->render("/employee/list", [
            'data' => $data,
            'heading'=>"Действия пользователей в системе",
        ]);

        // $search = new SedPersonal();
        // $models = SedPersonal::find()->all();
        // //var_dump($models);exit;
        // return $this->render('/employee/list', [
        //     'models' => $models,
        //     'heading'=>"Действия пользователей в системе"
        // ]);


    }
    

}
