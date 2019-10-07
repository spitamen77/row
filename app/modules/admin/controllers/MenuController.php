<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\dilshod\Menu;
use app\models\dilshod\MenuSearch;
use app\models\dilshod\MenuTrans;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
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
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch();
        $dataProvider = Menu::find()->where(['status'=>Menu::STATUS_ACTIVE])->orderBy(['child'=>SORT_ASC])->all();
// echo "<pre>";var_dump($dataProvider); die;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $menu = new MenuTrans();
            $menu->menu_id = $model->id;
            $menu->lang = 'uz-UZ';
            $menu->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $menu = MenuTrans::find()->where(['menu_id'=>$model->id, 'lang'=>'uz-UZ'])->one();
            if (!empty($menu)) {
                $menu->title = $model->title;
                $menu->save(false);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionCreatetext()
    {
        if ($_GET['val']=="") {
            return "value";
        }
        $uzb  = MenuTrans::find()->where(['menu_id'=>$_GET['til'], 'lang'=>$_GET['select']])->asArray()->one(); //sluig ni olyapman
        if (!empty($uzb)) {
            return 'dublicate';
        }
        else {
            $model = new MenuTrans();
            $model->menu_id = $_GET['til'];
            $model->lang = $_GET['select'];
            $model->title = $_GET['val'];
            $model->save();
            return 'success';
        }
    }

    public function actionGettext()
    {
        // $text = $this->findModel($_GET['til']);
        $text = MenuTrans::findOne($_GET['til']);
        if (!empty($text)){
            Yii::$app->response->format='json';
            return ['result' => 'success', 'matn' => $text->title];
        }
        else return ['result' => 'error'];
    }

    public function actionUpdatetext()
    {
        $text = MenuTrans::findOne($_GET['til']);
        if (!empty($text)){
            $text->title= $_GET['val'];
            $text->save();
            Yii::$app->response->format='json';
            return ['result' => 'success'];
        }
        else return ['result' => 'error'];
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $text = $this->findModel($id);
        $text->status = Menu::STATUS_DELETE;
        $text->slug = uniqid();
        $text->save();
        $menu = MenuTrans::find()->where(['menu_id'=>$id])->all();
        if (!empty($menu)) {
            foreach ($menu as $key => $value) {
                $value->status = MenuTrans::STATUS_DELETE;
                $value->save(false);
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
