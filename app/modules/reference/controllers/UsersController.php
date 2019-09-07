<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 17.06.2017
 * Time: 11:37
 */

namespace app\modules\reference\controllers;


use app\components\behaviors\StatusController;
use app\components\Controller;
use app\models\UserModel;
use uni\web\NotFoundHttpException;

class UsersController extends Controller
{
    public function behaviors()
    {
        return [
                       [
                'class' => StatusController::className(),
                'model' => UserModel::className()
            ]
        ];
    }
    public function actionChangestatus($id){
        $model=UserModel::findOne(['id'=>$id]);
        if(!$model) throw new NotFoundHttpException;
        $st=1;
        if($model->status)$st=0;
        return $this->changeStatus($id, $st);
    }
    public function actionView($id){
        $model=UserModel::findOne(['id'=>$id]);
        if(!$model) throw new NotFoundHttpException;
        return $this->render('view',['user'=>$model]);
    }
    public function actionError(){
        if (($exception = Uni::$app->getErrorHandler()->exception) === null) {
            return '';
        }

        if ($exception instanceof HttpException) {
            $code = $exception->statusCode;
        } else {
            $code = $exception->getCode();
        }
        if ($exception instanceof Exception) {
            $name = $exception->getName();
        } else {
            $name =  Uni::t('app', 'Error');
        }
        $name=Uni::t("app",$name);
        if ($code) {
            $name .= " (#$code)";
        }

        if ($exception instanceof UserException) {
            $message = $exception->getMessage();
        } else {
            $message =  Uni::t('app', 'An internal server error occurred.');
        }

        if (Uni::$app->getRequest()->getIsAjax()) {
            return "$name: $message";
        } else {
            return $this->render("error", [
                'name' => $name,
                'message' => $message,
                'exception' => $exception,
            ]);
        }
    }
}