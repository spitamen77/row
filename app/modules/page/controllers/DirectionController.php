<?php

namespace app\modules\page\controllers;


use app\components\Controller;
use app\models\PaymentTransaction;
use app\models\TarifCompany;
use app\models\Tariffs;

class DirectionController extends Controller
{
    //Layout biriktirish
    public $layout = '/kasb';
    
    public function actionIndex()
    {
        echo "Direction";
        //return $this->render('index');
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
        $name=Uni::t("app", $name);
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
