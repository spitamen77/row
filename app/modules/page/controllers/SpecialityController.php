<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 12.06.2017
 * Time: 14:03
 */

namespace app\modules\page\controllers;

use app\components\manager\Url;
use Uni;
use app\components\Controller;
use app\models\Speciality;
use app\models\Kasb;
use uni\ui\Form;
use uni\web\NotFoundHttpException;
use uni\data\ActiveDataProvider;

class SpecialityController extends Controller
{
    public $block="users";
    public $layout = '/kasb';
    public $private=false;

    public $cm="speciality";
    public function actionIndex(){
        echo "Speciality";
    }
    public function actionList($id){
        $spec=Speciality::findOne($id);
        if(!$spec)throw new NotFoundHttpException();
        $kasblar = new ActiveDataProvider([
            'query' => Kasb::find()->where(['soha_id'=>$id])
        ]);

        return $this->render('list',['kasblar' => $kasblar, 'soha'=>$spec]);
    }
    public function actionView($id){
        $speciality=Speciality::findOne(['id'=>$id]);
        return $this->render('view',['model' => $speciality]);
        
    }
    

}