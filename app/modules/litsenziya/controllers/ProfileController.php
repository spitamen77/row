<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 07.06.2017
 * Time: 1:42
 */

namespace app\modules\users\controllers;

use app\components\manager\Url;

use app\models\UserInfo;
use uni\db\Query;
use Uni;
use app\components\Controller;
use app\models\UserModel;
use app\models\Kasb;
use app\models\Video;
use app\models\KasbStudent;
use app\components\widgets\FormGenerator;
use uni\ui\Form;
use uni\web\NotFoundHttpException;
use uni\web\UploadedFile;
class ProfileController extends Controller
{
    public function actionView($id=false){
        if($id){
            $user=UserModel::findOne(['id'=>$id]);
        }else{
            $user=Uni::$app->getUser()->getIdentity();
        }
        return $this->render("view",['user'=>$user]);
    }
    public function actionEdit(){
        $id=Uni::$app->getUser()->getId();
    	$model = UserModel::findOne(['id'=>$id]);
        if(!$model){
            throw new NotFoundHttpException;
        }

        if ($model->load(Uni::$app->request->post())) {
            if(Uni::$app->request->isAjax) {
                Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
                return Form::validate($model);
            }else {
                if ($model->save()) {
                    $this->flash('success', Uni::t('app', 'User profile information updated!'));
                    return $this->redirect(Url::to('users/profile/view/'.$id));
                } else {
                    $this->flash('error', Uni::t('app', 'Create error. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        }
        else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }

    }
    public function actionSave(){
    	 Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        if(Uni::$app->request->isPost){
            $data=[];
            parse_str($_POST['data'], $data);

            if(isset($data["UserModel"])){
                $res=$this->loadModel("UserModel","id",$data);
                if($res&&empty($res->getErrors())){
                    return ['status' => 'success', 'id' => $res->id,'message'=>Uni::t('app','Information saved!')];
                } else {
                    return $res->getErrors();
                }
            }


        }
            else{
                var_dump($data);exit;
            }
        }
    public function actionStudent(){
        $this->layout='/profile';
        $data = new Kasb();
        $mostviews = Video::find()->where(['status'=>1])->limit(5)->orderBy(['view' => SORT_DESC])->all();
        $mostlasts = Video::find()->where(['status'=>1])->all();
        //$trendkasblar = KasbStudent::find()->select('count(*), kasb_id')->where('status=1')->groupBy('kasb_id')->orderBy(['kasb_id'=>SORT_DESC])->all();
        $subKasb = (new Query())->select('title')->from('kasb');
        $trendkasblar = $subQuery = (new Query())->select('COUNT(*) as n, kasb.title')->from('kasb_student')->leftJoin('kasb', 'kasb.id = kasb_student.kasb_id')->where(['kasb_student.status'=>1])->groupBy('kasb_id')->orderBy(['n'=>SORT_DESC])->all();
        //var_dump($trendkasblar);exit;
        //var_dump(KasbStudent::find()->all());exit;
        return $this->render('student',[
            'data'=>$data,
            'mostviews'=>$mostviews,
            'mostlasts'=>$mostlasts,
            'trendkasblar'=> $trendkasblar
        ]);
    }
    public function actionIndex(){
        $this->layout='/profile';
        return $this->render('index');
    }
    public function actionEslatma(){
        $this->layout='/profile';
        return $this->render('eslatma');
    }
    
}