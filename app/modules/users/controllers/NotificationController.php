<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 11.08.2017
 * Time: 10:45
 */

namespace app\modules\users\controllers;


use app\components\Controller;
use app\models\Notification;
use app\models\GroupsUsers;
use uni\data\ActiveDataProvider;
use Uni;

class NotificationController extends Controller
{
    public $layout = '/profile';
    public function actionIndex(){
        $role = GroupsUsers::find()->where(['user_id'=>Uni::$app->getUser()->getId()])->all();
        $rol = array();
        foreach ($role as $key => $value) {
            $rol[$key]=$value->group_id;
        }
        $data = Notification::find()->where(['role_id'=>$rol,'status'=>1])->orderBy(['created_date'=>SORT_DESC])->all();
        return $this->render('notification', [
            'data' => $data
        ]);
    }
    

}