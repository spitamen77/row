<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 21.11.2018 10:53
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

namespace app\modules\settings\controllers;


use uni\web\Controller;
use Uni;
use app\models\Configuration;
use app\models\Groups;
use app\models\Modules;
use app\models\UserModel;
class DefaultController extends Controller
{
//    public $layout="/settings";
//    public $private=false;
    public $block="/left";
    public $cm="settings";
    public $layout="/settings";
    public function actionIndex()
    {
        return $this->render('index');
    }

}