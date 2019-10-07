<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\dilshod\User;
use app\models\dilshod\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $seen = User::find()->where(['admin_seen'=>User::ADMIN_NO_SEEN,'id'=>$id])->all();
        foreach ($seen as $key => $value) {
            $value->admin_seen = User::ADMIN_SEEN;
            $value->save(false);
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $seen = User::find()->where(['admin_seen'=>User::ADMIN_NO_SEEN,'id'=>$id])->all();
        foreach ($seen as $key => $value) {
            $value->admin_seen = User::ADMIN_SEEN;
            $value->save(false);
        }
        $model = $this->findModel($id);

        $model2 = clone $model;

        if ($model->load(Yii::$app->request->post()))  {
            $image=UploadedFile::getInstance($model,'image');
            if ($image==null) {
                $model->image = $model2->image;
            }

            else {
                $name = 'uploads/' . uniqid() . "." . $image->extension;
                $image->saveAs($name);
                $model->image = $name;
                @unlink($model2->image);
            }
                if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
            // echo '<pre>'; var_dump($model->getErrors()); die;
            // if ($model->load(Yii::$app->request->post()) )  {
            // echo '<pre>'; var_dump($model); exit;
            // }
            // else{
            //  var_dump($model->getErrors());die;
            // }
        
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionUser(){

        return $this->render('user');
    }
    
    public function actionUzgariw(){ 
            $model = User::findOne(Yii::$app->user->identity->id);
            $model2 = clone $model;

        if ($model->load(Yii::$app->request->post()))  {

            $post = Yii::$app->request->post();
            $model->username = $post['User']['username'];
            $model->fio = $post['User']['fio'];
            $model->email = $post['User']['email'];
            $model->tel = $post['User']['tel'];
            $image=UploadedFile::getInstance($model,'image');
            if ($image==null) {
                $model->image = $model2->image;
            }

            else {
                $name = 'uploads/' . mt_rand() . "." . $image->extension;
                $image->saveAs($name);
                $model->image = $name;
                @unlink($model2->image);
            }
                $model->save();
                return $this->redirect(['user']);
            // echo '<pre>'; var_dump($model->getErrors()); die;
            // if ($model->load(Yii::$app->request->post()) )  {
            // echo '<pre>'; var_dump($model); exit;
            // }
            // else{
            //  var_dump($model->getErrors());die;
            // }
        
        }
        else{

        return $this->render('uzgariw',['model'=>$model]);
        }

    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
