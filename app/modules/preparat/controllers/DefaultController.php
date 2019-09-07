<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 12/17/18
 * Time: 11:38
 */

namespace app\modules\preparat\controllers;

use app\models\HayvonTuri;
use app\models\Lang;
use app\models\Prixod;
use app\models\Vaksina;
use app\models\VaksinaAnimal;
use app\models\VkViloyat;
use app\models\VaksinaTuri;
use app\models\Unit;
use Uni;
use app\components\Controller;
use uni\data\ActiveDataProvider;
use uni\helpers\ArrayHelper;
use uni\web\ForbiddenHttpException;

class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        if(!$this->access('ADMIN')){
            if (($action->id!="index") && ($action->id!="view")){
            throw new ForbiddenHttpException('Sizda bu sahifa uchun ruxsat mavjud emas');
            }
        }
        return parent::beforeAction($action);
    }

    public function actionIndex(){

        $new = new Vaksina();
        $current = Lang::getCurrent();

        $model = VaksinaTuri::find()->where(['status'=>VaksinaTuri::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();

        $ves = Unit::find()->where(['status'=>Unit::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        if ($current->url=="ru") $map2 = ArrayHelper::map($ves,'id','name_ru');
        else $map2 = ArrayHelper::map($ves,'id','name_uz');

        $hayvon = HayvonTuri::find()->where(['status'=>HayvonTuri::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();

        $data =$new->search(Uni::$app->request->queryParams);
        $data->pagination->pageSize=15;
        return $this->render("index", [
            'dataProvider' => $data, 'new'=>$new,
            'items'=>$model, 'unit'=>$map2, 'hayvon'=>$hayvon
        ]);
    }
    public function actionView($id){
        $new = new Vaksina();
        $current = Lang::getCurrent();
        $model=Vaksina::findOne($id);
        if (!$model) throw new \uni\web\NotFoundHttpException('The requested page does not exist.');
        $model2 = VaksinaTuri::find()->where(['status'=>VaksinaTuri::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        $ves = Unit::find()->where(['status'=>Unit::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        if ($current->url=="ru") $map2 = ArrayHelper::map($ves,'id','name_ru');
        else $map2 = ArrayHelper::map($ves,'id','name_uz');

        $hayvon = HayvonTuri::find()->where(['status'=>HayvonTuri::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();

        return $this->render("view",['model'=>$model,
            'new'=>$new,'hayvon'=>$hayvon,
            'items'=>$model2, 'unit'=>$map2,]);
    }
    public function actionAdd(){
//        $new = new Vaksina();
//        $current = Lang::getCurrent();
//
//        $model = VaksinaTuri::find()->where(['status'=>VaksinaTuri::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
//
//        $ves = Unit::find()->where(['status'=>Unit::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
//        if ($current->url=="ru") $map2 = ArrayHelper::map($ves,'id','name_ru');
//        else $map2 = ArrayHelper::map($ves,'id','name_uz');
//
//        $hayvon = HayvonTuri::find()->where(['status'=>HayvonTuri::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
//        return $this->render("index", [
//             'new'=>$new,'hayvon'=>$hayvon,
//            'items'=>$model, 'unit'=>$map2,
//        ]);
    }
    public function actionSave(){
        $model = new Vaksina();
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
//        return ['status' => print_r($_POST['data'])];
        parse_str($_POST['data'],$data);
        if ($model->load($data)) {

            $model->{'count'} = 0;
            $model->{'status'} = 1;
            if ($model->save()) {
                $hayvon = new VaksinaAnimal();
                $hayvon->vaksina_id = $model->id;
                $hayvon->category_id = $data["category_id"];
                $hayvon->amount = 0;
                $hayvon->emlash_turi = $data["emlash_turi"];
                $hayvon->emlash_vaqti = $data["emlash_vaqti"];
                $hayvon->emlash_hududi = $data["emlash_hududi"];
                $hayvon->temperatura = $data["temperatura"];
                $hayvon->hayvon_turi_yoshi = $data["hayvon_turi_yoshi"];
                $hayvon->emlash_uchun = $data["emlash_uchun"];
                $hayvon->emlash_davri = $data["emlash_davri"];
                $hayvon->revaksinatsiya = $data["revaksinatsiya"];
                $hayvon->immunitet = $data["immunitet"];
                $hayvon->emlash_vaqti = $data["emlash_vaqti"];
                $hayvon->laboratoriya_diagnos = $data["laboratoriya_diagnos"];
                $hayvon->talab_cheklash = $data["talab_cheklash"];
                $hayvon->save();
//                for ($i=0; $i<10; $i++){ /* Men oldindan nechta qo`shishini bilmadim, shuning uchun MAX=10 oldim*/
//                    if ($i==0) {
//                        if (!empty($data["address__$i"])) {
//                            $hayvon = new VaksinaAnimal();
//                            $hayvon->vaksina_id = $model->id;
//                            $hayvon->category_id = $data["hay__$i"];
//                            $hayvon->amount = $data["address__$i"];
//                            $hayvon->save();
//                        }
//                        else {
//                            $hayvon = new VaksinaAnimal();
//                            $hayvon->vaksina_id = $model->id;
//                            $hayvon->category_id = 0;
//                            $hayvon->amount = 0;
//                            $hayvon->save();
//                        }
//                    }
//                    else  {
//                        if (!empty($data["address__$i"])) {
//                            $hayvon = new VaksinaAnimal();
//                            $hayvon->vaksina_id = $model->id;
//                            $hayvon->category_id = $data["hay__$i"];
//                            $hayvon->amount = $data["address__$i"];
//                            $hayvon->save();
//                        }
//                    }
//                }

                return ['status' => 'success', 'id'=>$model->id];
            } else {
                return ['status'=>'error'];
            }
        }
    }

    public function actionEdit($id)
    {
        $current = Lang::getCurrent();
        $model=Vaksina::findOne($id);
        $model2 = VaksinaTuri::find()->where(['status'=>VaksinaTuri::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        $ves = Unit::find()->where(['status'=>Unit::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        if ($current->url=="ru") $map2 = ArrayHelper::map($ves,'id','name_ru');
        else $map2 = ArrayHelper::map($ves,'id','name_uz');
        $hayvon = HayvonTuri::find()->where(['status'=>HayvonTuri::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        $animal = VaksinaAnimal::find()->where(['vaksina_id'=>$id])->one();
        $request = \Uni::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            $model2= $this->loadModel("VaksinaAnimal", $animal->id);
            $model2->emlash_turi = $_POST['emlash_turi'];
            $model2->save();

            $this->fileupload = "file";
            $model= $this->loadModel("Vaksina", $id);
            if ($model->save()){

                /* Dinamik VaksinaAnimal tahrirlanmoqda*/
//                foreach ($_POST['Vaksina'] as $key=>$value){
//                    if ($key=="power"){
//                        foreach ($value as $kalit =>$item){
//                            $power = VaksinaAnimal::findOne($kalit);
//                            $power->amount = $item;
//                            $power->save();
//                        }
//                    }
//                }
                /* Dinamik VaksinaAnimal qo`shilmoqda*/
//                for ($i=0; $i<10; $i++){ /* Men oldindan nechta qo`shishini bilmadim, shuning uchun MAX=10 oldim*/
//                    if ($i==0) {
//                        if (!empty($_POST["address__$i"])) {
//                            $hayvon = new VaksinaAnimal();
//                            $hayvon->vaksina_id = $model->id;
//                            $hayvon->category_id = $_POST["hay__$i"];
//                            $hayvon->amount = $_POST["address__$i"];
//                            $hayvon->save();
//                        }
//                        else {
//                            $hayvon = new VaksinaAnimal();
//                            $hayvon->vaksina_id = $model->id;
//                            $hayvon->category_id = 0;
//                            $hayvon->amount = 0;
//                            $hayvon->save();
//                        }
//                    }
//                    else  {
//                        if (!empty($_POST["address__$i"])) {
//                            $hayvon = new VaksinaAnimal();
//                            $hayvon->vaksina_id = $model->id;
//                            $hayvon->category_id = $_POST["hay__$i"];
//                            $hayvon->amount = $_POST["address__$i"];
//                            $hayvon->save();
//                        }
//                    }
//                }

                $xabar = Uni::t('app', 'Success');
                return $this->redirect(['view', 'id' => $id]);
            }
        }
            return $this->render("edit", [
            'new'=>$model,'items'=>$model2,'unit'=>$map2,'hayvon'=>$hayvon,'animal'=>$animal
            ]);
    }

    public function actionDownload($id){
        $item = Vaksina::findOne($id);
        return Uni::$app->response->sendFile(Uni::getAlias('@webroot').$item->file);
    }

}