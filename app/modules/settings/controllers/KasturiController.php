<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 04.12.2018 12:31
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

namespace app\modules\settings\controllers;


use app\models\KasalTuri;
use uni\web\NotFoundHttpException;
use uni\web\ForbiddenHttpException;
use Uni;
use uni\data\ActiveDataProvider;

class KasturiController extends \app\components\Controller
{
    public $block="/left";
    public $cm="settings";
    public $layout="/settings";

    public function beforeAction($action)
    {
        if(!$this->access('ADMIN')){
            throw new ForbiddenHttpException('Sizda bu sahifa uchun ruxsat mavjud emas!');
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $new = new KasalTuri();
        $data = new ActiveDataProvider([
            'query' => KasalTuri::find()->where(['status'=>KasalTuri::STATUS_ACTIVE])->orWhere(['status'=>KasalTuri::STATUS_INACTIVE])->orderBy(["id"=>SORT_DESC])
        ]);
        $data->pagination->pageSize=20;
        if (Uni::$app->request->get('q')){
            $key = Uni::$app->request->get('q');
            $all = new ActiveDataProvider([
                'query' => KasalTuri::find()->where("`vk_kasal_turi`.`status`!=9 and (`vk_kasal_turi`.`name_ru` like '%" . $key . "%' or `vk_kasal_turi`.`name_uz` like '%" . $key . "%')")
            ]);
        }
        else $all = false;
        return $this->render('index', ['items'=>$data, 'new'=>$new, 'query'=>$all]);
    }

    public function actionView()
    {
        $id = $_GET['id'];
        $view = $this->findModel($id);
        if (!empty($view)){
            \Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            return [
                'name_ru'=>$view->name_ru,
                'name_uz'=>$view->name_uz,
            ];
        }
        else return "error";
    }

    public function actionSave(){
        $model = new KasalTuri();
        $model->name_uz = $_POST['uzb'];
        $model->name_ru = $_POST['rus'];
        $model->status = 1;
//        $model->user_id = Uni::$app->getUser()->getId();
        if ($model->save()) {
            return 'success';
        }
        else return "error";
    }


    public function actionEdit($id){
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if(!$model){
            throw new NotFoundHttpException;
        }
        $data = [];
        parse_str($_POST['data'],$data);
//        return $data;
        if ($model->load($data)) {
            if ($model->save()) {

                return ['status' => 'successEditLoad'];
            } else {

                return ['status' => 'unsuccessEditLoad'];
            }
        }
        else {
            return ['status' => 'failEditLoad'];
        }
    }

    public function actionChangestatus($id){
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $direction = $this->findModel($id);
        if (!empty($direction)){
            if($direction->status == 0){
                $direction->status = 1;
            }
            else{
                $direction->status = 0;
            }
//            $direction->user_id = Uni::$app->getUser()->getId();
//            $direction->updated_at = time();
            if($direction->save()){
                return ['status' => 'statusChanged'];
            }
            return ['status' => 'statusUnchanged'];
        }
        else return ['status' => 'statusUnchanged'];
    }

    /**
     * Deletes an existing KasalTuri model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (!empty($model)){
            $model->status = 9;
//            $model->user_id = Uni::$app->getUser()->getId();
//            $model->updated_at = time();
            $model->save(false);
            Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            return ['status'=>'success'];
        }
        else return ['status'=>'error'];
    }

    /**
     * Finds the KasalTuri model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return KasalTuri the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KasalTuri::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}