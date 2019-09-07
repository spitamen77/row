<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 28.11.2018 15:57
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

namespace app\modules\settings\controllers;

use app\models\Lang;
use app\components\Controller;
use app\models\Unit;
use app\models\Vaksina;
use app\models\VaksinaTuri;
use uni\helpers\ArrayHelper;
use uni\web\NotFoundHttpException;
use uni\web\ForbiddenHttpException;
use Uni;
use uni\data\ActiveDataProvider;



/**
 * VaksinaController implements the CRUD actions for Vaksina model.
 */
class VaksinaController extends Controller
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
     * Lists all Vaksina models.
     * @return mixed
     */
    public function actionIndex()
    {
        $current = Lang::getCurrent();
        $new = new Vaksina();
        $model = VaksinaTuri::find()->where(['status'=>VaksinaTuri::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        if (Uni::$app->request->get('drug')){
            $tuman_id = Uni::$app->request->get('drug');
            if (!empty($tuman_id)) {
                $data = new ActiveDataProvider([
                    'query' => Vaksina::find()->joinWith('turi')->where("vk_vaksinatsiya.status!=9 and vk_vaksina_turi.status=1 and vk_vaksinatsiya.vk_turi=$tuman_id")->orderBy(["id"=>SORT_DESC])->distinct()
                ]);
                if (empty($data)) $data = new ActiveDataProvider([
                    'query' => Vaksina::find()->joinWith('turi')->where("vk_vaksinatsiya.status!=9 and vk_vaksina_turi.status=1")->orderBy(["id"=>SORT_DESC])->distinct()
                ]);
            }
            else $data = new ActiveDataProvider([
                'query' => Vaksina::find()->joinWith('turi')->where("vk_vaksinatsiya.status!=9 and vk_vaksina_turi.status=1")->orderBy(["id"=>SORT_DESC])->distinct()
            ]);
        }
        else $data = new ActiveDataProvider([
            'query' => Vaksina::find()->joinWith('turi')->where("vk_vaksinatsiya.status!=9 and vk_vaksina_turi.status=1")->orderBy(["id"=>SORT_DESC])->distinct()
        ]);
        $data->pagination->pageSize=20;
        if (Uni::$app->request->get('q')){
            $key = Uni::$app->request->get('q');
            $all = new ActiveDataProvider([
                'query' => Vaksina::find()->joinWith('turi')->where("`vk_vaksina_turi`.`status`=1 and `vk_vaksinatsiya`.`status`!=9 and (`vk_vaksinatsiya`.`name_ru` like '%" . $key . "%' or `vk_vaksinatsiya`.`name_uz` like '%" . $key . "%')")
            ]);
        }
        else $all = false;
        $ves = Unit::find()->where(['status'=>Unit::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        if ($current->url=="ru") $map2 = ArrayHelper::map($ves,'id','name_ru');
        else $map2 = ArrayHelper::map($ves,'id','name_uz');

        return $this->render('index', ['items'=>$model, 'vaksina'=>$data, 'new'=>$new, 'query'=>$all, 'unit'=>$map2]);
    }

    /**
     * Displays a single Vaksina model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        $id = $_GET['id'];
        $view = $this->findModel($id);
        if (!empty($view)){
            if (isset($view->turi)) $turi =  $view->turi->name; else $turi = Uni::t('app',"Not set");
            \Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            return [
                'name_ru'=>$view->name_ru,
                'name_uz'=>$view->name_uz,
                'viloyat_id'=>$turi
            ];
        }
        else return "error";
    }

    public function actionViews($id)
    {
        $model = $this->findModel($id);
        if (!empty($model)){
            return $this->render('view', ['model'=>$model]);
        }
        else throw new ForbiddenHttpException('Sizda bu sahifa uchun ruxsat mavjud emas');
    }

    /**
     * Creates a new Vaksina model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Vaksina();

        if ($model->load(Uni::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_Vaksina]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionSave(){
        $model = new Vaksina();
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
//        return ['status' => print_r($_POST['data'])];
        parse_str($_POST['data'],$data);
        if ($model->load($data)) {
//            return ['status' => $model->{'vk_turi'}];
            $model->{'count'} = 0;
            $model->{'status'} = 1;

            if ($model->save()) {
                return ['status' => 'success'];
            } else {
                return ['status'=>'error'];
            }
        }
    }

    /**
     * Updates an existing Vaksina model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */


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

    /**
     * Deletes an existing Vaksina model.
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
     * Finds the Vaksina model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Vaksina the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vaksina::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
