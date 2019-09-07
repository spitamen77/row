<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 06.06.2017
 * Time: 23:40
 */

namespace app\modules\users\controllers;


use app\components\Controller;
use app\models\Company;
use app\models\UserModel;
use Uni;

class GroupsController extends Controller
{
    public $cm="users";
    public function actionGrid(){
        $user=\Uni::$app->getUser()->getId();
        $companies=Company::find()->where("uni_company_users.user_id=".$user)->joinWith("users")->joinWith('users.user')->all();
        //print_r($companies);exit;
        return $this->render('grid',['companies'=>$companies]);
    }
    public function actionAdd(){
        //Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $searchModel = new UserModel();
        $dataProvider = $searchModel->mysearch(Uni::$app->request->queryParams);
        // echo "<pre>";
        // foreach ($dataProvider as $key => $value) {
        //     print_r($value);
        //     echo "<br>";
        // }
        // exit;
        //var_dump($dataProvider);exit;
        return $this->render('add',['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }
}