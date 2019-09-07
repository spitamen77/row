<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 13.10.2017
 * Time: 23:48
 */

namespace app\modules\page\controllers;


use app\components\Controller;
use app\models\Subject;
use app\models\SubjectCategory;
use app\models\Course;
use uni\web\NotFoundHttpException;

class SubjectController extends Controller {
    public $layout="/kasb";
    public $private=false;
    public $block=false;
    public function actionView($id){
        
        $subjects=Subject::find()->where(['status'=>1,'category_id'=>$id])->all();
        $subjectsCount=Subject::find()->where(['status'=>1,'category_id'=>$id])->count();
        $catname = SubjectCategory::findOne(['id'=>$id]);
        
        //if(!$subjects) throw new NotFoundHttpException();
        
        return $this->render('view',
        	[
        		'subjects'=>$subjects,
        		'subjectsCount'=>$subjectsCount,
        		'catname' => $catname
        	]);
    }
    public function actionKasb($id){
        
        $kasblar=Attach::find()->where(['status'=>1,'fan_id'=>$id])->all();
        //$kasblar=Attach::find()->where(['status'=>1,'fan_id'=>$id])->all();
        //var_dump($kasblar);exit;
        $subjectsCount=Subject::find()->where(['status'=>1,'category_id'=>$id])->count();
        $catname = SubjectCategory::findOne(['id'=>$id]);
        
        //if(!$subjects) throw new NotFoundHttpException();
        
        return $this->render('kasb',
        	[
        		'subjects'=>$subjects,
        		'subjectsCount'=>$subjectsCount,
        		'catname' => $catname
        	]);
    }
    public function actionCourse($id){
        
        $subject=Subject::findOne(['id'=>$id]);
        if(!$subject) throw new NotFoundHttpException();
        $courses = Course::find()->where(['status'=>1,'fan_id'=>$id])->all();
        //$kasblar=Attach::find()->where(['status'=>1,'fan_id'=>$id])->all();
        //var_dump($kasblar);exit;
        $courseCount=Course::find()->where(['status'=>1,'fan_id'=>$id])->count();
        //var_dump($courses);exit;
        return $this->render('course',
        	[
        		'subject'=>$subject,
        		'courseCount'=>$courseCount,
        		'courses' => $courses
        	]);
    }
}