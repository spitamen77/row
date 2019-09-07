<?php

namespace app\modules\litsenziya\controllers;


use uni\web\Controller;
use Uni;
class DefaultController extends Controller
{
	public $layout="/litsenziya";
	public $private=false;
	public $block=false;
    public function actionIndex()
    {
        
    	// 
    	// 
    	return $this->render('index');
    }
    public function actionDashboard(){
        return $this->render('dashboard');
    }
    public function actionError(){

    }
    public function actionLicense(){
    	return $this->render('license');
    }
}
