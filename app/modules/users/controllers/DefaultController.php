<?php

namespace app\modules\users\controllers;


use app\components\Controller;
use app\models\Lang;
use app\models\Prixod;
use app\models\Tuman;
use app\models\Uchastka;
use app\models\UserModel;
use app\models\Vaksina;
use app\models\Viloyat;
use app\models\VkTuman;
use app\models\VkUchastka;
use app\models\VkViloyat;
use Uni;
use app\components\manager\Url;
//use app\models\Task;
use uni\data\ActiveDataProvider;
use uni\helpers\ArrayHelper;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        if($this->access('ADMIN_TUM')){
            return $this->render('tum');
        }
        if($this->access('ADMIN_VIL')){
            return $this->render('vil');
        }
        if($this->access('ADMIN')||$this->access('HEAD')){
            return $this->render('main');
        }
        return $this->render('main');
        $current = Lang::getCurrent();

        if($this->access('ADMIN')||$this->access('HEAD')){
            
            $data = new ActiveDataProvider([
                'query' => Prixod::find()->select('vaksina_id,count(count) as summa')->groupBy('vaksina_id')->createCommand()
            ]);
            $data = Prixod::find()->select('id, vaksina_id,sum(count) as cnt, sum(ostatok) as ostatok')->groupBy('vaksina_id')->createCommand()->queryAll();
            
            return $this->render('dashboard',['data'=>$data]);
        }
        if($this->access('ADMIN_VIL')){
            $userId = Uni::$app->getUser()->identity->viloyat_id;
            
            $m = new VkTuman;

            $res = new ActiveDataProvider([
                'query' => Tuman::find()->joinWith('vkt')->where("`vk_tuman`.`status`=1 and `vk_tuman`.`viloyat_id`=$userId and `uni_tuman`.`status`=1")->orderBy(["name_$current->url"=>SORT_ASC])->distinct()
            ]);
            $res->pagination->pageSize=20;

            if (Uni::$app->request->get('q')){
                $key = Uni::$app->request->get('q');
                $all = new ActiveDataProvider([
                    'query' => Tuman::find()->joinWith('vkt')->where("`vk_tuman`.`status`=1 and `vk_tuman`.`viloyat_id`=$userId and `uni_tuman`.`status`=1 and (`uni_tuman`.`name_ru` like '%" . $key . "%' or `uni_tuman`.`name_uz` like '%" . $key . "%')")
                ]);
            }
            else $all = false;

            $kutish = new ActiveDataProvider([
                'query' => Tuman::find()->joinWith('vkt')->where("`vk_tuman`.`status`=0 and `vk_tuman`.`viloyat_id`=$userId and `uni_tuman`.`status`=1")->orderBy(["name_$current->url"=>SORT_ASC])->distinct()
            ]);
            $kutish->pagination->pageSize=20;

            $tuman = Tuman::find()->where(['status'=>Tuman::STATUS_ACTIVE, 'viloyat_id'=>$userId])->orderBy(["name_$current->url"=>SORT_ASC])->all();
            if ($current->url=="ru") $map = ArrayHelper::map($tuman,'id','name_ru');
            else $map = ArrayHelper::map($tuman,'id','name_uz');

            $vil_vaksina = Vkviloyat::find()->where(['viloyat_id'=>$userId, 'status'=>Vkviloyat::STATUS_ACTIVE])->all();
    //        var_dump($vil_vaksina); die;
            $vaksina = [];
            foreach ($vil_vaksina as $item){
                $vaksina[] = Vaksina::find()->where(['status'=>Vaksina::STATUS_ACTIVE, 'id'=>$item->vaksina_id])->orderBy(["name_$current->url"=>SORT_ASC])->one();
            }
    //        var_dump($vaksina); die;
            if ($current->url=="ru") $map2 = ArrayHelper::map($vaksina,'id','name_ru');
            else $map2 = ArrayHelper::map($vaksina,'id','name_uz');

            return $this->render('viloyat',['data' => $res,'userId'=>$userId, 'm'=>$m, 'tuman'=>$map, 'vaksina'=>$map2, 'kutish'=>$kutish, 'query'=>$all]);
            //return $this->redirect(Url::to('users/default/viloyat'));
        }
        if($this->access('ADMIN_TUM')){
            
            $userId = Uni::$app->getUser()->identity->tuman_id;
            $user_tuman = Uni::$app->getUser()->identity->viloyat_id;
            
            $info = [];
            // $info['prixod'] = VkTuman::find()->where(['tuman_id'=>$userId])->count();
            // $info['accepted'] = VkTuman::find()->where(['tuman_id'=>$userId,'status'=>1])->count();
            // $info['denied'] = VkTuman::find()->where(['tuman_id'=>$userId,'status'=>2])->count();
            // $info['closed'] = VkTuman::find()->where(['tuman_id'=>$userId,'status'=>3])->count();

            $pr = [];
            foreach (VkUchastka::find()->where(['tuman_id'=>$userId])->all() as $v) {
               array_push($pr, $v->created_at);
            }
            $vk = [];

            
            foreach (VkUchastka::find()->groupBy('vaksina_id')->all() as $key => $value) {
                $vk[$value->vaksina_id]['count'] = VkUchastka::find()->where(['vaksina_id'=>$value->vaksina_id])->count();
                $vk[$value->vaksina_id]['name'] = $value->vaksina->name_uz;
                // echo $value->vaksina->name_uz."<br>";
            }
            // echo "<pre>";
            // var_dump($vk);
            // exit;
            return $this->render('main',['info' => $info, 'userId'=>$userId, 'pr'=>$pr, 'vk'=>$vk]);
        }
        if(Uni::$app->controller->access('VET')){
            echo "Sizga bu tizimga kirishga ruxsat yo'q";                
        }
        return $this->goHome();
    }

    public function actionDashboard()
    {

        $current = Lang::getCurrent();
        $m = new VkViloyat;

        $vil = [];
        $viloyat = Viloyat::find()->where(['status'=>Viloyat::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        foreach ($viloyat as $v) {
            $vil[$v->id] = $v->name;
        }
//         if ($current->url=="ru") $map = ArrayHelper::map($viloyat,'id','name_ru');
//         else $map = ArrayHelper::map($viloyat,'id','name_uz');

        $ombor = Prixod::find()->where(['status'=>Prixod::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        $vaksina = [];
        foreach ($ombor as $item){
            $vaksina[] = Vaksina::find()->where(['status'=>Vaksina::STATUS_ACTIVE, 'id'=>$item->vaksina_id])->orderBy(["name_$current->url"=>SORT_ASC])->one();
        }

        if ($current->url=="ru") $map2 = ArrayHelper::map($vaksina,'id','name_ru');
        else $map2 = ArrayHelper::map($vaksina,'id','name_uz');

//         $prixod = Prixod::find()->where(['status'=>Prixod::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
//         if ($current->url=="ru") $map3 = ArrayHelper::map($prixod,'id','name_ru');
//         else $map3 = ArrayHelper::map($prixod,'id','name_uz');

        $data = $m->search(\Uni::$app->request->queryParams);


        return $this->render('dashboard_old',['data' => $data, 'm'=>$m, 'viloyat'=>$vil,'vaksina'=>$map2]);
    }

    public function actionViloyat()
    {
        $userId = Uni::$app->getUser()->identity->personal->viloyat_id;
        $current = Lang::getCurrent();
        $items = VkTuman::find()->where(['viloyat_id'=>$userId, 'status'=>1])->all();

        $m = new VkTuman;

        $res = $m->search(\Uni::$app->request->queryParams);

        $kutish = new ActiveDataProvider([
            'query' => VkTuman::find()->joinWith('tuman')->where("`vk_tuman`.`status`=0 and `vk_tuman`.`viloyat_id`=$userId and `uni_tuman`.`status`=1")->orderBy(["name_$current->url"=>SORT_ASC])->distinct()
        ]);
        $kutish->pagination->pageSize=20;

        $tuman = Tuman::find()->where(['status'=>Tuman::STATUS_ACTIVE, 'viloyat_id'=>$userId])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        if ($current->url=="ru") $map = ArrayHelper::map($tuman,'id','name_ru');
        else $map = ArrayHelper::map($tuman,'id','name_uz');

        $vil_vaksina = Vkviloyat::find()->where(['viloyat_id'=>$userId, 'status'=>Vkviloyat::STATUS_ACTIVE])->all();
//        var_dump($vil_vaksina); die;
        $vaksina = [];
        foreach ($vil_vaksina as $item){
            $vaksina[] = Vaksina::find()->where(['status'=>Vaksina::STATUS_ACTIVE, 'id'=>$item->vaksina_id])->orderBy(["name_$current->url"=>SORT_ASC])->one();
        }
//        var_dump($vaksina); die;
        if ($current->url=="ru") $map2 = ArrayHelper::map($vaksina,'id','name_ru');
        else $map2 = ArrayHelper::map($vaksina,'id','name_uz');

        return $this->render('viloyat',['data' => $res,'userId'=>$userId, 'm'=>$m, 'tuman'=>$map, 'vaksina'=>$map2, 'kutish'=>$kutish, 'items'=>$items]);
    }
    public function actionTuman()
    {
        $userId = Uni::$app->getUser()->identity->tuman_id;
        $user_tuman = Uni::$app->getUser()->identity->viloyat_id;
        $current = Lang::getCurrent();
        $m = new VkUchastka();

        $res = new ActiveDataProvider([
            'query' => VkUchastka::find()->where(['tuman_id'=>$userId, 'viloyat_id'=>$user_tuman])->orderBy(["id"=>SORT_DESC])
        ]);
        $res->pagination->pageSize=20;

        $kutish = new ActiveDataProvider([
            'query' => UserModel::find()->joinWith('vkuchas')->where("`vk_uchastka`.`status`=0 and `vk_uchastka`.`tuman_id`=$userId and `vk_uchastka`.`viloyat_id`=$user_tuman and `uni_user_security`.`status`=1")->orderBy(["username"=>SORT_ASC])->distinct()
        ]);
        $kutish->pagination->pageSize=20;

        $tuman = Uchastka::find()->where(['tuman_id'=>$userId, 'viloyat_id'=>$user_tuman])->orderBy(["name_uz"=>SORT_ASC])->all();
        if ($current->url=="ru") $map = ArrayHelper::map($tuman,'id','name_ru');
        else $map = ArrayHelper::map($tuman,'id','name_uz');
        //$map = ArrayHelper::map($tuman,'id','name_uz');
//        else $map = ArrayHelper::map($tuman,'id','name_uz');

        $vil_vaksina = Vktuman::find()->where(['tuman_id'=>$userId, 'status'=>Vktuman::STATUS_ACTIVE])->all();
//        var_dump($vil_vaksina); die;
        $vaksina = [];
        foreach ($vil_vaksina as $item){
            $vaksina[] = Vaksina::find()->where(['status'=>Vaksina::STATUS_ACTIVE, 'id'=>$item->vaksina_id])->orderBy(["name_$current->url"=>SORT_ASC])->one();
        }
        if ($current->url=="ru") $map2 = ArrayHelper::map($vaksina,'id','name_ru');
        else $map2 = ArrayHelper::map($vaksina,'id','name_uz');

        return $this->render('tuman_old',['data' => $res,'userId'=>$userId, 'm'=>$m, 'tuman'=>$map, 'vaksina'=>$map2, 'kutish'=>$kutish, ]);
    }

    public function actionError()
    {
        $this->layout='/error';
        $exception = Uni::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }

    public function actionMain()
    {
//        var_dump(Uni::$app->controller->access('ADMIN_VIL')); die;
        return $this->render('main');
    }

}
