<?php
/**
 * Created by PhpStorm.
 * User: Rashidov
 * Date: 04.07.2015
 * Time: 9:08
 */

namespace app\modules\hr\controllers;
use app\components\manager\Url;
use app\components\widgets\FormGenerator;
use Uni;
use app\models\SedPersonal;
use app\models\UserModel;
use uni\data\ActiveDataProvider;

class EmployeeController extends \app\components\Controller
{
    public $cm="hr";
    public $bodyclass='e-doc-page hr-page';
    public function beforeAction($action)
    {
        // if($this->action->id!="profile"&&$this->action->id!="calendar"&&!$this->access('HR')){
        //     throw new ForbiddenHttpException('Sizda bu sahifa uchun ruxsat mavjud emas');
        // }
        return parent::beforeAction($action);
    }
    public function actionView($id)
    {
        $employee = SedPersonal::findOne(["per_id" => $id]);
        return $this->render("view", ["model" => $employee]);
    }
    public function actionAdd($item = false)
    {
        $user = Uni::$app->getUser()->identity;
        // $hudud = [];
        // if($this->access('ADMIN')){
        //  $h = \app\models\Uchastka::find()->all();
        // }
        // if($this->access('ADMIN_TUM')){
        //    $h = \app\models\Uchastka::find()->where(['tuman_id'=>$user->tuman_id])->all();
        // } 
        // if($this->access('ADMIN_VIL')){ 
        //     $h = \app\models\Uchastka::find()->where(['viloyat_id'=>$user->viloyat_id])->all();
        // }
        // foreach ($h as $v) {
        //     $hudud[$v->id] = $v->name;
        // }
        if (\Uni::$app->request->isPost) {
            $res = $this->loadModel("SedPersonal");
            $ures = $this->loadModel("UserModel");

            $res->email = $ures->email;
            $res->save(false);

            $ures->per_id = $res->per_id;
            $ures->username = $res->firstname;
            $ures->middlename = $res->middlename;
            $ures->lastname = $res->lastname;
            $ures->viloyat_id = $res->viloyat_id;
            $ures->tuman_id = $res->tuman_id;
            $ures->firstname = $res->firstname;
            $ures->phone = $res->phone;
            $ures->setPassword($ures->password);
            $ures->save(false);
            if(!$ures){
                echo "<pre>";
                var_dump($_POST);exit;
            }
            if ($res) {
                //$ures = $this->loadModel("UserModel");

                return $this->render("continue", ["model" => $res]);
            } else {
                return $this->render("add", ["model" => new SedPersonal(), 'userModel'=>new UserModel()]);
            }
        }
        return $this->render("add", ["model" => new SedPersonal(), 'userModel'=>new UserModel()]);
    }
    public function actionAddnew($item = false)
    {
        $user = Uni::$app->getUser()->identity;
        
        if (\Uni::$app->request->isPost) {
            $res = $this->loadModel("SedPersonal");
            

            if ($res) {
                //$ures = $this->loadModel("UserModel");

                return $this->render("continue", ["model" => $res]);
            } else {
                return $this->render("add_new", ["model" => new SedPersonal(), 'userModel'=>new UserModel()]);
            }
        }
        return $this->render("add_new", ["model" => new SedPersonal(), 'userModel'=>new UserModel()]);
    }
    public function actionEdit($id)
    {
        
        if (\Uni::$app->request->isPost) {
            $model = SedPersonal::findOne($id);
            $userModel = UserModel::findOne(['per_id'=>$id]);
            if(!$userModel) $userModel = new UserModel();


            $model->load(Uni::$app->request->post());
            //$model->save();
            $_POST['UserModel']['per_id'] = $id;
            $userModel->load(Uni::$app->request->post());
            //$userModel->save();
            //if ($res) {
                // return $this->render("continue", ["model" => $res]);
            
            
                return $this->render("edit", ["model" => $model, "userModel"=>$userModel]);
            // } else {
            //     return $this->render("edit", ["model" => SedPersonal::findOne($id), "userModel"=>UserModel::findOne(['per_id'=>$id])]);
            // }
        }
        $userModel = UserModel::findOne(['per_id'=>$id]);
        if(!$userModel) $userModel = new UserModel();
        return $this->render("edit", ["model" => SedPersonal::findOne($id), "userModel"=>$userModel]);
    }
    public function actionList()
    {
        $user = Uni::$app->getUser()->identity;
        $search = new SedPersonal();
        $data = $search->search(\Uni::$app->request->queryParams);
        // if($this->access('ADMIN')){
        //  $query = SedPersonal::find()->where(['status'=>SedPersonal::STATUS_ACTIVE])->orderBy(["per_id"=>SORT_DESC]);
         
        // }
        // if($this->access('ADMIN_TUM')){
        //     $query = SedPersonal::find()->where(['status'=>SedPersonal::STATUS_ACTIVE,'tuman_id'=>$user->personal->tuman_id])->orderBy(["per_id"=>SORT_DESC]);
            
        //     } 
        // if($this->access('ADMIN_VIL')){ 
        //     $query = SedPersonal::find()->where(['status'=>SedPersonal::STATUS_ACTIVE,'viloyat_id'=>$user->personal->viloyat_id])->orderBy(["per_id"=>SORT_DESC]);
            
        //     }
        
        // $data = new ActiveDataProvider([
        //    'query' => $query
        // ]);
        // $data->pagination->pageSize=15;
        return $this->render("list", [
            'data' => $data,
        ]);

    }
    public function actionFired(){
        // $search = new SedPersonal();
        // $provider = $search->searchFired(\Uni::$app->request->queryParams);
        // return $this->render('fired', [
        //     'dataProvider' => $provider,
        //     'search' => $search,
        // ]);
        $user = Uni::$app->getUser()->identity;
        if($this->access('ADMIN')) $query = SedPersonal::find()->where(['status'=>SedPersonal::STATUS_FIRED])->orderBy(["per_id"=>SORT_DESC]);
        if($this->access('ADMIN_TUM')) $query = SedPersonal::find()->where(['status'=>SedPersonal::STATUS_FIRED,'tuman_id'=>$user->tuman_id])->orderBy(["per_id"=>SORT_DESC]);
        if($this->access('ADMIN_VIL')) $query = SedPersonal::find()->where(['status'=>SedPersonal::STATUS_FIRED,'viloyat_id'=>$user->viloyat_id])->orderBy(["per_id"=>SORT_DESC]);

        $data = new ActiveDataProvider([
           'query' => $query
        ]);
        $data->pagination->pageSize=15;
        return $this->render("list", [
            'data' => $data,
        ]);
    }
    public function actionIndex()
    {
        $search = new SedPersonal();
        $provider = $search->search(\Uni::$app->request->queryParams);
        return $this->render('list', [
            'dataProvider' => $provider,
            'search' => $search,
        ]);

    }
    // public function actionEdit($id)
    // {
    //     if (!($per = SedPersonal::findOne(["per_id" => $id]))) throw new NotFoundHttpException();
    //     return $this->getEmployeeForm($item, $per);

