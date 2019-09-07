<?php
/**
 * Created by Sublime Text Editor.
 * Author: Sarvar Makhmudjanov
 * Telegram: https://t.me/Beksarvar
 * Web: http://siplex.uz
 * Date: 24.11.2018 12:11
 * Content: "Unibox"
 */

namespace app\modules\api\controllers;


// use uni\web\Controller;
use app\components\Controller;
use Uni;

use app\models\UserModel;
use app\models\HayvonTuri;
use app\models\Hayvon;
use app\models\VaksinaTuri;
use app\models\VkUchastka;
use app\models\Kasal;
use app\models\KasalTuri;
use app\models\VaksinaPerform;
use app\models\DiagnozPerform;
use app\models\HayvonEgasi;
use app\models\HududUchastka;
use app\models\VaksinaAnimal;
use app\models\forms\LoginForm;

use uni\helpers\Url;
class PerformController extends Controller
{

    public $block="/left";
    public $cm="api";
    public $layout="/settings";


    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        if(!$this->access('VET')){
            //throw new ForbiddenHttpException('Sizda bu sahifa uchun ruxsat mavjud emas');
            return ['status' => 'Guest'];
        }
        return parent::beforeAction($action);
    }
    public function actionRegister()
    {
        
        //$this->enableCsrfValidation = false;
        //$headers = getallheaders();
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        
        //return $_POST;
        if (isset($_POST['email'])) {
            //return $_POST;
            if($user=UserModel::findOne(['email'=>$_POST['email']])){
                $_POST['LoginForm']['email'] = $_POST['email'];
                $_POST['LoginForm']['password'] = $_POST['password'];
                $model = new LoginForm();
                if ($model->load(Uni::$app->request->post()) && $model->login() && $user->status==1) {
                    
                    $user->expire_date = time()+30*24*3600;
                    $user->auth_key = Uni::$app->security->generateRandomString(32);
                    //$user->status = 2;
                    $user->mac_adres = $_POST['mac_adres'];
                    $user->auth_reset_key = Uni::$app->security->generateRandomString(32);
                    
                    if($user->save(false)) 
                    return [
                        'status' => ['code' => 0, 'message' => 'Omadli yukanlandi'],
                        // 'result' => (object)[
                        //     'token' => $user->auth_reset_key,
                        //     'expire_date' => $user->expire_date,
                        //     'reset_token' => $user->auth_key
                        // ]
                        'result' => (object) $user 
                    ];
                    else return [
                        'status' => ['code' => 2 , 'message' => 'Foydalanuvchini avtivlashtirshda xatolik mavjud'],
                        'result' => (object) []
                    ];
                }elseif($user->status==2){
                    return [
                        'status' => ['code' => 1, 'message' => 'Foydalanuvchi ruyhatdan utgan'],
                        'result' => (object) []
                    ];

                }else{
                    return [
                        'status' => ['code' => 3, 'message' => 'Foydalanuvchi aktiv emas yoki parol xato'],
                        'result' => (object) []
                    ];
                }
            }else{
                return [
                    'status' => ['code' => 4, 'message' => 'Foydalanuvchi topilmadi'],
                    'result' => (object) []
                ];
            }
        }else{
            $this->Unauthorized();
            return [
                'status' => ['code' => 5, 'message' => 'Malumot jonatishda xatolik mavjud'],
                'result' => (object) []
            ];
        }
        
    }
    public function actionReset()
    {
        //$this->enableCsrfValidation = false;
        $headers = getallheaders();
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        if(isset($headers['AccessToken'])&&$user=UserModel::findOne(['auth_key'=>$headers['AccessToken']])){
            
            if($user && $user->status == 1){
                $user->setPassword($_POST['new_password']);

                $user->expire_date = time()+30*24*3600;
                $user->auth_key = Uni::$app->security->generateRandomString(32);
                $user->auth_reset_key = Uni::$app->security->generateRandomString(32);
                if($user->save(false)){ 
                return [
                    'status' => ['code' => 0, 'message' => 'Omadli yakunlandi'],
                    // 'result' => (object)[
                    //     'token' => $user->auth_reset_key,
                    //     'expire_date' => $user->expire_date,
                    //     'reset_token' => $user->auth_key
                    //     'user' => $user
                    // ] 
                    'result' => (object) $user
                ];
                }else{
                    return [
                        'status' => ['code' => 1, 'message' => 'Foydalanuvchi avtivlashtirshda xatolik mavjud'],
                        'result' => (object) []
                    ];
                } 
                
            }else{
                return [
                    'status' => ['code' => 2, 'message' => "Xavsizlik malumotlari validatsiyadan o'tmadi"],
                    'result' => (object) []
                ];
            }
        }
        $this->Unauthorized();
        return [
            'status' => ['code' => 3, 'message' => "Sessiya eskirdi,qayta avtorizatsiyadan o'ting "],
            'result' => (object) []
        ];
    }
    public function actionLogin()
    {
        $headers = getallheaders();
        if (isset($headers['Token'])) {
            $user = UserModel::findOne(['salt'=>$headers['Token']]);
            //$user->salt = Uni::$app->security->generateRandomString();
        }
    }
    public function actionAdd()
    {
        $headers = getallheaders();
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        //return Uni::$app->request->post();
        if($post=Uni::$app->request->post()&&isset($headers['AccessToken'])&&$user=UserModel::findOne(['auth_key'=>$headers['AccessToken']])){
            $vaksina = new VaksinaPerform();
            //$post['Vaksina']['uchastka_id'] = $user->id;
            //$_POST = $_POST["VaksinaPerform"][$_POST];
            //return $user->id;
            
            $_POST["VaksinaPerform"]["uchastka_id"] = $user->id;
            $_POST["VaksinaPerform"]["vaksina_id"] = $_POST["vaksina_id"];
            $_POST["VaksinaPerform"]["hayvon_turi"] = $_POST["hayvon_turi"];
            // $_POST["VaksinaPerform"]["hayvon_rangi"] = $_POST["hayvon_rangi"];
            $_POST["VaksinaPerform"]["hayvon_yoshi"] = $_POST["hayvon_yoshi"]; 
            $_POST["VaksinaPerform"]["prixod_uchastka_id"] = $_POST["prixod_id"];
            //$_POST["VaksinaPerform"]["hayvon_rasm"] = isset($_POST["hayvon_rasm"])?$_POST["hayvon_rasm"]:false;
            $_POST["VaksinaPerform"]["location_longitude"] = $_POST["location_longitude"];
            $_POST["VaksinaPerform"]["location_latitude"] = $_POST["location_latitude"];
            $_POST["VaksinaPerform"]["hayvon_egasi_turi"] = $_POST["hayvon_egasi_turi"];
            $_POST["VaksinaPerform"]["hayvon_egasi"] = $_POST["hayvon_egasi"];
            $_POST["VaksinaPerform"]["manzil"] = $_POST["manzil"];
            $_POST["VaksinaPerform"]["vaksina_miqdor"] = $_POST["vaksina_miqdor"];
            //return Uni::$app->request->post();
            if ($vaksina->load($_POST)) { 
                if(!empty($_POST['hayvon_rasm'])){
                    // $image = explode(',', substr( $_POST['hayvon_rasm'] , 5 ) , 2);
                    // $image=$image[1];
                    
                    $name=\Uni::$app->security->generateRandomString(20);
                    $month=date("F");
                    $day=date("d");
                    $year=date("Y");
                    $path=\Uni::$app->basePath . '/../files/upload/vaksinaperform/'.$year.'/'.$month.'/'.$day."/";
                    if(!is_dir($path)){
                        $mask = umask(0);
                        mkdir($path, 0777,true);
                        umask($mask);
                    }
                    $path = $path.$name.".png";
                    file_put_contents($path,base64_decode($_POST['hayvon_rasm']));
                    //echo "Successfully Uploaded->>> $timestamp.$temp[1]";
                    $vaksina->hayvon_rasm = $year.'/'.$month.'/'.$day."/".$name.".png";    
                }else{
                    $vaksina->hayvon_rasm = "rasmyoq";
                }
                

                if($vaksina->save(false)){

                    return [
                        'status' => ['code' => 0, 'message' => "Successfully Uploaded"],
                        'result' => (object)[]
                    ];
                }else{
                    return [
                        'status' => ['code' => 1, 'message' => "saqlashda xatolik"],
                        'result' => (object)[]
                    ];
                }
                
            } else {
                return [
                    'status' => ['code' => 2, 'message' => "data not saved"],
                    'result' => (object)[]
                ];
            }
        }else{
            $this->Unauthorized();
            return [
                'status' => ['code' => 3, 'message' => "post kelishida xatolik yoki access token da xatolik mavjud"],
                'result' => (object)[]
            ];
        }
    }
    public function actionDiagnose()
    {
        $headers = getallheaders();
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
//        var_dump($user=UserModel::findOne(['auth_key'=>$headers['AccessToken']])); exit;
        if(\Uni::$app->request->isPost&&isset($headers['AccessToken'])&&$user=UserModel::findOne(['auth_key'=>$headers['AccessToken']])){
            $vaksina = new DiagnozPerform();
            

            $_POST["DiagnozPerform"]["uchastka_id"] = $user->id;
            $_POST["DiagnozPerform"]["kasal_id"] = $_POST["kasal_id"];
            $_POST["DiagnozPerform"]["kasal_daraja"] = $_POST["kasal_daraja"];
            $_POST["DiagnozPerform"]["location_longitude"] = $_POST["location_longitude"];
            //$_POST["DiagnozPerform"]["hayvon_rasm"] = isset($_POST["hayvon_rasm"])?$_POST["hayvon_rasm"]:false;
            $_POST["DiagnozPerform"]["location_latitude"] = $_POST["location_latitude"];
            $_POST["DiagnozPerform"]["xulosa"] = $_POST["xulosa"];
            $_POST["DiagnozPerform"]["manzil"] = $_POST["manzil"];
            //return Uni::$app->request->post();
            if ($vaksina->load($_POST)) {
                if(!empty($_POST['hayvon_rasm'])){
                    // $image = explode(',', substr( $_POST['hayvon_rasm'] , 5 ) , 2);
                    // $image=$image[1];
                    
                    $name=\Uni::$app->security->generateRandomString(20);
                    $month=date("F");
                    $day=date("d");
                    $year=date("Y");
                    $path=\Uni::$app->basePath . '/../files/upload/diagnozperform/'.$year.'/'.$month.'/'.$day."/";
                    if(!is_dir($path)){
                        $mask = umask(0);
                        mkdir($path, 0777,true);
                        umask($mask);
                    }
                    $path = $path.$name.".png";
                    file_put_contents($path,base64_decode($_POST['hayvon_rasm']));
                    //echo "Successfully Uploaded->>> $timestamp.$temp[1]";
                    $vaksina->hayvon_rasm = $year.'/'.$month.'/'.$day."/".$name.".png";    
                }else{
                    $vaksina->hayvon_rasm = "rasmyoq";
                }
                

                if($vaksina->save(false)){
                    return [
                        'status' => ['code' => 0, 'message' => "Successfully Uploaded"],
                        'result' => (object)[]
                    ];
                }else{
                    return [
                        'status' => ['code' => 1, 'message' => "saqlashda xatolik"],
                        'result' => (object)[]
                    ];
                }
                
            } else {
                return [
                    'status' => ['code' => 2, 'message' => "data not saved"],
                    'result' => (object)[]
                ];
            }
        }else{
            $this->Unauthorized();
            return [
                'status' => ['code' => 3, 'message' => "post kelishida xatolik yoki access token da xatolik mavjud"],
                'result' => (object)[]
            ];
        }
    }
    public function actionPrixod(){
        $headers = getallheaders();
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        if(isset($headers['AccessToken'])&&$user=UserModel::findOne(['auth_key'=>$headers['AccessToken']])){
            
            //$response = VkUchastka::find()->select('id, vaksina_id, tum_prixod, nomer, ostatok, status, vaksina_date, vaksina_miqdor')->where(['uchastka_id'=>$user->id])->all();
            $hudud = HududUchastka::find()->where(['uchastka_id'=>$user->per_id])->all();
            $h = [];
            foreach ($hudud as $key => $value) {
                array_push($h, $value->hudud_id);
            }
            //return $h;
            $r = Uni::$app->db->createCommand("SELECT a.id as prixod_id, a.vaksina_miqdor, a.ostatok, a.nomer, a.status, a.vaksina_date, b.id as vaksina_id, b.name_uz, b.name_ru, b.status,  b.vk_turi, u.name_ru as unit_ru, u.name_uz as unit_uz FROM vk_uchastka as a join vk_vaksinatsiya as b on b.id =a.vaksina_id left join vk_unit as u on b.unit_id = u.id where a.uchastka_id in ('".implode("','",$h)."') ORDER BY a.created_at DESC");
            //$r = Uni::$app->db->createCommand("SELECT a.id as prixod_id, a.vaksina_miqdor, a.ostatok, a.nomer, a.status, a.vaksina_date, b.id as vaksina_id, b.name_uz, b.name_ru, b.status, b.mol, b.qoy, b.tovuq, b.mushuk, b.vk_turi, u.name_ru as unit_ru, u.name_uz as unit_uz FROM vk_uchastka as a join vk_vaksinatsiya as b on b.id =a.vaksina_id left join vk_unit as u on b.unit_id = u.id where a.uchastka_id = ".$user->id);
                    $response = $r->queryAll();
            
                    //$response['animals'] = 
            if(count($response)>0){
                for ($i=0; $i<count($response); $i++) {
                    $cnt = VaksinaAnimal::find()->where(['vaksina_id'=>$response[$i]['vaksina_id']])->asArray()->count();
                    $rr=[];
                    foreach (VaksinaAnimal::find()->where(['vaksina_id'=>$response[$i]['vaksina_id']])->all() as $v) {
                           array_push($rr, ['category_id'=>$v->category_id,'amount'=>$v->amount,'max_age'=>$v->max_age,'min_age'=>$v->min_age]);     
                    }
                    // $response[$i]['animals'] = VaksinaAnimal::find()->select('category_id, amount, max_age, min_age')->where(['vaksina_id'=>$response[$i]['vaksina_id']])->asArray()->one();
                    $response[$i]['animals'] = $rr;
                }
                return [
                    'status' => ['code' => 0, 'message' => 'Malumot'],
                    'result' => $response
                ];
            }else{
                return [
                    'status' => ['code' => 1, 'message' => 'Malumot topilmadi'],
                    'result' => []
                ];    
            }
            
                
            
        }else{
            $this->Unauthorized();
            return [
                'status' => ['code' => 3, 'message' => 'AccessToken is invalide'],
                'result' => []
            ];
        }

    }
    public function actionPrixodstatus(){
        $headers = getallheaders();
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        if(isset($headers['AccessToken'])&&$user=UserModel::findOne(['auth_key'=>$headers['AccessToken']])){
            
            if($post = Uni::$app->request->post()){
                $data = VkUchastka::findOne($_POST['id']);
                
                if($post['method']=='accept') $data->status = 1;
                if($post['method']=='deny') $data->status = 2;
                if($data->save(false))
                    return [
                        'status' => ['code' => 0, 'message' => 'Malumot'],
                        'result' => (object)[]
                    ];
                else
                    return [
                        'status' => ['code' => 1, 'message' => 'Malumot saqlanmadi'],
                        'result' => (object)[]
                    ];
            }else{
                return [
                    'status' => ['code' => 2, 'message' => 'Post kelmadi'],
                    'result' => (object)[]
                ];
            }
        }else{
            $this->Unauthorized();
            return [
                'status' => ['code' => 3, 'message' => 'AccessToken is invalide'],
                'result' => (object)[]
            ];
        }

    }
    public function actionPrixodclose(){
        $headers = getallheaders();
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        if(isset($headers['AccessToken'])&&$user=UserModel::findOne(['auth_key'=>$headers['AccessToken']])){
            
            if($post = Uni::$app->request->post()){
                $data = VkUchastka::findOne($_POST['id']);
                $data->close_image = isset($_POST['rasm'])?$_POST['rasm']:"";
                $data->close_xulosa = isset($_POST['xulosa'])?$_POST['xulosa']:"";
                $data->status = 3;
                if(!empty($_POST['rasm'])){
                    
                    $name=\Uni::$app->security->generateRandomString(20);
                    $month=date("F");
                    $day=date("d");
                    $year=date("Y");
                    $path=\Uni::$app->basePath . '/../files/upload/vaksinaclose/'.$year.'/'.$month.'/'.$day."/";
                    if(!is_dir($path)){
                        $mask = umask(0);
                        mkdir($path, 0777,true);
                        umask($mask);
                    }
                    $path = $path.$name.".png";
                    file_put_contents($path,base64_decode($_POST['rasm']));
                    
                    $data->close_image = $year.'/'.$month.'/'.$day."/".$name.".png";    
                }else{
                    $data->close_image = "rasmyoq";
                }
                
                if($data->save(false))
                    return [
                        'status' => ['code' => 0, 'message' => 'Malumot'],
                        'result' => (object)[]
                    ];
                else
                    return [
                        'status' => ['code' => 1, 'message' => 'Malumot saqlanmadi'],
                        'result' => (object)[]
                    ];
            }else{
                return [
                    'status' => ['code' => 2, 'message' => 'Post kelmadi'],
                    'result' => (object)[]
                ];
            }
        }else{
            $this->Unauthorized();
            return [
                'status' => ['code' => 3, 'message' => 'AccessToken is invalide'],
                'result' => (object)[]
            ];
        }
    }
    public function actionIndex(){
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        //echo "salom";
        return ['status'=>'success'];
        
    }
    public function actionSettings(){
        $headers = getallheaders();
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        if(isset($headers['AccessToken'])&&$user=UserModel::findOne(['auth_key'=>$headers['AccessToken']])){
            
            if($post = Uni::$app->request->post()){
                if($post['method']=="hayvon_turi"){
                    $response = HayvonTuri::find()->select('id, name_uz, name_ru, created_date, updated_date')->where(['status'=>HayvonTuri::STATUS_ACTIVE])->all();
                    if(count($response)>0) 
                    return [
                        'status' => ['code' => 0, 'message' => 'Malumot'],
                        'result' => $response
                    ];
                    else
                    return [
                        'status' => ['code' => 0, 'message' => 'Malumot topilmadi'],
                        'result' => []
                    ];
                }
                elseif($post['method']=="hayvon"){
                    $response = Hayvon::find()->select('id, hayvon_turi_id, name_uz, name_ru, created_date, updated_date')->where(['status'=>Hayvon::STATUS_ACTIVE])->all();
                    if(count($response)>0) 
                    return [
                        'status' => ['code' => 0, 'message' => 'Malumot'],
                        'result' => $response
                    ];
                    else
                    return [
                        'status' => ['code' => 0, 'message' => 'Malumot topilmadi'],
                        'result' => []
                    ];
                }
                elseif($post['method']=="hayvon_egasi"){
                    $response = HayvonEgasi::find()->select('id, name_uz, name_ru, created_date, updated_date')->where(['status'=>HayvonEgasi::STATUS_ACTIVE])->all();
                    if(count($response)>0) 
                    return [
                        'status' => ['code' => 0, 'message' => 'Malumot'],
                        'result' => $response
                    ];
                    else
                    return [
                        'status' => ['code' => 0, 'message' => 'Malumot topilmadi'],
                        'result' => []
                    ];
                }
                elseif($post['method']=="vaksina"){
                    //return "aaaaa";
                    //$response = Vaksina::find()->select('id, name_uz, name_ru, created_date, updated_date,vk_turi')->where(['status'=>Vaksina::STATUS_ACTIVE])->all();
                    $r = Uni::$app->db->createCommand("SELECT b.id, b.name_uz, b.name_ru, b.status, b.mol, b.qoy, b.tovuq, b.mushuk, b.vk_turi FROM vk_uchastka as a join vk_vaksinatsiya as b on b.id =a.vaksina_id where a.uchastka_id = ".$user->id." GROUP BY a.vaksina_id ORDER BY a.created_at");
                    $response = $r->queryAll();
                    
                    if(count($response)>0) 
                    return [
                        'status' => ['code' => 0, 'message' => 'Malumot'],
                        'result' => $response
                    ];
                    else
                    return [
                        'status' => ['code' => 0, 'message' => 'Malumot topilmadi'],
                        'result' => []
                    ];
                }
                elseif($post['method']=="vaksina_turi"){
                    $response = VaksinaTuri::find()->select('id, name_uz, name_ru, created_date, updated_date')->where(['status'=>VaksinaTuri::STATUS_ACTIVE])->all();
                    if(count($response)>0) 
                    return [
                        'status' => ['code' => 0, 'message' => 'Malumot'],
                        'result' => $response
                    ];
                    else
                    return [
                        'status' => ['code' => 0, 'message' => 'Malumot topilmadi'],
                        'result' => []
                    ];
                }
                elseif($post['method']=="kasal"){
                    $response = Kasal::find()->select('id, name_uz, name_ru, created_date, updated_date,kasal_id')->where(['status'=>Kasal::STATUS_ACTIVE])->all();
                    if(count($response)>0) 
                    return [
                        'status' => ['code' => 0, 'message' => 'Malumot'],
                        'result' => $response
                    ];
                    else
                    return [
                        'status' => ['code' => 0, 'message' => 'Malumot topilmadi'],
                        'result' => []
                    ];
                }
                elseif($post['method']=="kasal_turi"){
                    $response = KasalTuri::find()->select('id, name_uz, name_ru, created_date, updated_date')->where(['status'=>KasalTuri::STATUS_ACTIVE])->all();
                    if(count($response)>0) 
                    return [
                        'status' => ['code' => 0, 'message' => 'Malumot'],
                        'result' => $response
                    ];
                    else
                    return [
                        'status' => ['code' => 0, 'message' => 'Malumot topilmadi'],
                        'result' => []
                    ];
                }else{
                    return [
                        'status' => ['code' => 2, 'message' => 'Method topilmadi'],
                        'result' => []
                    ];
                }
                
            }else{
                return [
                    'status' => ['code' => 3, 'message' => 'fail'],
                    'result' => []
                ];
            }
        }else{
            $this->Unauthorized();
            return [
                'status' => ['code' => 4, 'message' => 'AccessToken is invalide'],
                'result' => []
            ];
        }
    }
    public function actionHistoryp(){
        $headers = getallheaders();
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        if(isset($headers['AccessToken'])&&$user=UserModel::findOne(['auth_key'=>$headers['AccessToken']])){
            
            if($user->status!=0){
                //$limit = $_POST['limit'];
                //$start = $_POST['start'];
                if(isset($_POST['limit']) && isset($_POST['start']))
                    $data = VaksinaPerform::find()->where(['uchastka_id'=>$user->id])->limit($_POST['limit'])->offset($_POST['start'])->orderBy(['id'=>SORT_DESC])->all();
                else
                    $data = VaksinaPerform::find()->where(['uchastka_id'=>$user->id])->orderBy(['id'=>SORT_DESC])->limit(30)->all();
                
                if(count($data)>0){
                    foreach ($data as $key => $value) {
                        // if($d = file_get_contents(\Uni::$app->basePath . '/../files/upload/vaksinaperform/'.$value->hayvon_rasm)){
                        //     $value->hayvon_rasm = base64_encode($d);    
                        // }
                        $value->hayvon_rasm = Url::base('https') .  '/files/upload/vaksinaperform/'.$value->hayvon_rasm;
                        
                    }
                    return [
                        'status' => ['code' => 0, 'message' => 'Malumot'],
                        'result' => $data
                    ];
                }else{
                    return [
                        'status' => ['code' => 0, 'message' => 'Malumot mavjud emas'],
                        'result' => []
                    ];
                }
            }else{
                return [
                    'status' => ['code' => 2, 'message' => 'User blocked by admin'],
                    'result' => []
                ];
            }
        }else{
            $this->Unauthorized();
            return [
                'status' => ['code' => 401, 'message' => 'AccessToken is invalide'],
                'result' => []
            ];
        }

    }
    public function actionHistoryd(){
        $headers = getallheaders();
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        if(isset($headers['AccessToken'])&&$user=UserModel::findOne(['auth_key'=>$headers['AccessToken']])){
            
            if($user->status!=0){
                if(isset($_POST['limit']) && isset($_POST['start']))
                    $data = DiagnozPerform::find()->where(['uchastka_id'=>$user->id])->limit($_POST['limit'])->offset($_POST['start'])->orderBy(['id'=>SORT_DESC])->all();
                else
                    $data = DiagnozPerform::find()->where(['uchastka_id'=>$user->id])->orderBy(['id'=>SORT_DESC])->limit(30)->all();

                //$data = DiagnozPerform::find()->where(['uchastka_id'=>$user->id])->all();
                
                if(count($data)>0){
                    foreach ($data as $key => $value) {
                        // if($d = file_get_contents(\Uni::$app->basePath . '/../files/upload/diagnozperform/'.$value->hayvon_rasm)){
                        //     $value->hayvon_rasm = base64_encode($d);    
                        // }
                        $value->hayvon_rasm = Url::base('https') . '/files/upload/diagnozperform/'.$value->hayvon_rasm;
                    }
                    return [
                        'status' => ['code' => 0, 'message' => 'Malumot'],
                        'result' => $data
                    ];
                }else{
                    return [
                        'status' => ['code' => 0, 'message' => 'Malumot mavjud emas'],
                        'result' => []
                    ];
                }
            }else{
                return [
                    'status' => ['code' => 2, 'message' => 'User blocked by admin'],
                    'result' => []
                ];
            }
        }else{
            $this->Unauthorized();
            return [
                'status' => ['code' => 3, 'message' => 'AccessToken is invalide'],
                'result' => []
            ];
        }

    }

    public function Unauthorized()
    {
        Uni::$app->response->setStatusCode(401);
    }
}