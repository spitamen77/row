<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 06.06.2017
 * Time: 21:01
 */

namespace app\modules\users\controllers;
use app\components\Mail;
use app\components\manager\Url;
use app\components\sms\SmsGateway;
use app\components\Model;
use app\models\forms\LoginForm;
use app\models\UserModel;
use Uni;
use app\components\Controller;
use uni\web\NotFoundHttpException;
use uni\web\Response;
use uni\web\UploadedFile;

class AuthController extends Controller
{
    public $private = false;
    public $fileupload=false;
    public function actionLogout(){
        Uni::$app->user->logout();

        return $this->goHome();
    }
    public function actionJoin(){
    $this->layout='/login';

    return $this->render('join');
    }
    public function actionLock(){
        $this->layout="/login";

        $model = new LoginForm();

        if(isset(Uni::$app->user->identity)){
            $model->login=Uni::$app->user->identity->login;
        }

        if ($model->load(Uni::$app->request->post()) && $model->login()) {

            return $this->goHome();
        } else {
            return $this->render("lock",["model"=>$model]);
        }

    }
    public function actionLogin(){
        $this->layout="/login";
        if (!\Uni::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Uni::$app->request->post()) && $model->login()) {
            if(Uni::$app->controller->access('ADMIN')){
                return $this->redirect(Url::to('users/default/dashboard'));
            }
            if(Uni::$app->controller->access('TECH')){
                return $this->redirect(Url::to('users/course/main'));
            }
            if(Uni::$app->controller->access('STD')){
                return $this->redirect(Url::to('users/course/search'));
            }
            return $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    public function actionRegister(){
       //Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        if(Uni::$app->request->isPost){
            $data=[];


            if(Uni::$app->request->isPost){
                $res=$this->loadModel("UserModel");

                if($res&&empty($res->getErrors())){
                   $res->setPassword($res->password);
                    if($res->save()){
                        $this->flash("success","Registratsyadan muvofaqqiyatli o'tdingiz!");
                           $r= Mail::send($res->email,'Akkount aktivatsiya qilish','//mail/activate.php',['user'=>$res]);
                           $this->redirect(Url::to('users/auth/success'));
                    };
                    return ['status'=>'success','user'=>$res->id];
                } else {
                    //echo "error";exit;
                    return $res->getErrors();
                }
            }
        }
    }
    public function loadModel($modelname, $id="id",$data=false){
        $smes=false;
        $oldfile="";
        $class="\\app\\models\\".$modelname;
        // var_dump($_POST);
        if(\Uni::$app->request->post($modelname)||($data!==false&&isset($data[$modelname]))){
            $model = new $class();
            if($data!=false){
                if ($id && isset($data[$modelname]) && isset($data[$modelname][$id])) {
                    $m = $model->findOne([$id => $data[$modelname][$id]]);
                    if($m)$model=$m;

                }
            }else{
                if ($id && isset($_POST[$modelname]) && isset($_POST[$modelname][$id])) {
                    $m = $model->findOne([$id => $_POST[$modelname][$id]]);
                    if($m)$model=$m;

                }
            }

            if($data)$model->load($data);else{
                $model->load(\Uni::$app->request->post());
            }
            // var_dump($model);exit;
            if ($model->validate()){
                // var_dump($model);exit;
                if ($this->fileupload!=false) {
                    $model->upload_file = UploadedFile::getInstances($model, $this->fileupload);
                    $oldfile = $model->{$this->fileupload};
                    if (is_array($model->upload_file) && !empty($model->upload_file)) {
                        $files=[];
                        foreach ($model->upload_file as $key => $file) {
                            $name=\Uni::$app->security->generateRandomString(20);
                            $month=date("F");
                            $day=date("d");
                            $year=date("Y");
                            $path=\Uni::$app->basePath . '/files/upload/' .strtolower($modelname).'/'.$year.'/'.$month.'/'.$day;
                            if(!is_dir($path)){
                                $mask = umask(0);
                                mkdir($path, 0777,true);
                                umask($mask);
                            }
                            if ($file->saveAs($path.'/'. $name . '.' . $file->extension)) {
                                $files []= addslashes('files/upload/'.strtolower($modelname).'/'.$year.'/'.$month.'/'.$day.'/'.$name.'.' . $file->extension);
                            };
                        }
                        if(!empty($files)) $model->{$this->fileupload}=serialize($files);
                        if (!empty($model->{$this->fileupload})) {
                            $arr = unserialize($oldfile);
                            if(is_array($arr)) foreach ($arr as $ar) {
                                if ($ar != "") {
                                    if (file_exists(\Uni::$app->basePath . '' . $ar)) {
                                        @unlink(\Uni::$app->basePath . '' . $ar);
                                    }
                                }
                            }
                        }else{
                            $model->{$this->fileupload}=$oldfile;
                            $model->upload_file = null;}
                        if( $model->validate()){
                            $smes=true;
                            $model->save();
                            Uni::$app->session->setFlash('success', "Information is saved!");
                        };
                        return $model;
                    }else{
                        $model->{$this->fileupload}=$oldfile;
                        $model->save();
                        Uni::$app->session->setFlash('warning', "You don't add any files to document!");
                    }
                }
            } else {
                //Uni::$app->session->setFlash('danger', "You fill not valid information!");
            }
            $model->save();//var_dump($model);
            if(!$smes)   Uni::$app->session->setFlash('success', "Information is saved!");
            return $model;
        }
        return false;
    }
    public function flash($type, $message)
    {
        Uni::$app->getSession()->setFlash($type=='error'?'danger':$type, $message);
    }
    public function to($url){
        return "/".Model::getLang()."/".$url;
    }
    public function actionActivation(){
        $this->layout='/kasb';
        if(isset($_GET['token'])){
            $token=$_GET['token'];
            $user=UserModel::findOne(['salt'=>$token]);
            if($user&&!$user->status){
                $user->status=1;
                $user->save();
                return $this->render('activated');
            }else{
                return $this->render('notvalid');
            }
        }else{
            throw new NotFoundHttpException();
        }
    }
    public function actionSuccess(){
        $this->layout="/kasb";
        return $this->render('success');
    }




}