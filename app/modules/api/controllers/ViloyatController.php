<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 21.11.2018 15:36
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

namespace app\modules\api\controllers;

use app\models\Viloyat;
//use app\models\search\ViloyatSearch;
use app\components\Controller;
use uni\ui\Form;
use uni\web\NotFoundHttpException;
use uni\web\ForbiddenHttpException;
use app\models\UserModel;
use Uni;
use app\models\Lang;

/**
 * ViloyatController implements the CRUD actions for Viloyat model.
 */
class ViloyatController extends Controller
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
     * Lists all Viloyat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $current = Lang::getCurrent();
        $model = Viloyat::find()->where(['status'=>Viloyat::STATUS_ACTIVE])->orWhere(['status'=>Viloyat::STATUS_INACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        return $this->render('index', ['items'=>$model]);
    }

    /**
     * Displays a single Viloyat model.
     * @param integer $id
     * @return mixed
     */
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

    /**
     * Creates a new Viloyat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Viloyat();
        $model->name_ru = $_GET['input2'];
        $model->name_uz = $_GET['input'];
        $model->user_id = Uni::$app->getUser()->getId();
        $model->created_at = time();
        if ($model->save()){
            return 'success';
        }
        else return "error";
    }

    /**
     * Updates an existing Viloyat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
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

    public function actionEdit()
    {
        $id = $_GET['id'];
        $text1 = $_GET['text1'];
        $text2 = $_GET['text2'];
        $view = $this->findModel($id);
        if (!empty($view)){
            $view->name_uz = $text2;
            $view->name_ru = $text1;
            $view->user_id = Uni::$app->getUser()->getId();
            $view->updated_at = time();
            $view->save(false);
//            \Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            return 'success';
        }
        else return "error";
    }

    public function actionChange()
    {
        $id = $_GET['id'];
        $status = $_GET['status'];
        $view = $this->findModel($id);
        if (!empty($view)){
            $view->status = $status;
            $view->user_id = Uni::$app->getUser()->getId();
            $view->updated_at = time();
            $view->save(false);
//            \Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            return 'success';
        }
        else return "error";
    }

    /**
     * Deletes an existing Viloyat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        $id = $_GET['id'];
        $model = $this->findModel($id);
        if (!empty($model)){
            $model->status = 9;
            $model->user_id = Uni::$app->getUser()->getId();
            $model->updated_at = time();
            $model->save(false);
//            Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            return 'success';
        }
        else return "error";
    }

    /**
     * Finds the Viloyat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Viloyat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Viloyat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
