<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 21.11.2018 15:36
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

namespace app\modules\reference\controllers;

use app\models\Prixod;
use app\models\Tuman;
use app\models\Vaksina;
use app\models\Viloyat;
//use app\models\search\ViloyatSearch;
use app\components\Controller;
use app\models\VkTuman;
use app\models\VkUchastka;
use app\models\VkViloyat;
use uni\helpers\ArrayHelper;
use uni\ui\Form;
use uni\web\NotFoundHttpException;
use uni\web\ForbiddenHttpException;
use app\models\UserModel;
use Uni;
use app\models\Lang;
use uni\data\ActiveDataProvider;

/**
 * ViloyatController implements the CRUD actions for Viloyat model.
 */
class ViloyatController extends Controller
{
    public $block="/left";
    public $cm="reference";
    public $layout="/settings";
    public function beforeAction($action)
    {
        if(!$this->access('ADMIN')){
            throw new ForbiddenHttpException('Sizda bu sahifa uchun ruxsat mavjud emas');
        }
        return parent::beforeAction($action);
    }
    /**
     * Lists all Viloyat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $current = Lang::getCurrent();
        $model = new ActiveDataProvider([
            'query' => Viloyat::find()->where(['status'=>Viloyat::STATUS_ACTIVE])->orWhere(['status'=>Viloyat::STATUS_INACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])
        ]);
        $model->pagination->pageSize=20;
        if (Uni::$app->request->get('q')){
            $key = Uni::$app->request->get('q');
            $all = new ActiveDataProvider([
                'query' => Viloyat::find()->where("`uni_viloyat`.`status`!=9 and (`uni_viloyat`.`name_ru` like '%" . $key . "%' or `uni_viloyat`.`name_uz` like '%" . $key . "%')")
            ]);
        }
        else $all = false;
        return $this->render('index', ['items'=>$model, 'query'=>$all]);
    }

    /**
     * Displays a single Viloyat model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        $id = $_GET['id'];
        $view = $this->findModel($id);
        if (!empty($view)){
            \Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            return [
                'name_ru'=>$view->name_ru,
                'name_uz'=>$view->name_uz,
            ];
        }
        else return "error";
    }

    /**
     * Creates a new Viloyat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Viloyat();
        $model->name_ru = $_GET['input2'];
        $model->name_uz = $_GET['input'];
//        $model->user_id = Uni::$app->getUser()->getId();
//        $model->created_at = time();
        if ($model->save()){
            return 'success';
        }
        else return "error";
    }

    /**
     * Updates an existing Viloyat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $id = $_GET['id'];
        $view = $this->findModel($id);
        if (!empty($view)){
            \Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            return [
                'name_ru'=>$view->name_ru,
                'name_uz'=>$view->name_uz,
            ];
        }
        else return "error";
    }

    public function actionEdit()
    {
        $id = $_GET['id'];
        $text1 = $_GET['text1'];
        $text2 = $_GET['text2'];
        $view = $this->findModel($id);
        if (!empty($view)){
            $view->name_uz = $text2;
            $view->name_ru = $text1;
//            $view->user_id = Uni::$app->getUser()->getId();
//            $view->updated_at = time();
            $view->save(false);
//            \Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            return 'success';
        }
        else return "error";
    }

    public function actionChange()
    {
        $id = $_GET['id'];
        $status = $_GET['status'];
        $view = $this->findModel($id);
        if (!empty($view)){
            $view->status = $status;
//            $view->user_id = Uni::$app->getUser()->getId();
//            $view->updated_at = time();
            $view->save(false);
//            \Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            return 'success';
        }
        else return "error";
    }

    /**
     * Deletes an existing Viloyat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        $id = $_GET['id'];
        $model = $this->findModel($id);
        if (!empty($model)){
            $model->status = 9;
//            $model->user_id = Uni::$app->getUser()->getId();
//            $model->updated_at = time();
            $model->save(false);
            return 'success';
        }
        else return "error";
    }

    /**
     * Finds the Viloyat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Viloyat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Viloyat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSaveviloyat()
    {
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $model = new VkViloyat();
        parse_str($_POST['data'],$data);

        if ($model->load($data)) {
            $count = Prixod::find()->where(['status'=>Prixod::STATUS_ACTIVE, 'vaksina_id'=>$model->{'vaksina_id'}, 'id'=>$model->{'proxod_id'}])->one();
//            $jami =Prixod::find()->where(['id'=>$model->{'proxod_id'}])->one();
//            return ['status' => $model->{'proxod_id'}];
            if (empty($count)) return ['status'=>'error'];
            if ($model->{'vaksina_miqdor'}==0) return ['status'=>Uni::t('app', '0 is not allowed')];
            if ($count->count >= $count->ostatok+$model->{'vaksina_miqdor'}){
                $d1 = strtotime($model->{'proxod_date'}); // переводит из строки в дату
                $model->{'proxod_date'} = $d1+25000;
                $model->{'status'} = 0;
                if ($model->save()) {
                    $count->ostatok = $count->ostatok+$model->{'vaksina_miqdor'};
                    $count->save(false);
                    return ['status' => 'success'];
                } else {
                    return ['status'=>'error'];
                }
            }
            else return ['status'=>Uni::t('app', 'Not enough balance in inventory and inventory costs')];

        }
        return ['error'=>'ok','message'=>$model->errors];
    }

    public function actionSavetuman()
    {
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $model = new VkTuman();
        parse_str($_POST['data'],$data);

        if ($model->load($data)) {
//            $count = VkTuman::find()->where(['status'=>VkTuman::STATUS_ACTIVE, 'vaksina_id'=>$model->{'vaksina_id'}, 'viloyat_id'=>$model->{'viloyat_id'}])->sum('vaksina_miqdor');
            $count =VkViloyat::findOne($model->{'vil_prixod'});
//            return ['status' => $model->{'vil_prixod'}];
            if (empty($count)) return ['status'=>'error'];
            if ($model->{'vaksina_miqdor'}==0) return ['status'=>Uni::t('app', '0 is not allowed')];
            if ($count->vaksina_miqdor >= $count->ostatok+$model->{'vaksina_miqdor'}){
                $d1 = strtotime($model->{'vaksina_date'}); // переводит из строки в дату
                $model->{'vaksina_date'} = $d1+25000;
                $model->{'prixod_id'} = $count->proxod_id;
                $model->{'status'} = 0;
                if ($model->save()) {
                    $count->ostatok = $count->ostatok+$model->{'vaksina_miqdor'};
                    $count->save(false);
                    return ['status' => 'success'];
                } else {
                    return ['status'=>'error'];
                }
            }
            else return ['status'=>Uni::t('app', 'Not enough balance in inventory and inventory costs')];

        }
        return ['error'=>'ok','message'=>$model->errors];
    }

    public function actionSaveuser()
    {
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $model = new VkUchastka();
        parse_str($_POST['data'],$data);

        if ($model->load($data)) {
//            $count = VkTuman::find()->where(['status'=>VkTuman::STATUS_ACTIVE, 'vaksina_id'=>$model->{'vaksina_id'}, 'viloyat_id'=>$model->{'viloyat_id'}])->sum('vaksina_miqdor');
            $count =Vktuman::findOne($model->{'tum_prixod'});
//            return ['status' => $model->{'uchastka_id'}];
            if (empty($count)) return ['status'=>'error'];
            if ($model->{'vaksina_miqdor'}==0) return ['status'=>Uni::t('app', '0 is not allowed')];
            if ($count->vaksina_miqdor >= $count->ostatok+$model->{'vaksina_miqdor'}){
                $d1 = strtotime($model->{'vaksina_date'}); // переводит из строки в дату
                $model->{'vaksina_date'} = $d1+25000;
                $model->{'viloyat_id'} = $count->viloyat_id;
                $model->{'uchastka_id'} = $model->{'tuman_id'}; /* User ID sini yozyapman*/
                $model->{'status'} = 0;
                $model->{'tuman_id'} = $count->tuman_id;
                $model->{'prixod_id'} = $count->prixod_id;
                if ($model->save(false)) {
                    $count->ostatok = $count->ostatok+$model->{'vaksina_miqdor'};
                    $count->save(false);
                    return ['status' => 'success'];
                } else {
                    return ['status'=>'error'];
                }
            }
            else return ['status'=>Uni::t('app', 'Not enough balance in inventory and inventory costs')];

        }
        return ['error'=>'ok','message'=>$model->errors];
    }

    public function actionList()
    {
        $id = $_GET['id'];
        $tuman = Prixod::find()->where(['status'=>Prixod::STATUS_ACTIVE, 'vaksina_id'=>$id])->all();
        if (!empty($tuman)){
            foreach ($tuman as $item){
                if ($item->ostatok ==$item->count) continue;
                if(Uni::$app->language=='ru')echo "<option value='".$item->id."'>".$item->name_ru."</option>";
                else echo "<option value='".$item->id."'>".$item->name_uz."</option>";
            }
        }
        else echo "<option> - </option>";
    }

    public function actionListcity()
    {
        $id = $_GET['id'];
//        $tuman = Vkviloyat::find()->where(['status'=>Vkviloyat::STATUS_ACTIVE, 'vaksina_id'=>$id])->one();
        $prixod = Vkviloyat::find()->where(['viloyat_id'=>Uni::$app->getUser()->identity->viloyat_id,'status'=>Vkviloyat::STATUS_ACTIVE, 'vaksina_id'=>$id])->all();
        if (!empty($prixod)){
            foreach ($prixod as $item){
                if ($item->vaksina_miqdor==$item->ostatok) continue;
                echo "<option value='".$item->id."'>".$item->nomer."</option>";
            }
        }
        else echo "<option>".Uni::t("app", "Vaccine number")."</option>";
    }

    public function actionListuser()
    {
        $id = $_GET['id'];
        $prixod = Vktuman::find()->where(['tuman_id'=>Uni::$app->getUser()->identity->tuman_id, 'viloyat_id'=>Uni::$app->getUser()->identity->viloyat_id,'status'=>Vktuman::STATUS_ACTIVE, 'vaksina_id'=>$id])->all();
        if (!empty($prixod)){
            foreach ($prixod as $item){
                if ($item->vaksina_miqdor==$item->ostatok) continue;
                echo "<option value='".$item->id."'>".$item->nomer."</option>";
            }
        }
        else echo "<option>".Uni::t("app", "Vaccine number")."</option>";
    }

    public function actionKg()
    {
        $id = $_GET['id'];
        $model = Vaksina::findOne($id);
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        if (!empty($model)) return ['status' => $model->unit->name,
            'val'=>$model->unit_id,
            'doza'=>$model->doza,
        ];
        else return ['status' => "error"];
    }

    /* Hisobotlar oynasi boshlandi*/

    public function actionViloyat($id)
    {
        $vil = Viloyat::findOne($id);
        if (!empty($vil)){
            $current = Lang::getCurrent();
            $m = new VkTuman;

            $res = new ActiveDataProvider([
                'query' => Tuman::find()->joinWith('vkt')->where("`vk_tuman`.`status`=1 and `vk_tuman`.`viloyat_id`=$id and `uni_tuman`.`status`=1")->orderBy(["name_$current->url"=>SORT_ASC])->distinct()
            ]);
            $res->pagination->pageSize=20;

            if (Uni::$app->request->get('q')){
                $key = Uni::$app->request->get('q');
                $all = new ActiveDataProvider([
                    'query' => Tuman::find()->joinWith('vkt')->where("`vk_tuman`.`status`=1 and `vk_tuman`.`viloyat_id`=$id and `uni_tuman`.`status`=1 and (`uni_tuman`.`name_ru` like '%" . $key . "%' or `uni_tuman`.`name_uz` like '%" . $key . "%')")
                ]);
            }
            else $all = false;

            $kutish = new ActiveDataProvider([
                'query' => Tuman::find()->joinWith('vkt')->where("`vk_tuman`.`status`=0 and `vk_tuman`.`viloyat_id`=$id and `uni_tuman`.`status`=1")->orderBy(["name_$current->url"=>SORT_ASC])->distinct()
            ]);
            $kutish->pagination->pageSize=20;

            $tuman = Tuman::find()->where(['status'=>Tuman::STATUS_ACTIVE, 'viloyat_id'=>$id])->orderBy(["name_$current->url"=>SORT_ASC])->all();
            if ($current->url=="ru") $map = ArrayHelper::map($tuman,'id','name_ru');
            else $map = ArrayHelper::map($tuman,'id','name_uz');

            $vil_vaksina = Vkviloyat::find()->where(['viloyat_id'=>$id, 'status'=>Vkviloyat::STATUS_ACTIVE])->all();
//        var_dump($vil_vaksina); die;
            $vaksina = [];
            foreach ($vil_vaksina as $item){
                $vaksina[] = Vaksina::find()->where(['status'=>Vaksina::STATUS_ACTIVE, 'id'=>$item->vaksina_id])->orderBy(["name_$current->url"=>SORT_ASC])->one();
            }
//        var_dump($vaksina); die;
            if ($current->url=="ru") $map2 = ArrayHelper::map($vaksina,'id','name_ru');
            else $map2 = ArrayHelper::map($vaksina,'id','name_uz');

            return $this->render('viloyat',['data' => $res,'userId'=>$id, 'm'=>$m, 'tuman'=>$map, 'vaksina'=>$map2, 'kutish'=>$kutish, 'query'=>$all]);

        }
        else throw new ForbiddenHttpException('Sizda bu sahifa uchun ruxsat mavjud emas');
    }

    public function actionTuman($item, $id)
    {
//        $userId = Uni::$app->getUser()->identity->tuman_id;
//        $user_tuman = Uni::$app->getUser()->identity->viloyat_id;
        $tum = Tuman::findOne(['id'=>$id, 'viloyat_id'=>$item]);
        if (!empty($tum)){
            $user_tuman = $item; $userId = $id;
            $current = Lang::getCurrent();
            $m = new VkUchastka();

            $res = new ActiveDataProvider([
                'query' => UserModel::find()->where(['tuman_id'=>$userId, 'viloyat_id'=>$user_tuman])->orderBy(["username"=>SORT_ASC])
            ]);
            $res->pagination->pageSize=20;

            if (Uni::$app->request->get('q')){
                $key = Uni::$app->request->get('q');
                $all = new ActiveDataProvider([
                    'query' => UserModel::find()->where(['tuman_id'=>$userId, 'viloyat_id'=>$user_tuman])->andFilterWhere([
                        'or',
                        ['like', 'username', $key],
                        ['like', 'phone', $key],
                    ])
                ]);
            }
            else $all = false;

            $kutish = new ActiveDataProvider([
                'query' => UserModel::find()->joinWith('vkuchas')->where("`vk_uchastka`.`status`=0 and `vk_uchastka`.`tuman_id`=$userId and `vk_uchastka`.`viloyat_id`=$user_tuman and `uni_user_security`.`status`=1")->orderBy(["username"=>SORT_ASC])->distinct()
            ]);
            $kutish->pagination->pageSize=20;

            $tuman = UserModel::find()->where(['tuman_id'=>$userId, 'viloyat_id'=>$user_tuman])->orderBy(["username"=>SORT_ASC])->all();
            $map = ArrayHelper::map($tuman,'id','phone');
    //        else $map = ArrayHelper::map($tuman,'id','name_uz');

            $vil_vaksina = Vktuman::find()->where(['tuman_id'=>$userId, 'status'=>Vktuman::STATUS_ACTIVE])->all();
    //        var_dump($vil_vaksina); die;
            $vaksina = [];
            foreach ($vil_vaksina as $item){
                $vaksina[] = Vaksina::find()->where(['status'=>Vaksina::STATUS_ACTIVE, 'id'=>$item->vaksina_id])->orderBy(["name_$current->url"=>SORT_ASC])->one();
            }
            if ($current->url=="ru") $map2 = ArrayHelper::map($vaksina,'id','name_ru');
            else $map2 = ArrayHelper::map($vaksina,'id','name_uz');

            return $this->render('tuman',['data' => $res,'userId'=>$userId, 'm'=>$m, 'tuman'=>$map, 'vaksina'=>$map2, 'kutish'=>$kutish, 'query'=>$all, 'tuman_id'=>$userId,'viloyat_id'=>$user_tuman]);
        }
        else throw new ForbiddenHttpException('Sizda bu sahifa uchun ruxsat mavjud emas');
    }

    public function actionUser()
    {
        if (!Uni::$app->request->get()){
            throw new ForbiddenHttpException('Sizda bu sahifa uchun ruxsat mavjud emas');
        }
        $id = $_GET['sir'];
        $vil = $_GET['reg'];
        $tum = $_GET['tum'];
//        $q = $_GET['q'];
        $current = Lang::getCurrent();
        $user = UserModel::findOne($id);
        if (!empty($user)){
            $res = new ActiveDataProvider([
                'query' => VkUchastka::find()->where(['uchastka_id'=>$id, 'status'=>VkUchastka::STATUS_ACTIVE, 'tuman_id'=>$tum, 'viloyat_id'=>$vil])->orderBy(["id"=>SORT_DESC])
            ]);
            $res->pagination->pageSize=20;

            $kutish = new ActiveDataProvider([
                'query' => VkUchastka::find()->where(['uchastka_id'=>$id, 'status'=>VkUchastka::STATUS_INACTIVE, 'tuman_id'=>$tum, 'viloyat_id'=>$vil])->orderBy(["id"=>SORT_DESC])
            ]);
            $kutish->pagination->pageSize=20;

            $vaksina = [];
            foreach ($res->models as $item){
                $vaksina[] = Vaksina::find()->where(['status'=>Vaksina::STATUS_ACTIVE, 'id'=>$item->vaksina_id])->orderBy(["name_$current->url"=>SORT_ASC])->one();
            }
            if ($current->url=="ru") $map2 = ArrayHelper::map($vaksina,'id','name_ru');
            else $map2 = ArrayHelper::map($vaksina,'id','name_uz');

            return $this->render('user',['data' => $res,'userId'=>$user,  'vaksina'=>$map2, 'kutish'=>$kutish]);

        }
        else throw new ForbiddenHttpException('Sizda bu sahifa uchun ruxsat mavjud emas');
    }
}
