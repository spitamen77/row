<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\dilshod\TextTranslate;
use app\models\Lang;
use app\models\dilshod\TextTranslateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TextTranslateController implements the CRUD actions for TextTranslate model.
 */
class TextTranslateController extends Controller
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
     * Lists all TextTranslate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TextTranslateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TextTranslate model.
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
     * Creates a new TextTranslate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TextTranslate();

        if ($model->load(Yii::$app->request->post())) {
            $model->lang = 'uz-UZ';
            $slug = TextTranslate::find()->where(['slug'=>$model->slug])->one();
            if (!empty($slug)) {
                return $this->render('create', [
                    'model' => $model,
                    'error' => "Bunday slug mavjud"
                ]);
            }
           // exit("dadasda");
            if ($model->save()) return $this->redirect(['index']);
            else { 
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TextTranslate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        else 
        { 
            return $this->render('update', [
                'model' => $model,
            ]);
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
        $uzb  = TextTranslate::find()->where(['slug'=>$_GET['til'], 'lang'=>$_GET['select']])->asArray()->one(); //sluig ni olyapman
        if (!empty($uzb)) {
            return 'dublicate';
        }
        else {
            //var_dump($_GET['til']);exit;
            $model = new TextTranslate();
            $model->slug = $_GET['til'];
            $model->lang = $_GET['select'];
            $model->text = $_GET['val'];
            $model->save();
            return 'success';
        }
    }

    /**
     * Deletes an existing TextTranslate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
         $text = $this->findModel($id);
         $slug = TextTranslate::find()->where(['slug'=>$text->slug])->all();
         foreach ($slug as $key => $value) {
             $value->delete();
         }
        // $text->status = TextTranslate::STATUS_DELETE;
        // $text->save();
        return $this->redirect(['index']);
    }

    public function actionUpdatetext()
    {
        $text = $this->findModel($_GET['til']);
        if (!empty($text)){
            $text->text= $_GET['val'];
            $text->save(false);
            Yii::$app->response->format='json';
            return ['result' => 'success'];
        }
        else return ['result' => 'error'];
    }

    public function actionGettext()
    {
        $text = $this->findModel($_GET['til']);
        if (!empty($text)){
            Yii::$app->response->format='json';
            return ['result' => 'success', 'matn' => $text->text];
        }
        else return ['result' => 'error'];
    }


    /**
     * Finds the TextTranslate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TextTranslate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TextTranslate::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
