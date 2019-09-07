<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 12/17/18
 * Time: 11:38
 */

namespace app\modules\report\controllers;

use app\models\Lang;
use app\models\Prixod;
use app\models\Vaksina;
use app\models\VkViloyat;
use Uni;
use app\components\Controller;
use uni\data\ActiveDataProvider;
use uni\helpers\ArrayHelper;

class DefaultController extends Controller
{
    public function actionIndex(){
        return $this->render("index");
    }
}