    // }
    public function actionProp()
    {
        $form = new FormGenerator(new SedPersonal());
        $view = $form->generate();
        return $this->render($view, ["model" => new SedPersonal()]);
    }
    
    public function actionChangepass(){
        $user = Uni::$app->request->post("user");
        $u = UserModel::findOne(["id" => $user]);
        if ($u) {
            $pass = $_POST["pass"];
            $u->setPassword($pass);
            if ($u->save()) {
                echo 'success';
            } else {
                echo "Password not updated";
            }
        } else {
            echo "User not found!";
        }
    }
    public function actionChangestatus($id){
            $personal=SedPersonal::findOne(['per_id'=>$id]);
        if(!$personal) throw new NotFoundHttpException;
        if($personal->status==1)$personal->status=2;else $personal->status=1;
        if($personal->save(false)){
            echo "ok";

        };

    }
    public function actionDelete($item,$id){
        if($item=="schools"){
           $model= SedGraduatedSchools::findOne(["id"=>$id]);
            if($model){if($model->delete())echo "success";else echo "error";}else{
                echo "error";
            }

        }elseif($item=="act"){
            $model= SedPersonalWorkActivities::findOne(["pwa_id"=>$id]);
            if($model){if($model->delete())echo "success";else echo "error";}else{
                echo "error";
            }
        }elseif($item=="rel"){
            $model= SedPersonRelatives::findOne(["id"=>$id]);
            if($model){if($model->delete())echo "success";else echo "error";}else{
                echo "error";
            }
        }

    }
    public function actionDrop($id){
        $model=SedPersonal::findOne(['per_id'=>$id]);
        if($model){
            $user=UserModel::findOne(['per_id'=>$id]);
            if($user){
                $user->per_id=0;
                $user->save();
            }
            if($model->delete()){
                echo "success";
            }
        }
    }
} 