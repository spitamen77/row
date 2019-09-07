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
use app\models\Modules;
use app\models\UserModel;
use app\models\Vaksina;
use app\models\VkUchastka;
use app\models\VaksinaPerform;
use app\components\encoder\Pbkdf2PasswordEncoder;

class PrixodController extends Controller
{

    
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        if(!$this->access('VET')){
            //throw new ForbiddenHttpException('Sizda bu sahifa uchun ruxsat mavjud emas');
            return ['status' => 'Guest'];
        }
        return parent::beforeAction($action);
    }
    
    public function actionSend()
    {
        $headers = getallheaders();
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        //return Uni::$app->request->post();
        if($post=Uni::$app->request->post()&&isset($headers['AccessToken'])&&$user=UserModel::findOne(['auth_key'=>$headers['AccessToken']])){
            
            if(Uni::$app->request->isPost){
                if($vaksina = VaksinaPerform::findOne($_POST['vaksina_id'])){
                    $vaksina->status = $_POST['status'];
                    if(!empty($_POST['real_miqdor'])){
                        $vaksina->real_miqdor = $_POST['real_miqdor'];
                    }else{
                        $vaksina->real_miqdor = $vaksina->vaksina_miqdor;
                    }
                    
                    if(!empty($_POST['tasdiq_rasm'])){
                        
                        $name=\Uni::$app->security->generateRandomString(20);
                        $month=date("F");
                        $day=date("d");
                        $year=date("Y");
                        $path=\Uni::$app->basePath . '/../files/upload/vaksinasend/'.$year.'/'.$month.'/'.$day."/";
                        if(!is_dir($path)){
                            $mask = umask(0);
                            mkdir($path, 0777,true);
                            umask($mask);
                        }
                        $path = $path.$name.".png";
                        file_put_contents($path,base64_decode($_POST['tasdiq_rasm']));
                        //echo "Successfully Uploaded->>> $timestamp.$temp[1]";
                        $vaksina->tasdiq_rasm = 'files/upload/vaksinasend/'.$year.'/'.$month.'/'.$day."/".$name.".png";
                        
                    }else{
                        $vaksina->tasdiq_rasm = "rasmyoq";
                    }
                    if($vaksina->save(false)){
                        return [
                            'status' => ['code' => 0, 'message' => "Successfully Sent"],
                            'result' => (object)[]
                        ];
                    }else{
                        return [
                            'status' => ['code' => 1, 'message' => "saqlashda xatolik"],
                            'result' => (object)[]
                        ];
                    }    
                }else{
                    return [
                        'status' => ['code' => 2, 'message' => "Vasina topilmadi"],
                        'result' => (object)[]
                    ];
                }

            }else{
                return ['status' => ['code' => 3, 'message' => "Post kelmadi yoki post jonatishda xatolik mavjud"],
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

    public function Unauthorized()
    {
        Uni::$app->response->setStatusCode(401);
    }
}