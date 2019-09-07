<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 01.12.2018 15:48
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

namespace app\modules\settings\controllers;

use app\models\Hayvon;
use app\models\HayvonRangi;
use app\models\Lang;
use app\components\Controller;
use app\models\HayvonTuri;
use uni\web\NotFoundHttpException;
use uni\web\ForbiddenHttpException;
use Uni;
use uni\data\ActiveDataProvider;



/**
 * HayvonController implements the CRUD actions for Hayvon model.
 */
class HayvonController extends Controller
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
     * Lists all Hayvon models.
     * @return mixed
     */
    public function actionIndex()
    {
        $current = Lang::getCurrent();
        $new = new Hayvon();
        $model = HayvonTuri::find()->where(['status'=>HayvonTuri::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        $color = HayvonRangi::find()->where(['status'=>HayvonRangi::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        if (Uni::$app->request->get('drug')){
            $tuman_id = Uni::$app->request->get('drug');
            if (!empty($tuman_id)) {
                $data = new ActiveDataProvider([
                    'query' => Hayvon::find()->joinWith('turi')->where("vk_hayvon.status!=9 and vk_hayvon_turi.status=1 and vk_hayvon.hayvon_turi_id=$tuman_id")->orderBy(["id"=>SORT_DESC])->distinct()
                ]);
                if (empty($data)) $data = new ActiveDataProvider([
                    'query' => Hayvon::find()->joinWith('turi')->where("vk_hayvon.status!=9 and vk_hayvon_turi.status=1")->orderBy(["id"=>SORT_DESC])->distinct()
                ]);
            }
            else $data = new ActiveDataProvider([
                'query' => Hayvon::find()->joinWith('turi')->where("vk_hayvon.status!=9 and vk_hayvon_turi.status=1")->orderBy(["id"=>SORT_DESC])->distinct()
            ]);
        }
        else $data = new ActiveDataProvider([
            'query' => Hayvon::find()->joinWith('turi')->where("vk_hayvon.status!=9 and vk_hayvon_turi.status=1")->orderBy(["id"=>SORT_DESC])->distinct()
        ]);
        if (Uni::$app->request->get('q')){
            $key = Uni::$app->request->get('q');
            $all = new ActiveDataProvider([
                'query' => Hayvon::find()->joinWith('turi')->where("`vk_hayvon_turi`.`status`=1 and `vk_hayvon`.`status`!=9 and (`vk_hayvon`.`name_ru` like '%" . $key . "%' or `vk_hayvon`.`name_uz` like '%" . $key . "%')")
            ]);
        }
        else $all = false;
        $data->pagination->pageSize=20;
        return $this->render('index', ['items'=>$model, 'hayvon'=>$data, 'new'=>$new, 'query'=>$all, 'color'=>$color]);
    }

    /**
     * Displays a single Hayvon model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        $id = $_GET['id'];
        $view = $this->findModel($id);
        if (!empty($view)){
            if (isset($view->turi)) $turi =  $view->turi->name; else $turi = Uni::t('app',"Not set");
            if (isset($view->color)) $rang =  $view->color->name; else $rang = Uni::t('app',"Not set");
            \Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            return [
                'name_ru'=>$view->name_ru,
                'name_uz'=>$view->name_uz,
                'hayvon_turi_id'=>$turi,
                'color'=>$rang
            ];
        }
        else return "error";
    }



    public function actionSave(){
//        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $model = new Hayvon();

        $model->name_uz = $_POST['uzb'];
        $model->name_ru = $_POST['rus'];
        $model->hayvon_turi_id = $_POST['vaksina'];
        $model->rang_id = $_POST['color'];
//        $model->user_id = Uni::$app->getUser()->getId();
        $model->status = 1;
        if ($model->save()) {
            return 'success';
        }
        else return "error";
    }

    /**
     * Updates an existing Hayvon model.
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
     * Deletes an existing Hayvon model.
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
     * Finds the Hayvon model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Hayvon the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Hayvon::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
