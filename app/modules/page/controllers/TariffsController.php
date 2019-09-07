<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 07.07.2017
 * Time: 18:45
 */

namespace app\modules\page\controllers;

use app\models\TarifCompany;
use app\models\Tariffs;
use Uni;
use app\components\Controller;

class TariffsController extends Controller
{


    public function actionDelete($id){
        $model=Tariffs::findOne(['id'=>$id]);
        if($model->delete()){
            return [1=>'success'];
        }else{
            return [1=>'error'];
        }
    }
    public function actionChangestatus($id){

    }
    public function actionView($id){

    }
    public function actionValidate(){

    }
    public function actionSave(){
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        if(Uni::$app->request->isPost){
            $data=[];
            parse_str($_POST['data'], $data);
            if(isset($data["Tariffs"])){
                $res=$this->loadModel("Tariffs","id",$data);
                if($res&&empty($res->getErrors())){
                    return ['status' => 'success', 'id' => $res->id,'message'=>Uni::t('app','Information saved!')];
                } else {
                    return $res->getErrors();
                }
            }
        }
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