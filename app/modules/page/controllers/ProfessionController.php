<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 13.10.2017
 * Time: 23:48
 */

namespace app\modules\page\controllers;


use app\components\Controller;
use app\models\Kasb;
use app\models\KasbChoose;
use Uni;
use uni\web\NotFoundHttpException;

class ProfessionController extends Controller {
    public $layout="/kasb";
    public $private=false;
    public $block=false;
    public function actionView($id){
        $kasb=Kasb::findOne($id);
        if(!$kasb) throw new NotFoundHttpException();
        return $this->render('view',['model'=>$kasb]);
    }
    public function actionKasbchoose($id){
        $user = Uni::$app->getUser()->getId();
        $kasb = KasbChoose::find()->where(['kasb_id'=>$id,'user_id'=>$user])->count();
        $model = Kasb::findOne($id);
        if(!$model) throw new NotFoundHttpException();
        //var_dump($kasb);exit;    
        
        if(!($kasb>0)){
            $choose = new KasbChoose();
            $choose->user_id = $user;
            $choose->kasb_id = $id;
            
            if($choose->save()){
                return $this->render('choose',['model' => $model, 'message' => 'newKasb']);    
            }
            var_dump($choose); exit; 
            //return $this->render('choose',['message'=> 'Kasbni tanlashda xatolik mavjud. Admin bilan boglaning']);
            throw new NotFoundHttpException();
        }
        return $this->render('choose',['model' => $model, 'message' => 'hasKasb']);    

    }
}