<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\dilshod\Photo;
use app\models\dilshod\Rasm;
use app\models\dilshod\PhotoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * PhotoController implements the CRUD actions for Photo model.
 */
class PhotoController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public $enableCsrfValidation = false;

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

    public function beforeAction($action)
{            
    
        $this->enableCsrfValidation = false;
    
    return parent::beforeAction($action);
}

    /**
     * Lists all Photo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PhotoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Photo model.
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
     * Creates a new Photo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Photo();

        if ($model->load(Yii::$app->request->post())) {
            $slug = Photo::find()->where(['slug'=>$model->slug])->one();
            if (!empty($slug)) {
                return $this->render('create', [
                    'model' => $model,
                    'error' => "Bunday slug mavjud"
                ]);
            }
            if ($model->save()) return $this->redirect(['rasm', 'id' => $model->id]);
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

    public function actionRasm($id)
    {
        $model = $this->findModel($id);
        if (!empty($model)) {
            $image = Rasm::find()->where(['photo_id'=>$id])->all();
            if (!empty($image)) $image = $image;
            else $image=false;
            $rasm = new Rasm();
            return $this->render('photo', [
                'model' => $rasm,
                'kod'=>$id,
                'image'=>$image
            ]);   
            # code...
        }
    }

    public function actionSave($id)
    {

        $model = new Rasm();
        // $model = $this->findModel($id);
        if (isset($_FILES["file"])) {
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);
            $path = 'uploads/gallery/';
            if (!file_exists($path)) {
                mkdir($path,0777,true);
            }
            $filename = uniqid() . '.' . $extension;
            move_uploaded_file($_FILES["file"]["tmp_name"],$path.$filename);
            $model->src = $path.$filename;
            $model->photo_id = $id;
            $model->save();    
            Yii::$app->response->format='json';
            return ['result' => 'success', 'id' => $model->id];
            
        }
    }

        // if ($upload->load(Yii::$app->request->post())) {

        //     function rasm($model,$qiymat){
        //         $file = UploadedFile::getInstance($upload, $qiymat);
        //         if (isset($file))
        //         {
        //             $filename = uniqid() . '.' . $file->extension;
        //             $path = 'uploads/' . $filename;
        //             if ($file->saveAs($path))
        //                 {
        //                     return $filename;
        //                 }
        //         }
        //     }
        //     $upload->src = rasm($model, 'src');
        //     $model->save();
        //     return "salom";
            // $upload->src = UploadedFile::getInstances($upload,'src');
            // $filename = uniqid() . '.' . $file->extension;
            // $path = 'uploads/' .rand(100,999). $filename;
            // // $path = Url::to("@webfront/images/");
            // // var_dump($upload);exit();
            // foreach ($upload as $value) {
            //     $rasm = new Rasm();
            //     $rasm->photo_id = $id;
            //     $rasm->src = time().rand(100,999).".".$value->extension;
            //     if ($rasm->save(false)) {
            //         $value->saveAs($path,$value->image);
            //     }
            // }
            // // var_dump($_POST); 
            // var_dump($_FILES);exit('ssaassa');
        // }
        // var_dump($_POST);exit('asfdasd');
    


    public function actionDelimage()
    {
        $model = Rasm::find()->where(['id'=>$_GET['val']])->one();
        if (!empty($model)) {
            if (is_file($model->src)) {
                // print_r($path2); die;
                @unlink($model->src);
            }
            $model->delete();
            return "success";
        }
    }

    /**
     * Updates an existing Photo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Photo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model2 = $this->findModel($id);
        $model = Rasm::find()->where(['photo_id'=>$id])->all();
        if (!empty($model)) {
            foreach ($model as $item) {
                if (is_file($item->src)) {
                    // print_r($path2); die;
                    @unlink($item->src);
                }
                $item->delete();
                # code...
            }
            // return "success";
        }
        // $model->status = Photo::STATUS_DELETE;
        $model2->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Photo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Photo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Photo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
