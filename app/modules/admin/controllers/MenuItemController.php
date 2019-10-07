<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\dilshod\MenuItem;
use app\models\dilshod\Menu;
use app\models\dilshod\MenuItemTrans;
use app\models\dilshod\MenuItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * MenuItemController implements the CRUD actions for MenuItem model.
 */
class MenuItemController extends Controller
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
     * Lists all MenuItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MenuItem model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (isset($_GET['lang'])){
            $lang = MenuItemTrans::find()->where(['item_id'=>$id,'lang'=>$_GET['lang']])->one();
        }
        else $lang = MenuItemTrans::find()->where(['item_id'=>$id,'lang'=>'uz-UZ'])->one();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'lang'=>$lang
        ]);

        // return $this->render('/site/history', [
        //     'model' => $this->findModel($id),
        // ]);
    }

    /**
     * Creates a new MenuItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MenuItem();

        if ($model->load(Yii::$app->request->post())) {
            // if(isset($_POST['checkbox'])) {}
            function rasm($model,$qiymat){
                $file = UploadedFile::getInstance($model, $qiymat);
                if (isset($file))
                {
                    $filename = uniqid() . '.' . $file->extension;
                    $path = 'uploads/item';
                    if (!file_exists($path)) {
                        mkdir($path,0777,true);
                    }
                    $path = 'uploads/item/' . $filename;
                    if ($file->saveAs($path))
                        {
                            return $path;
                        }
                }
            }
            $model->photo = rasm($model, 'photo');
            $model->file = rasm($model, 'file');
            if($model->save()) return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MenuItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model2 = clone $model;
        if (isset($_GET['lang'])) {
            $til = MenuItemTrans::find()->where(['item_id'=>$id,'lang'=>$_GET['lang']])->one();
            if (!empty($til)) {
                $model->title = $til->title;
                $model->short = $til->short;
                $model->text = $til->text;
            }
            else {
                $model->title = "";
                $model->short = "";
                $model->text = "";
            }
        }
        $lang = new MenuItemTrans();
        if ($model->load(Yii::$app->request->post())) {
            function qayta($model,$rasm, $model2){
                $file = UploadedFile::getInstance($model, $rasm);
                if ($model2->photo==null || $file!=null) {
                    if (isset($file))
                    {
                        $filename = uniqid() . '.' . $file->extension;
                        $path = 'uploads/item/' . $filename;
                        $path2 = 'uploads/item/' . $model2->photo;
                        
                        if (is_file($path2)) {
                // print_r($path2); die;
                            @unlink($path2);
                        }
                        if ($file->saveAs($path))
                        {
                            return $path;
                        }
                    }
                    else {
                        if ($rasm=='photo') return $model2->photo;
                        else return $model2->file;
                    };
                }
                else {
                    if ($rasm=='photo') return $model2->photo;
                    else return $model2->file;
                };
            }

            $lang->load(Yii::$app->request->post());
            $form = MenuItemTrans::find()->where(['lang'=>$lang->lang, 'item_id'=>$model->id])->one();
            if (!empty($form)) {
                $form->title=$model->title;
                $form->short=$model->short;
                $form->text=$model->text;
                $form->save();
            }
            else {
                $lang->item_id = $model->id;
                $lang->title=$model->title;
                $lang->short=$model->short;
                $lang->text=$model->text;
                $lang->save();                
            }
            if ($lang->lang !="uz-UZ") {
                $model->title=$model2->title;
                $model->short=$model2->short;
                $model->text=$model2->text;
                # code...
            }
            $model->photo = qayta($model, 'photo', $model2);
            $model->file = qayta($model, 'file', $model2);

            $model->save();

            return $this->redirect(['view', 'id' => $model->id,'lang'=>$lang->lang]);
        }
        return $this->render('update', [
            'model' => $model,'lang'=>$lang,
        ]);
    }

    public function actionUpdatetext()
    {
        $model = Menu::find()->where(['id'=>$_GET['val']])->one();
        if (!empty($model)) {
            if ($model->template_id==1) {
                return "success";
            }
            else return "error";
        }
        else return "error";
    }

    public function actionUpdatelang()
    {
        return $this->redirect(['update', 'id' => $_GET['id'], 'lang'=>$_GET['val']]);
    }

    /**
     * Deletes an existing MenuItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status=MenuItem::STATUS_DELETE;
        $model->slug = uniqid();
        @unlink($model->photo); 
        $model->save();
        $menu = MenuItemTrans::find()->where(['item_id'=>$id])->all();
        if (!empty($menu)) {
            foreach ($menu as $key => $value) {
                $value->status = MenuItemTrans::STATUS_DELETE;
                $value->save(false);
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the MenuItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MenuItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MenuItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
