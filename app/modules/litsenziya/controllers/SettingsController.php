<?php

namespace app\modules\users\controllers;


use app\components\Controller;
use app\models\Company;
use app\models\Contracts;
use app\models\ContractTemplates;
use app\models\Documents;
use app\models\DocumentsType;
use app\models\Invoice;
use app\models\Proxy;
use Uni;
use uni\data\ActiveDataProvider;
use uni\ui\Html;
use uni\web\NotFoundHttpException;
use uni\web\Response;


class SettingsController extends Controller
{
    public $cm="users";
    public $body_class='';
    
    public function actionIndex()
	{
         $data = new ActiveDataProvider([
            'query' => ContractTemplates::find()
        ]);
        return $this->render('index', [
            'data'=>$data
        ]);
	}
    public function actionTemplate($id)
    {
        $model=ContractTemplates::findOne(['id'=>$id]);

       return $this->render('template',['model'=> $model]);
	}
	public function actionTemplateview($id)
	{
		$model=ContractTemplates::findOne(['id'=>$id]);
		if($model) {
			echo $model->content;exit;
		}
		else throw new Exception("Error Processing Request", 1);
	}
	public function actionEdit($id)
	{
        $model = ContractTemplates::findOne($id);
        if(Uni::$app->request->isPost){
            // var_dump(Uni::$app->request->post());exit;
            if($model->load(Uni::$app->request->post()) ){
                if($model->save()){
                    $model = ContractTemplates::find()->all();
                    return $this->redirect($this->to('users/settings/index'));
                }
            }
        }
		return $this->render('edit',['model'=> $model]);
	}
    public function actionDelete($id)
    {
    	 $model = ContractTemplates::find()->where(['uni_contract_templates.id'=>$id])->one();
    	// var_dump($model);exit;
    	$model->delete();

    	$model = ContractTemplates::find()->all();
    	return $this->render('index',['model'=> $model]);
    }
    public function actionActive($id)
    {
        $model = ContractTemplates::findOne($id);

        if($model->status == 1){
            $model->status = 0;
        }
        else $model->status = 1;
        $model->save();
        return $this->redirect($this->to('users/settings/index'));
    }
}
	
