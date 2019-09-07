<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 12.06.2017
 * Time: 14:03
 */

namespace app\modules\page\controllers;

use app\components\Controller;
use app\components\manager\Url;
use app\models\Course;
use app\models\Video;
use app\models\UserModel;
use Uni;
use uni\ui\Form;
use uni\web\NotFoundHttpException;
use uni\data\ActiveDataProvider;

class CourseController extends Controller
{
    public $layout = '/kasb';
    public $private = false;

    public function actionIndex(){
        $data = new ActiveDataProvider([
            'query' => Course::find()->where(['status' =>1,'user_id' =>Uni::$app->getUser()->getIdentity()->getId()])->orderBy(['id'=>SORT_DESC])  
        ]);
        return $this->render('index', [
            'data'=>$data
        ]);
    }
    public function actionView($id){
        
        $kurs = Course::findOne(['id' => $id]);
        
        if (!$kurs) throw new NotFoundHttpException;
        $videoCount = Video::find()->where(['course_id'=>$id])->count();
        $video = Video::find()->where(['course_id'=>$id])->all();
        
        //echo Course::isview($id,91);exit;


        return $this->render('view',['kurs'=>$kurs,'videoCount'=>$videoCount,'video'=>$video]); 
    }
}
