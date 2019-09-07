<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 21.11.2018 15:51
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

namespace app\modules\api\controllers;

use app\models\Lang;
use app\models\Tuman;
//use app\models\search\TumanSearch;
use app\components\Controller;
use app\models\Viloyat;
use uni\ui\Form;
use uni\web\NotFoundHttpException;
use uni\web\ForbiddenHttpException;
use app\models\UserModel;
use Uni;

/**
 * TumanController implements the CRUD actions for Tuman model.
 */
class TumanController extends Controller
{
    public $cm="settings";
    public $layout="/core";
    public function beforeAction($action)
    {
        if(!$this->access('ADMIN')){
            throw new ForbiddenHttpException('Sizda bu sahifa uchun ruxsat mavjud emas');
        }
        return parent::beforeAction($action);
    }
    /**
     * Lists all Tuman models.
     * @return mixed
     */
    public function actionIndex()
    {
        $current = Lang::getCurrent();
        $model = Viloyat::find()->where(['status'=>Viloyat::STATUS_ACTIVE])->orWhere(['status'=>Viloyat::STATUS_INACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
//        $city = $model->tuman;
//        var_dump($city); die;
        return $this->render('index', ['items'=>$model]);
    }

    /**
     * Displays a single Tuman model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tuman model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tuman();

        if ($model->load(Uni::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_Tuman]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tuman model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Uni::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_Tuman]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tuman model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (!empty($model)){
            $model->status = 9;
            $model->user_id = Uni::$app->getUser()->getId();
            $model->updated_at = time();
            $model->save(false);
            Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            return Form::validate($model);
        }
        else return $this->redirect(['index']);
    }

    /**
     * Finds the Tuman model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tuman the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tuman::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
