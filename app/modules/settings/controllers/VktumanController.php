<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 12.06.2017
 * Time: 14:03
 */

namespace app\modules\settings\controllers;

use app\components\manager\Url;
use app\models\Vaksina;
use app\models\VaksinaTuri;
use app\models\UserModel;
use Uni;
use app\components\Controller;
use app\models\VkViloyat; 
use app\models\VkTuman; 
use uni\web\NotFoundHttpException;
use uni\data\ActiveDataProvider;
use app\models\Prixod;
use app\models\Tuman;
use app\models\VaksinaPerform;
use app\models\Viloyat;
use app\models\Lang;
use uni\helpers\ArrayHelper;
use uni\db\Query;

class VktumanController extends Controller
{
    public $cm="vktuman";
    public function actionIndex(){
        echo "Vaksina tumanlar buyicha chiqarish";
    }
    public function actionAdd(){

    }
    public function actionEdit($id){
       Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
       $model = VkTuman::findOne(['id'=>$id]);
        if(!$model){
            throw new NotFoundHttpException;
        }
        $data = [];
        parse_str($_POST['data'],$data);
        //return $data;
        if ($model->load($data)) {
                if ($model->save()) {
                    
                    return ['status' => 'successEditLoad'];
                } else {
                    
                    return ['status' => 'unsuccessEditLoad'];
                }
        }
        else {
            return ['status' => 'failEditLoad'];
        }
       
    }

    public function actionSave()
    {
         Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
         $model = new VkTuman();
         parse_str($_POST['data'],$data);

        if ($model->load($data)) {
            $count = VkTuman::find()->where(['status'=>VkTuman::STATUS_ACTIVE, 'vaksina_id'=>$model->{'vaksina_id'}, 'viloyat_id'=>$model->{'viloyat_id'}])->sum('vaksina_miqdor');
            $jami =VkViloyat::find()->where(['vaksina_id'=>$model->{'vaksina_id'}, 'viloyat_id'=>$model->{'viloyat_id'}])->one();
            //return ['status' => $jami->vaksina_miqdor];
            if ($model->{'vaksina_miqdor'}==0) return ['status'=>Uni::t('app', '0 is not allowed')];
            if (empty($count)) $count=0;
            if ($jami->vaksina_miqdor >= ($count + $model->{'vaksina_miqdor'})){
//                $d1 = strtotime($model->{'proxod_date'}); // переводит из строки в дату
//                $model->{'proxod_date'} = $d1+25000;
                $model->{'status'} = 1;
                if ($model->save()) {
                    return ['status' => 'success'];
                } else {
                    return ['status'=>'error'];
                }
            }
            else return ['status'=>Uni::t('app', 'Not enough balance in inventory and inventory costs')];

        }
      return ['error'=>'ok','message'=>$model->errors];
    }
    public function actionTuman(){
        $userId = Uni::$app->getUser()->identity;
        
        if($this->access('ADMIN_TUM')){
            $id = $userId->tuman_id;
        }

        $userId = $userId->viloyat_id;
        $current = Lang::getCurrent();
       

        $r = Uni::$app->db->createCommand("SELECT uchastka_id as id, username as username, sum(a.vaksina_miqdor) as miqdor FROM uni_user_security as b right join vk_vaksina_perform as a on b.id=a.uchastka_id where b.tuman_id = ".$id." GROUP BY a.uchastka_id");
            
        $sum = $r->queryAll();
        // var_dump($sum);exit;
        return $this->render('tuman',['data' => $sum,'userId'=>$userId]);
    }
    public function actionUchastka($id){
        $userId = Uni::$app->getUser()->identity->viloyat_id;
        $current = Lang::getCurrent();
       
        //echo "<pre>";
        $r = Uni::$app->db->createCommand("SELECT vaksina_id as id, (select name_uz from vk_vaksinatsiya where id = b.vaksina_id) as vaksina, sum(b.vaksina_miqdor) as miqdor FROM vk_vaksina_perform as b where b.uchastka_id = ".$id." GROUP BY b.vaksina_id");
            
        $sum = $r->queryAll();
        //$sum = VaksinaPerform::find()->select('vaksina_id, sum(vaksina_miqdor)')->where(['uchastka_id'=>$id])->groupBy('vaksina_id');
        //var_dump($sum);exit;
        return $this->render('uchastka',['data' => $sum,'userId'=>$userId]);
    }
    public function actionVaksinatsiya($id){
        $userId = Uni::$app->getUser()->identity->viloyat_id;
        $current = Lang::getCurrent();
       
        $sum = VaksinaPerform::find()->where(['vaksina_id'=>$id])->all();
        //var_dump($sum);exit;
        return $this->render('vaksinatsiya',['data' => $sum,'userId'=>$userId]);
    }
    public function actionItem($id){
        $userId = Uni::$app->getUser()->identity->viloyat_id;
        $current = Lang::getCurrent();
       
        $model = VaksinaPerform::findOne($id);
        //var_dump($sum);exit;
        return $this->render('vaksinatsiya',['data' => $model,'userId'=>$userId]);
    }
    public function actionPrixod(){
        $userId = Uni::$app->getUser()->identity->personal->tuman_id;
        $current = Lang::getCurrent();
        
        $data = new ActiveDataProvider([
           'query' => VkTuman::find()->where(['tuman_id'=>$userId,'status'=>0])->orderBy(["prixod_date"=>SORT_DESC])
        ]);
        $data->pagination->pageSize=15;
        return $this->render("prixod", [
            'dataProvider' => $data,
            'userId' => $userId
        ]);

    }
    public function actionAccepted(){
        $userId = Uni::$app->getUser()->identity->personal->tuman_id;
        $current = Lang::getCurrent();
        
        $data = new ActiveDataProvider([
           'query' => VkTuman::find()->where(['status'=>VkTuman::STATUS_ACTIVE,'tuman_id'=>$userId])->orderBy(["prixod_date"=>SORT_DESC])
        ]);
        $data->pagination->pageSize=15;
        return $this->render("accepted", [
            'dataProvider' => $data,
            'userId' => $userId
        ]);

    }
    public function actionDenied(){
        $userId = Uni::$app->getUser()->identity->personal->tuman_id;
        $current = Lang::getCurrent();
        
        $data = new ActiveDataProvider([
           'query' => VkTuman::find()->where(['status'=>VkTuman::STATUS_DENIED,'tuman_id'=>$userId])->orderBy(["prixod_date"=>SORT_DESC])
        ]);
        $data->pagination->pageSize=15;
        return $this->render("denied", [
            'dataProvider' => $data,
            'userId' => $userId
        ]);

    }

    public function actionAccept($id){
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $model = VkTuman::findOne($id);
        if (!empty($model)){
            if($model->status == 0){
                $model->status = 1;
            }
            
            if($model->save()){
                return ['status' => 'success'];
            }
            return ['status' => 'statusNotSaved'];
        }
        else return ['status' => 'statusModelEmpty'];
    }
    public function actionDeny($id){
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        //var_dump($id);exit;
        $model = VkTuman::findOne($id);
        //return $model;
        if (!empty($model)){
            if($model->status == 0){
                $model->status = 2;
            }
            
            if($model->save(false)){
                return ['status' => 'success'];
            }
            return ['status' => 'statusUnchanged'];
        }
        else return ['status' => 'statusUnchanged'];
    }
}