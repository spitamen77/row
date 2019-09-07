<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 10.12.2018 12:27
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

namespace app\modules\settings\controllers;

use app\models\Lang;
use app\models\Prixod;
use app\models\Viloyat;
//use app\models\search\PrixodSearch;
use app\components\Controller;
use app\models\Vaksina;
use app\models\VkViloyat;
use uni\helpers\ArrayHelper;
use uni\web\ForbiddenHttpException;
use uni\web\NotFoundHttpException;
use uni\data\ActiveDataProvider;
use Uni;

/**
 * ArrivalController implements the CRUD actions for Prixod model.
 */
class ArrivalController extends Controller
{
    public $block="/left";
    public $cm="settings";
    public $layout="/settings";
    public function beforeAction($action)
    {
        if(!$this->access('ADMIN')){
            throw new ForbiddenHttpException('Sizda bu sahifa uchun ruxsat mavjud emas');
        }
        return parent::beforeAction($action);
    }
    /**
     * Lists all Prixod models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Prixod();
        $current = Lang::getCurrent();
        $data =$model->search(Uni::$app->request->queryParams);

        $data->pagination->pageSize=20;
        $vaksina = Vaksina::find()->where(['status'=>Vaksina::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        if ($current->url=="ru") $map2 = ArrayHelper::map($vaksina,'id','name_ru');
        else $map2 = ArrayHelper::map($vaksina,'id','name_uz');


        $vil = [];
        $viloyat = Viloyat::find()->where(['status'=>Viloyat::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        foreach ($viloyat as $v) {
            $vil[$v->id] = $v->name;
        }


        return $this->render('index', ['items'=>$data, "new"=>$model, 'vaksina'=>$map2, 'viloyat'=>$vil]);
    }
    public function actionPrixod($id)
    {
        $new = new Prixod();
        $current = Lang::getCurrent();
        $viloyat = new ActiveDataProvider([
            'query' => VkViloyat::find()->where(['proxod_id'=>$id])->orderBy(["id"=>SORT_DESC])
        ]);
        $viloyat->pagination->pageSize=20;

        $prixod = Prixod::findOne($id);

        $vaksina = Vaksina::find()->where(['status'=>Vaksina::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        if ($current->url=="ru") $map2 = ArrayHelper::map($vaksina,'id','name_ru');
        else $map2 = ArrayHelper::map($vaksina,'id','name_uz');


        return $this->render('prixod', ['viloyat'=>$viloyat, "prixod"=>$prixod, 'new'=>$new, 'vaksina'=>$map2]);
    }

    /**
     * Displays a single Prixod model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        $id = $_GET['id'];
        $view = $this->findModel($id);
        if (!empty($view)){
//            if (Uni::$app->language=="ru") $viloyat = $view->viloyat->name_ru;
//            else $viloyat =  $view->viloyat->name_uz;
            \Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            return [
                'name_ru'=>$view->name_ru,
                'name_uz'=>$view->name_uz,
                'vaksina'=>$view->vaksina->name,
                'count'=>$view->count,
                'unit'=>$view->unit->name,
            ];
        }
        else return "error";
    }

    public function actionSave(){
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $model = new Prixod();
        parse_str($_POST['data'],$data);
        if ($model->load($data)) {
//            return ['status' => $model->{'count'}];
            $d1 = strtotime($model->{'prixod_date'}); // переводит из строки в дату
            $model->{'prixod_date'} = $d1+25000;
            $model->{'status'} = 1;

            if ($model->save()) {
                return ['status' => 'success'];
            } else {
                return ['status'=>'error'];
            }
        }
//        $model->name_uz = $_POST['uzb'];
//        $model->name_ru = $_POST['rus'];
//        if ($model->save()) {
//            return 'success';
//        }
//        else return "error";
    }


    public function actionKg()
    {
        $id = $_GET['id'];
        $model = Vaksina::findOne($id);
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        if (!empty($model)) return ['status' => $model->unit->name,
            'val'=>$model->unit_id,
            'doza'=>$model->doza,
        ];
        else return ['status' => "error"];
    }

    /**
     * Updates an existing Prixod model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Uni::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_Prixod]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionEdit($id){
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if(!$model){
            throw new NotFoundHttpException;
        }
        $data = [];
        parse_str($_POST['data'],$data);
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
     * Deletes an existing Prixod model.
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

    public function actionDownload($id){
        $item = Vaksina::findOne($id);
        return Uni::$app->response->sendFile(Uni::getAlias('@webroot').$item->file);
    }

    /**
     * Finds the Prixod model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Prixod the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Prixod::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
