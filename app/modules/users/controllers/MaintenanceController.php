<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 3/15/19
 * Time: 14:00
 */

namespace app\modules\users\controllers;

use Uni;
use uni\base\Exception;
use uni\base\UserException;
use uni\web\Controller;
use uni\web\HttpException;

class MaintenanceController extends Controller
{   public $block='';
    public $layout='/empty';
    public function actionIndex(){

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
            $this->layout="/error";
            if($code=="400"){
                return $this->render("400", [
                    'name' => $name,
                    'message' => $message,
                    'exception' => $exception,
                ]);
            }
            if($code=="404"){
                return $this->render("404", [
                    'name' => $name,
                    'message' => $message,
                    'exception' => $exception,
                ]);
            }
            if($code=="403"){
                return $this->render("403", [
                    'name' => $name,
                    'message' => $message,
                    'exception' => $exception,
                ]);
            }
            return $this->render("error", [
                'name' => $name,
                'message' => $message,
                'exception' => $exception,
            ]);
        }
    }
}