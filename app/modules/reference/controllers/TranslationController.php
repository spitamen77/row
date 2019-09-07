<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 17.06.2017
 * Time: 13:10
 */

namespace app\modules\reference\controllers;

use app\models\SourceMessage;
use Uni;
use app\components\Controller;
use app\models\Message;
use uni\ui\Form;
use uni\web\NotFoundHttpException;

class TranslationController extends Controller
{
    public function actionAddtranslation(){
        if(Uni::$app->request->isPost){
            $temp=Message::find()->where(['language'=>$_POST['language'],'id'=>$_POST['id']])->one();
            if($temp) $model=$temp;
            else $model=new Message();
            $model->translation=$_POST['translation'];
            $model->language=$_POST['language'];
            if(!$temp) $model->id=$_POST['id'];
            if($model->save()){
                echo "ok";
            }else{
                var_dump($model);
            }
        }
    }
    public function actionSave(){
        $model = new SourceMessage();

        if (Uni::$app->request->isPost) {
            $model->category=$_POST['category'];
            $model->message=$_POST['message'];
                if($model->save()){
                    $this->flash('success', \Uni::t('app', 'Message source is created'));
                    return $this->redirect('/reference/default/translation');
                }
                else{
                    $this->flash('error', \Uni::t('app', 'Create error. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
        }else{
            throw new NotFoundHttpException;
        }
    }
    public function actionDelete($id){
        $src=SourceMessage::findOne(['id'=>$id]);
        if($src){
            if($src->delete()){
                return $this->back();
            }
        }
    }

}