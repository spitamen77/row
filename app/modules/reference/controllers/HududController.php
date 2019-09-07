<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 21.11.2018 15:51
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

namespace app\modules\reference\controllers;

use app\models\Lang;
use app\models\Tuman;
//use app\models\search\TumanSearch;
use app\components\Controller;
use app\models\Viloyat;
// use app\models\Uchastka;
use uni\ui\Form;
use uni\web\NotFoundHttpException;
use uni\web\ForbiddenHttpException;
use app\models\UserModel;
use app\models\Uchastka;
use Uni;
use uni\data\ActiveDataProvider;



/**
 * UchastkaController implements the CRUD actions for Tuman model.
 */
class HududController extends Controller
{
    //public $block="/left";
    public $cm="reference";
    public $layout="/settings";
    public function beforeAction($action)
    {
//         if(!$this->access('ADMIN')){
//             throw new ForbiddenHttpException('Sizda bu sahifa uchun ruxsat mavjud emas');
//         }
        return parent::beforeAction($action);
    }
    /**
     * Lists all Tuman models.
     * @return mixed
     */
    public function actionIndex()
    {
        $current = Lang::getCurrent();
        $new = new Uchastka();
        $user = Uni::$app->getUser()->identity;
        $model = Uchastka::find()->where(['status'=>Tuman::STATUS_ACTIVE])->andWhere(['tuman_id'=>$user->tuman_id])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        if (Uni::$app->request->get('region')){
            $tuman_id = Uni::$app->request->get('region');
            if (!empty($tuman_id)) {
                $data = new ActiveDataProvider([
                    'query' => Uchastka::find()->joinWith('tuman')->where("uni_tuman.status=1 and uni_uchastka.status!=9 and uni_uchastka.viloyat_id=$tuman_id")->andWhere(['tuman_id'=>$user->tuman_id])->orderBy(["name_$current->url"=>SORT_ASC])->distinct()
                ]);
                if (empty($data)) $data = new ActiveDataProvider([
                    'query' => Uchastka::find()->joinWith('tuman')->where("uni_tuman.status=1 and uni_uchastka.status!=9")->andWhere(['tuman_id'=>$user->tuman_id])->orderBy(["name_$current->url"=>SORT_ASC])->distinct()
                ]);
            }
            else $data = new ActiveDataProvider([
                'query' => Uchastka::find()->joinWith('tuman')->where("uni_tuman.status=1 and uni_uchastka.status!=9")->andWhere(['tuman_id'=>$user->tuman_id])->orderBy(["name_$current->url"=>SORT_ASC])->distinct()
            ]);
        }
        else $data = new ActiveDataProvider([
            'query' => Uchastka::find()->joinWith('tuman')->where("uni_tuman.status=1 and uni_uchastka.status!=9")->andWhere(['tuman_id'=>$user->tuman_id])->orderBy(["name_$current->url"=>SORT_ASC])->distinct()
        ]);
        $data->pagination->pageSize=20;
        if (Uni::$app->request->get('q')){
            $key = Uni::$app->request->get('q');
            $all = new ActiveDataProvider([
                'query' => Uchastka::find()->joinWith('tuman')->where("`uni_tuman`.`status`=1 and `uni_uchastka`.`status`!=9 and (`uni_uchastka`.`name_ru` like '%" . $key . "%' or `uni_uchastka`.`name_uz` like '%" . $key . "%')")->andWhere(['tuman_id'=>$user->tuman_id])
            ]);
        }
        else $all = false;
        return $this->render('index', ['items'=>$model, 'tuman'=>$data, 'new'=>$new, 'query'=>$all, 'user'=>$user]);
    }

    /**
     * Displays a single Tuman model.
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
                //'viloyat_id'=>$viloyat
            ];
        }
        else return "error";
    }

    /**
     * Creates a new Tuman model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tuman();

        if ($model->load(Uni::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_Tuman]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionSave(){
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $model = new Uchastka();
        parse_str($_POST['data'],$data);
        if ($model->load($data)) {
            //return ['status' => $model->{'tuman_id'}];
            $model->{'status'} = 1;
            if ($model->save()) {
                return ['status' => 'success'];
            } else {
                return ['status'=>'error'];
            }
        }
    }

    /**
     * Updates an existing Tuman model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Uni::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_Tuman]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionEdit($id){
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if(!$model){
            throw new NotFoundHttpException;
        }
        $data = [];
        parse_str($_POST['data'],$data);
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

    /**
     * Deletes an existing Tuman model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (!empty($model)){
            $model->status = 9;
//            $model->user_id = Uni::$app->getUser()->getId();
//            $model->updated_at = time();
            $model->save(false);
            Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            return ['status'=>'success'];
        }
        else return ['status'=>'error'];
    }

    public function actionChangestatus($id){
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $direction = $this->findModel($id);
        if (!empty($direction)){
            if($direction->status == 0){
                $direction->status = 1;
            }
            else{
                $direction->status = 0;
            }
//            $direction->user_id = Uni::$app->getUser()->getId();
//            $direction->updated_at = time();
            if($direction->save()){
                return ['status' => 'statusChanged'];
            }
            return ['status' => 'statusUnchanged'];
        }
        else return ['status' => 'statusUnchanged'];
    }

    /**
     * Finds the Uchastka model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Uchastka the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Uchastka::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionList()
    {
        $id = $_GET['id'];
        $tuman = Uchastka::find()->where(['status'=>Uchastka::STATUS_ACTIVE, 'tuman_id'=>$id])->all();
        $response = "";
        if (!empty($tuman)){
            //echo "<option>".Uni::t('app', 'Select')."...</option>";
            foreach ($tuman as $item){
                //$response = $response."{id:".$item->id.", title: '".$item->name_ru."', url: '".$item->name_ru."'},";
                // {id: 1, title: 'Mercury', url: 'http://en.wikipedia.org/wiki/Mercury_(planet)'},
                if(Uni::$app->language=='ru')echo "<option value='".$item->id."'>".$item->name_ru."</option>";
                else echo "<option value='".$item->id."'>".$item->name_uz."</option>";
            }
        }
        else echo "<option> - </option>";
        //return $response;

        // if (!empty($tuman)){
        //     //echo "<option>".Uni::t('app', 'Select')."...</option>";
        //     foreach ($tuman as $item){
                
        //         if(Uni::$app->language=='ru')echo "<div class='option' data-selectable='' data-value='".$item->id."'><span class='title'>".$item->name_ru."</span></div>";
        //         else echo "<div class='option' data-selectable='' data-value='".$item->id."'><span class='title'>".$item->name_uz."</span></div>";
        //     }
        // }
        // else echo '<div class="option" data-selectable="" data-value="1"><span class="title">sdfsdfsd</span></div>';
    }
}
