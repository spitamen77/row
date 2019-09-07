<?php

namespace app\modules\cpanel\controllers;

use app\components\Controller;
use app\components\widgets\FormGenerator;

use app\models\Company;
use app\models\Configuration;
use app\models\Groups;
use app\models\Modules;
use app\models\UserModel;
use Uni;
use uni\web\ForbiddenHttpException;
use uni\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public $cm="cpanel";
    public $layout="/core";
    public function beforeAction($action)
    {
        if(!$this->access('ADMIN')){
            throw new ForbiddenHttpException('Sizda bu sahifa uchun ruxsat mavjud emas');
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionModules(){
        $modules=Modules::find()->orderBy(["sort"=>SORT_ASC])->all();
        return $this->render("modules",["modules"=>$modules]);
    }

    public function actionGroups($sort=false,$id=false){
        if($sort=="edit"&&is_numeric($id)){
           $group=Groups::findOne(["id"=>$id]);
            if($group){
                $view=(new FormGenerator($group))->generate();
                $grform= $this->renderPartial($view,["model"=>$group]);
                $mdform=$this->renderPartial("modulelist",['modules'=>Modules::find()->all(),"group"=>$group]);
                return $this->render("groupedit",["groups"=>$grform,'modules'=>$mdform]);

            }else{
                throw new NotFoundHttpException();

            }
        }
        $modules=Groups::find()->where(['not', ['active'=>9]])->orderBy(["created"=>SORT_ASC])->all();
        return $this->render("groups",["groups"=>$modules]);
    }
    public function actionConfig(){
       $ftp=Configuration::find()->where(['name'=>'ftp'])->one();
       $theme=Configuration::find()->where(['name'=>'theme'])->one();
        if($ftp)$ftp->value=unserialize($ftp->value);
               return $this->render("config",['ftp'=>$ftp,'theme'=>$theme]);
    }
    public function actionUsers(){
        $search = new UserModel();
        $provider = $search->search(\Uni::$app->request->queryParams);
        return $this->render("list", [
            'dataProvider' => $provider,
            'search' => $search,
        ]);
    }
    public function actionSaveconfiguration(){
       if(isset($_POST['data'])) {parse_str($_POST['data'],$temp);$_POST['data']=$temp;}

        if(\Uni::$app->request->isPost){
            if(isset($_POST["action"])&&$_POST["action"]=="savetheme"){
                $data["Configuration"]["value"]=$_POST["theme"];
                $data["Configuration"]["name"]="theme";
                $conf=new Configuration();
                if(Configuration::find()->where(["name"=>"theme"])->one()){
                    $conf=Configuration::find()->where(["name"=>"theme"])->one();
                }
                $conf->load($data);
                if($conf->save())echo "success";else var_dump($conf);exit;
            }elseif(isset($_POST['data']["action"])&&$_POST['data']["action"]=="saveftp"){

                $data["Configuration"]["value"]=serialize($_POST['data']);
                $data["Configuration"]["name"]="ftp";
                $conf=new Configuration();
                if(Configuration::find()->where(["name"=>"ftp"])->one()){
                    $conf=Configuration::find()->where(["name"=>"ftp"])->one();
                }
                $conf->load($data);
                if($conf->save())echo "success";else var_dump($conf);exit;
            }

        }elseif(isset($_POST['data']["action"])&&$_POST['data']["action"]=="savecompany"){

                $data["Company"]=serialize($_POST['data']);
                $conf=Company::find()->one();
                if(!$conf)$conf=new Company();
                $conf->load($data);
                if($conf->save())echo "success";else var_dump($conf);exit;
            }
        else{
            throw new NotFoundHttpException;
        }
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (!empty($model)){
            $model->active = 9;
//            $model->user_id = Uni::$app->getUser()->getId();
//            $model->updated_at = time();
            $model->save(false);
            Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            return ['status'=>'success'];
        }
        else return ['status'=>'error'];
    }

    public function actionChangestatus($id){
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $direction = $this->findModel($id);
        if (!empty($direction)){
            if($direction->active == 0){
                $direction->active = 1;
            }
            else{
                $direction->active = 0;
            }
//            $direction->user_id = Uni::$app->getUser()->getId();
//            $direction->updated_at = time();
            if($direction->save(false)){
                return ['status' => 'statusChanged'];
            }
            return ['status' => 'statusUnchanged'];
        }
        else return ['status' => 'statusUnchanged'];
    }

    /**
     * Finds the Groups model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Groups the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Groups::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
