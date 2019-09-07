<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 12.06.2017
 * Time: 14:03
 */

namespace app\modules\settings\controllers;

use app\components\manager\Url;
use app\models\UserModel;
use Uni;
use app\components\Controller;
use app\models\VkViloyat; 
use app\models\VkTuman; 
use app\models\VkUchastka;
use app\models\Lang;
// use uni\helpers\ArrayHelper;
// use uni\db\Query;

class VkuchastkaController extends Controller
{
    public $cm="vkuchastka";

    public function actionSave()
    {
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $model = new Vkuchastka();
        parse_str($_POST['data'],$data);

        if ($model->load($data)) {
            $model->{'status'} = 1;
            if ($model->save()) {
                return ['status' => 'success'];
            } else {
                return ['status'=>'error'];
            }
        }
        return ['error'=>'ok','message'=>$model->errors];
    }
    
}