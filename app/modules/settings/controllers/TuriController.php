<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 21.11.2018 15:55
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

namespace app\modules\settings\controllers;

use app\models\DrugTuri;
//use app\models\search\DrugTuriSearch;
use app\components\Controller;
use uni\ui\Form;
use uni\web\ForbiddenHttpException;
use uni\web\NotFoundHttpException;
use app\models\UserModel;
use uni\data\ActiveDataProvider;
use Uni;

/**
 * DrugTuriCategory implements the CRUD actions for DrugTuri model.
 */
class TuriController extends Controller
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
     * Lists all DrugTuri models.
     * @return mixed
     */
    public function actionIndex()
    {
        $new = new DrugTuri();
        $data = new ActiveDataProvider([
            'query' => DrugTuri::find()->where(['status'=>DrugTuri::STATUS_ACTIVE])->orWhere(['status'=>DrugTuri::STATUS_INACTIVE])->orderBy(["id"=>SORT_DESC])
        ]);
        $data->pagination->pageSize=20;
        if (Uni::$app->request->get('q')){
            $key = Uni::$app->request->get('q');
            $all = new ActiveDataProvider([
                'query' => DrugTuri::find()->where("`uni_drug_turi`.`status`!=9 and (`uni_drug_turi`.`name_ru` like '%" . $key . "%' or `uni_drug_turi`.`name_uz` like '%" . $key . "%')")
            ]);
        }
        else $all = false;
        return $this->render('index', ['items'=>$data, "new"=>$new, 'query'=>$all]);
    }

    /**
     * Displays a single DrugTuri model.
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
            ];
        }
        else return "error";
    }

    public function actionSave(){
        $model = new DrugTuri();
        $model->name_uz = $_POST['uzb'];
        $model->name_ru = $_POST['rus'];
//        $model->user_id = Uni::$app->getUser()->getId();
//        $model->updated_at = time();
        if ($model->save()) {
            return 'success';
        }
        else return "error";
    }

    /**
     * Creates a new DrugTuri model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DrugTuri();

        if ($model->load(Uni::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_DrugTuri]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DrugTuri model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Uni::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_DrugTuri]);
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
     * Deletes an existing DrugTuri model.
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
     * Finds the DrugTuri model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DrugTuri the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DrugTuri::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
