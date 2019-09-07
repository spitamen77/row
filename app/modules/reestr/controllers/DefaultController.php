<?php

namespace app\modules\reestr\controllers;

use app\models\Ban;
use app\models\Contravention;
use app\models\Lang;
use app\models\Reestr;
use app\components\Controller;
use app\models\Tuman;
use app\models\TypeActivity;
use app\models\Viloyat;
use Uni;
use uni\data\ActiveDataProvider;
use uni\helpers\ArrayHelper;
use uni\web\ForbiddenHttpException;
use uni\web\NotFoundHttpException;
use uni\web\UploadedFile;

class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        if((!$this->access('ADMIN'))&&(!$this->access('ADMIN_VIL'))){
            throw new ForbiddenHttpException('Sizda bu sahifa uchun ruxsat mavjud emas');
        }
        return parent::beforeAction($action);
    }
    public function actionIndex()
    {
        $new = new Reestr();
        $user=Uni::$app->getUser()->getIdentity();
        $current = Lang::getCurrent();

        $data =$new->search(Uni::$app->request->queryParams);
        $data->pagination->pageSize=20;

        $type = TypeActivity::find()->where(['status'=>TypeActivity::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        if ($current->url=="ru") $map = ArrayHelper::map($type,'id','name_ru');
        else $map = ArrayHelper::map($type,'id','name_uz');

        if (Uni::$app->controller->access('ADMIN')){
            $viloyat = Viloyat::find()->where(['status'=>Viloyat::STATUS_ACTIVE])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        }
        if (Uni::$app->controller->access('ADMIN_VIL')){
            $viloyat = Viloyat::find()->where(['status'=>Viloyat::STATUS_ACTIVE, 'id'=>$user->viloyat_id])->orderBy(["name_$current->url"=>SORT_ASC])->all();
        }
        return $this->render('index', ['items'=>$data, 'new'=>$new,  'viloyat'=>$viloyat, 'type'=>$map]);
    }

    public function actionView($id)
    {
    	$model=Reestr::findOne($id);
    	$contra = Contravention::find()->where(['company_id'=>$model->id])->limit(9)->orderBy(['id'=>SORT_DESC])->all();
        $con = new Contravention();
        $ban = new Ban();
        if(!$model){
            throw new NotFoundHttpException;
        }
        $request = \Uni::$app->getRequest();
        if ($request->isPost && $con->load($request->post())) { /* Qoida buzish qo`shadigan bo`lsa*/
//            $file = UploadedFile::getInstance($con,'file');
//            if($file){
////                var_dump($_FILES); die;
//                if(file_exists(Uni::getAlias('@webroot/files/upload/reestr/').$con->file)){
//                    @unlink(Uni::getAlias('@webroot/files/upload/reestr/').$con->file );
//                };
//                $time = time();
//                $file->saveAs('files/upload/reestr/'.$time.'.'.$file->extension);
//                $con->file = '/files/upload/reestr/'.$time.'.'.$file->extension;
//            }
            $this->fileupload = "file";
            $con= $this->loadModel("Contravention");
            $d1 = strtotime($con->date); // переводит из строки в дату
            $con->date = $d1;
//            var_dump($con->date); die;
            if ($con->save()){
                $xabar = Uni::t('app', 'Success');
                return $this->redirect(['view', 'id' => $id]);
            }
        }
        if ($request->isPost && $ban->load($request->post())) { /* bLOKIROVKA QO`SHADIGAN BO`LSA*/
//            $file = UploadedFile::getInstance($ban,'file');
//            if($file){
//                if(file_exists(Uni::getAlias('@webroot').$ban->file)){
//                    @unlink(Uni::getAlias('@webroot').$ban->file );
//                };
//                $time = time();
//                $file->saveAs('files/upload/'.$time.'.'.$file->extension);
//                $ban->file = '/files/upload/'.$time.'.'.$file->extension;
//            }
            $this->fileupload = "file";
            $ban= $this->loadModel("Ban");
            $d1 = strtotime($ban->start_date); // переводит из строки в дату
            $ban->start_date = $d1;
            $d1 = strtotime($ban->end_date); // переводит из строки в дату
            $ban->end_date = $d1;
            if ($ban->end_date < $ban->start_date) {
                $xabar = Uni::t('app', 'Incorrect date');
                return $this->render('view',['model'=>$model, 'con'=>$con, 'ban'=>$ban, 'contra'=>$contra, 'xabar'=>$xabar]);
            }
            $ban->status = 1;
            if ($ban->save()){
                $xabar = Uni::t('app', 'Success');
                return $this->redirect(['view', 'id' => $id]);
            }
        }

    	return $this->render('view',['model'=>$model, 'con'=>$con, 'ban'=>$ban, 'contra'=>$contra]);
    }

    public function actionDownload($id){
        $item = Contravention::findOne($id);
        return Uni::$app->response->sendFile(Uni::getAlias('@webroot').$item->file);
    }

    public function actionSave(){
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $model = new Reestr();
        parse_str($_POST['data'],$data);
        if ($model->load($data)) {
            $model->{'status'} = 1;
            if ($model->save()) {
                return ['status' => 'success'];
            } else {
                return ['status'=>'error'];
            }
        }
    }



    public function actionStatus($id){
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $direction = Reestr::findOne($id);
        if (!empty($direction)){
            if($direction->status == 0){
                $direction->status = 1;
            }
            else{
                $direction->status = 0;
            }
            if($direction->save()){
                return ['status' => 'statusChanged'];
            }
            return ['status' => 'statusUnchanged'];
        }
        else return ['status' => 'statusUnchanged'];
    }

    public function actionDelete($id)
    {
        $model = Reestr::findOne($id);
        if (!empty($model)){
            $model->status = 9;
            $model->save(false);
            Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            return ['status'=>'success'];
        }
        else return ['status'=>'error'];
    }


    public function actionEdit($id){
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $model = Reestr::findOne($id);
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

    public function actionListcity()
    {
        $id = $_GET['id'];
//        $tuman = Vkviloyat::find()->where(['status'=>Vkviloyat::STATUS_ACTIVE, 'vaksina_id'=>$id])->one();
        $prixod = Tuman::find()->where(['viloyat_id'=>$id,'status'=>Tuman::STATUS_ACTIVE])->all();
        if (!empty($prixod)){
            foreach ($prixod as $item){
                echo "<option value='".$item->id."'>".$item->name."</option>";
            }
        }
        else echo "<option>".Uni::t("app", "Choose city")."</option>";
    }



    /* Type Activity uchun */

    public function actionType()
    {
        $new = new TypeActivity();
        $data = new ActiveDataProvider([
            'query' => TypeActivity::find()->where(['status'=>TypeActivity::STATUS_ACTIVE])->orWhere(['status'=>TypeActivity::STATUS_INACTIVE])->orderBy(["id"=>SORT_DESC])
        ]);
        $data->pagination->pageSize=20;
        if (Uni::$app->request->get('q')){
            $key = Uni::$app->request->get('q');
            $all = new ActiveDataProvider([
                'query' => TypeActivity::find()->where("`vk_typeactivity`.`status`!=9 and (`vk_typeactivity`.`name_ru` like '%" . $key . "%' or `vk_typeactivity`.`name_uz` like '%" . $key . "%')")
            ]);
        }
        else $all = false;
        return $this->render('type', ['items'=>$data, "new"=>$new, 'query'=>$all]);
    }

    public function actionTsave(){
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $model = new TypeActivity();
        parse_str($_POST['data'],$data);
        if ($model->load($data)) {
//            return ['status' => $model->{'count'}];
//            $d1 = strtotime($model->{'prixod_date'}); // переводит из строки в дату
//            $model->{'prixod_date'} = $d1+25000;
            $model->{'status'} = 1;

            if ($model->save()) {
                return ['status' => 'success'];
            } else {
                return ['status'=>'error'];
            }
        }
    }

    public function actionChangestatus($id){
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $direction = TypeActivity::findOne($id);
        if (!empty($direction)){
            if($direction->status == 0){
                $direction->status = 1;
            }
            else{
                $direction->status = 0;
            }
            if($direction->save()){
                return ['status' => 'statusChanged'];
            }
            return ['status' => 'statusUnchanged'];
        }
        else return ['status' => 'statusUnchanged'];
    }

    public function actionDel($id)
    {
        $model = TypeActivity::findOne($id);
        if (!empty($model)){
            $model->status = 9;
            $model->save(false);
            Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            return ['status'=>'success'];
        }
        else return ['status'=>'error'];
    }

    public function actionTview()
    {
        $id = $_GET['id'];
        $view = TypeActivity::findOne($id);
        if (!empty($view)){
            \Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            return [
                'name_ru'=>$view->name_ru,
                'name_uz'=>$view->name_uz,
            ];
        }
        else return "error";
    }

    public function actionEdittype($id){
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $model = TypeActivity::findOne($id);
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

}
