<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 10.12.2018 14:29
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

namespace app\modules\settings\controllers;

use app\models\Lang;
use app\models\Unit;
use app\models\Unitmeasure;
use app\components\Controller;
use uni\web\ForbiddenHttpException;
use uni\web\NotFoundHttpException;
use uni\data\ActiveDataProvider;
use Uni;

/**
 * UnitmeaController implements the CRUD actions for Unitmeasure model.
 */
class UnitmeaController extends Controller
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
     * Lists all Unitmeasure models.
     * @return mixed
     */
    public function actionIndex()
    {
        $current = Lang::getCurrent();
        $new = new UnitMeasure();
        $model = Unit::find()->where(['status'=>Unit::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        if (Uni::$app->request->get('drug')){
            $tuman_id = Uni::$app->request->get('drug');
            if (!empty($tuman_id)) {
                $data = new ActiveDataProvider([
                    'query' => UnitMeasure::find()->joinWith('unit')->where("vk_unit_measure.status!=9 and vk_unit.status=1 and vk_unit_measure.unit_id=$tuman_id")->orderBy(["id"=>SORT_DESC])->distinct()
                ]);
                if (empty($data)) $data = new ActiveDataProvider([
                    'query' => UnitMeasure::find()->joinWith('unit')->where("vk_unit_measure.status!=9 and vk_unit.status=1")->orderBy(["id"=>SORT_DESC])->distinct()
                ]);
            }
            else $data = new ActiveDataProvider([
                'query' => UnitMeasure::find()->joinWith('unit')->where("vk_unit_measure.status!=9 and vk_unit.status=1")->orderBy(["id"=>SORT_DESC])->distinct()
            ]);
        }
        else $data = new ActiveDataProvider([
            'query' => UnitMeasure::find()->joinWith('unit')->where("vk_unit_measure.status!=9 and vk_unit.status=1")->orderBy(["id"=>SORT_DESC])->distinct()
        ]);
        if (Uni::$app->request->get('q')){
            $key = Uni::$app->request->get('q');
            $all = new ActiveDataProvider([
                'query' => UnitMeasure::find()->joinWith('unit')->where("`vk_unit`.`status`=1 and `vk_unit_measure`.`status`!=9 and (`vk_unit_measure`.`name_ru` like '%" . $key . "%' or `vk_unit_measure`.`name_uz` like '%" . $key . "%')")
            ]);
        }
        else $all = false;
        $data->pagination->pageSize=20;
        return $this->render('index', ['items'=>$model, 'hayvon'=>$data, 'new'=>$new, 'query'=>$all]);
    }

    /**
     * Displays a single Unitmeasure model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        $id = $_GET['id'];
        $view = $this->findModel($id);
        if (!empty($view)){
            if (isset($view->unit)) $turi =  $view->unit->name; else $turi = Uni::t('app',"Not set");
//            else $viloyat =  $view->viloyat->name_uz;
            \Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            return [
                'name_ru'=>$view->name_ru,
                'name_uz'=>$view->name_uz,
                'unit_id'=>$turi,
            ];
        }
        else return "error";
    }

    public function actionSave(){
        $model = new Unitmeasure();
        $model->name_uz = $_POST['uzb'];
        $model->name_ru = $_POST['rus'];
        $model->unit_id = $_POST['vaksina'];
//        $model->user_id = Uni::$app->getUser()->getId();
        $model->status = 1;
        if ($model->save()) {
            return 'success';
        }
        else return "error";
    }

    /**
     * Creates a new Unitmeasure model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Unitmeasure();

        if ($model->load(Uni::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_Unitmeasure]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Unitmeasure model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Uni::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_Unitmeasure]);
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
     * Deletes an existing Unitmeasure model.
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
     * Finds the Unitmeasure model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Unitmeasure the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Unitmeasure::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
