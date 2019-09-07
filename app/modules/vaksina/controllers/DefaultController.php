<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 12/17/18
 * Time: 11:38
 */

namespace app\modules\vaksina\controllers;

use app\models\Lang;
use app\models\Prixod;
use app\models\Vaksina;
use app\models\VaksinaPerform;
use app\models\VkViloyat;
use DateTime;
use DateTimeZone;
use Uni;
use app\components\Controller;
use uni\data\ActiveDataProvider;
use uni\helpers\ArrayHelper;

class DefaultController extends Controller
{
    public function actionIndex(){
        if(Uni::$app->controller->access('ADMIN')){
            $day = date('d');
            $month = date('m');
            $year = date('Y');
            $d = DateTime::createFromFormat('j-n-Y-H-i-s', "$day-$month-$year-0-00-10", new DateTimeZone('+0500'));
            $start = $d->getTimestamp();
            $finish = $d->getTimestamp()+83000;
            $per = new ActiveDataProvider([
                'query' => VaksinaPerform::find()->where(['between', 'created_at', $start, $finish])->orderBy(['id'=>SORT_DESC])
            ]);
            $per->pagination->pageSize=15;
            return $this->render('admin',['per'=>$per]);
        }elseif(Uni::$app->controller->access('ADMIN_VIL')){
            return $this->render("vil", ['viloyat_id'=>Uni::$app->getUser()->identity->viloyat_id]);
        }elseif(Uni::$app->controller->access('ADMIN_TUM')){
            return $this->render("tuman", ['viloyat_id'=>Uni::$app->getUser()->identity->viloyat_id, 'tuman_id'=>Uni::$app->getUser()->identity->tuman_id]);
        }
    }

    public function actionView($id)
    {
        $new = new Prixod();
        $current = Lang::getCurrent();
        $viloyat = new ActiveDataProvider([
            'query' => VkViloyat::find()->where(['proxod_id'=>$id])->orderBy(["id"=>SORT_DESC])
        ]);
        $viloyat->pagination->pageSize=20;

        $prixod = Prixod::findOne($id);

        $vaksina = Vaksina::find()->where(['status'=>Vaksina::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        if ($current->url=="ru") $map2 = ArrayHelper::map($vaksina,'id','name_ru');
        else $map2 = ArrayHelper::map($vaksina,'id','name_uz');


        return $this->render('view', ['viloyat'=>$viloyat, "prixod"=>$prixod, 'new'=>$new, 'vaksina'=>$map2]);
    }
    public function actionList($id)
    {
        $data = Prixod::find()->where(['vaksina_id'=>$id])->all();
        $vaksina = Vaksina::findOne($id);
        return $this->render('list',['data'=>$data,'vaksina'=>$vaksina]);


        
    }
    public function actionAll()
    {
        $new = new Prixod();
        $current = Lang::getCurrent();
        $data = new ActiveDataProvider([
            'query' => Prixod::find()->where(['status'=>Prixod::STATUS_ACTIVE])->orWhere(['status'=>Prixod::STATUS_INACTIVE])->orderBy(["id"=>SORT_DESC])
        ]);
        $data->pagination->pageSize=20;
        if (Uni::$app->request->get('q')){
            $key = Uni::$app->request->get('q');
            $all = new ActiveDataProvider([
                'query' => Prixod::find()->where("`vk_proxod`.`status`!=9 and (`vk_proxod`.`name_ru` like '%" . $key . "%' or `vk_proxod`.`name_uz` like '%" . $key . "%')")
            ]);
        }
        else $all = false;

        $vaksina = Vaksina::find()->where(['status'=>Vaksina::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        if ($current->url=="ru") $map2 = ArrayHelper::map($vaksina,'id','name_ru');
        else $map2 = ArrayHelper::map($vaksina,'id','name_uz');

        return $this->render('all', ['items'=>$data, "new"=>$new, 'query'=>$all, 'vaksina'=>$map2]);
    }

}