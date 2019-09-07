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
use app\models\Prixod;
use app\models\UserPassword;
use Uni;
use app\components\Controller;
use uni\web\NotFoundHttpException;
use uni\web\Response;
use uni\web\UploadedFile;
use uni\data\ActiveDataProvider;
use uni\helpers\ArrayHelper;

class AuthController extends Controller
{
    public $private = false;
    public $fileupload=false;
    public function beforeAction($action){
        if($this->action->id=='forgot'){
            $this->enableCsrfValidation=false;
        }
       return  parent::beforeAction($action);
    }
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
        if (Uni::$app->user->isGuest) {
            $model = new LoginForm();
            if ($model->load(Uni::$app->request->post()) && $model->login()) {
                
                //return $this->render('users/default/index');
                return $this->goHome();

            } else {
                return $this->render('login', [
                    'model' => $model,
                ]);
            }
        }else{
            return $this->goHome();
            //return $this->redirect(Url::to('users/default/index'));
        }
    }
    public function actionRegister(){
       Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
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
                        Uni::$app->session->setFlash('warning', "You don\'t add any files to document!");
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

    public function actionForgot()
    {
        $model = new UserModel();
        if(Uni::$app->request->post()){
            $user = UserModel::find()->where(['email'=>Uni::$app->request->post("femail")])->one();
            if (!empty($user)){
                $subject = Uni::t('app', 'Password reset on the site vet.simplex.uz');
                $user_token= UserModel::generatePasswordToken();
                $user->password_reset_token = $user_token;
//                print_r($user_token); die;
                $user->save();
                $user_reset = new UserPassword();
                $user_reset->password_reset_token = $user_token;
                $user_reset->status = 1;
                $user_reset->user_id = $user->id;
                $user_reset->save();

                $res= Mail::send(
                    $user->email,
                    $subject,
                    '//mail/resetpassword',
                    [
                        'model' => $user,
                        'link' => Url::to('users/auth/setforgotpass?token='.$user_token)
                    ]
                );
                $this->layout='/login';
                return $this->render('reset');
            }
            else {
                $this->layout='/forgot';
                return $this->render('forgot',['model'=>$model]);
            }
            // var_dump($request['UserSecurity']['email']);exit;
        }
        $this->layout='/forgot';
        return $this->render('forgot',['model'=>$model]);
    }

    public function actionSetforgotpass()
    {
        if (!Uni::$app->user->isGuest) {
            return $this->redirect("/users/profile");
        }
        $token = $_GET['token'];
//        print_r($token); die;
        $user=UserModel::findOne(['password_reset_token'=>$token, 'status' => 1]);
        $user2=UserPassword::findOne(['password_reset_token'=>$token, 'status' => 1]);
        if (!empty($user) && !empty($user2)) {
            $s = "abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ";
            $g = substr ($s, rand(0, strlen($s)) , 2);
            $newpassword = $g.rand(100001,999999);

            $user->setPassword($newpassword);
            $user->password_reset_token=null;
            if ($user->save()) {
                $user2->password=$newpassword;
                $user2->password_reset_token=null;
                $user2->status = 0;
                $user2->save();
                $xabar = Uni::t('app', 'You changed your password');
                $res= Mail::send(
                    $user->email,
                    $xabar,
                    '//mail/activatesuccess',
                    [
                        'model' => $user,
                        'newpass'=>$newpassword,
                        'link' => Url::to('users/auth/login')
                    ]
                );
                $this->layout='/login';
                return $this->render('join'); //bu o`zgaradi...
            } else {
                var_dump($user->getErrors());
                exit;
            }
        }
        else {
            $this->layout='/login';
            return $this->render('lock');
        }
    }


}