<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 12/14/18
 * Time: 17:13
 */

namespace app\modules\users\controllers;


use app\components\Controller;

class MapController extends Controller
{
    public function actionIndex(){
        return $this->render('index');
    }

}