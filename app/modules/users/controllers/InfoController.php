<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 24.06.2017
 * Time: 23:56
 */

namespace app\modules\users\controllers;

use app\models\UserInfo;
use Uni;
use app\components\Controller;
use uni\helpers\Url;
use uni\ui\Form;

class InfoController extends Controller
{
    public function actionAdd(){
        $user=Uni::$app->getUser()->getIdentity();
        $model=UserInfo::findOne(['user_id'=>$user->id]);
        if(!$model) $model=new UserInfo();
        if ($model->load(Uni::$app->request->post())) {
            if(Uni::$app->request->isAjax) {
                Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
                return Form::validate($model);
            }else {
                if ($model->save()) {
                    $this->flash('success', Uni::t('app', 'Item created'));
                    return $this->redirect(Url::to('users/profile/view/'.$user->id));
                } else {
                    $this->flash('error', Uni::t('app', 'Create error. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        }
        else {
            return $this->render('add', [
                'model' => $model,
                'user' => $user,
            ]);
        }
    }
    public function actionSave(){
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        if(Uni::$app->request->isPost){
            $data=[];
            parse_str($_POST['data'], $data);

            if(isset($data["UserInfo"])){
                $res=$this->loadModel("UserInfo","id",$data);
                if($res&&empty($res->getErrors())){
                    return ['status' => 'success', 'id' => $res->id,'message'=>Uni::t('app','Information saved!')];
                } else {
                    return $res->getErrors();
                }
            }

        }
    }

    public function actionValidation()
    {
        $info = new UserInfo();
        if ($info->load(Uni::$app->request->post())) {

            if (Uni::$app->request->isAjax) {
                Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
                return Form::validate($info);
            }
        }
    }
}