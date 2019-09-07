<?php
/**
 * Created by PhpStorm.
 * Author: Sarvar Makhmudjanov
 * Telegram: https://t.me/Beksarvar
 * Web: http://siplex.uz
 * Date: 24.11.2018 12:11
 * Content: "Unibox"
 */

namespace app\modules\api\controllers;


use uni\web\Controller;
use Uni;
use app\models\Configuration;
use app\models\Groups;
use app\models\Modules;
use app\models\UserModel;
class DefaultController extends Controller
{

    public $block="/left";
    public $cm="api";
    public $layout="/settings";
    public function actionPerform()
    {
    	Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
    	
    }

    public function actionError(){

    }

}