<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 02.10.2015
 * Time: 19:00
 */

namespace app\modules\cpanel\controllers;

use app\components\Controller;
use app\components\manager\Url;
use app\components\widgets\FormGenerator;
use app\models\Groups;
use app\models\GroupsUsers;
use app\models\SedPersonal;
use app\models\Tuman;
use app\models\Uchastka;
use app\models\Viloyat;
use Uni;

use app\models\UserModel;
use uni\helpers\ArrayHelper;
use uni\helpers\Json;
use uni\web\ForbiddenHttpException;
use uni\web\NotFoundHttpException;
use uni\data\ActiveDataProvider;

class UsersController  extends Controller
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
    public function actionProfile(){
        $data=[];
        $this->layout=false;
        $data['content']= $this->render("profile");
        return Json::encode($data);
    }
    public function actionView($id=false){
//         $data=[];
//        if(!$id){
//            $search = new UserModel();
//            $data = new ActiveDataProvider([
//                'query' => UserModel::find()->where(['status'=>UserModel::USER_ACTIVE])->orWhere(['status'=>UserModel::USER_BLOCKED])->orderBy(["id"=>SORT_DESC])
//            ]);
//            $data->pagination->pageSize=15;
//            if (Uni::$app->request->get('q')){
//                $key = Uni::$app->request->get('q');
//                $all = new ActiveDataProvider([
//                    'query' => UserModel::find()->where("`uni_user_security`.`status`!=9 and (`uni_user_security`.`username` like '%" . $key . "%' or `uni_user_security`.`lastname` like '%" . $key . "%' or `uni_user_security`.`middlename` like '%" . $key . "%')")
//                ]);
//            }
//            else $all = false;
// //           $provider = $search->search(\Uni::$app->request->queryParams);
//            return $this->render("list", [
//             'dataProvider' => $data,
//             'search' => $search,
//             'query'=>$all
//         ]);
//        }else{
//            $this->layout=false;
//            $data['content']= $this->render("view");
//        }
//         return Json::encode($data);
         $model=UserModel::findOne(['id'=>$id]);
        if(!$model) throw new NotFoundHttpException;
        return $this->render('view',['user'=>$model]);
    }
    public function actionEdit($id){
       $u= UserModel::findOne(["id"=>$id]);

       // var_dump($u->sedGroupsUsers);exit;
        if($u){
            $this->historyLabel="Пользователи::".$u->phone;
            $this->saveToHistory();
            return $this->render("useredit",["model"=>$u]);}else{
            throw new NotFoundHttpException();
        }
    }
    public function actionIndex(){
            // echo "<pre>";
            // $u = UserModel::findOne(52);
            // var_dump($u->roles->title);exit;
            $search = new UserModel();
            $provider = $search->search(\Uni::$app->request->queryParams);
            return $this->render("list", [
                'dataProvider' => $provider,
                'search' => $search,
            ]);
    }
    public function actionUpdateworkplace()
    {
        if (\Uni::$app->request->isPost && \Uni::$app->request->post("action")) {
            $action = \Uni::$app->request->post("action");
            if ($action == "changeper") {
                $user = Uni::$app->request->post("user");
//                GroupsUsers::deleteAll(["user_id" => $user]);
                $per = Uni::$app->request->post("pers");
                $u = UserModel::findOne(["id" => $user]);
                if (is_array($per)) {
                    foreach ($per as $p) {
                        $u->role=$p;
                        $u->save(false);
                    }
                }
//                return Json::encode($per);

            } elseif ($action == "changepass") {
                $user = Uni::$app->request->post("user");
                $u = UserModel::findOne(["id" => $user]);
                if ($u) {
                    $pass = $_POST["pass"];
                    $u->setPassword($pass);
                    if ($u->save(false)) {
                        echo 'success';
                    } else {
                        echo "Password not updated";
                    }
                } else {
                    echo "User not found!";
                }
            } elseif ($action == "release") {
                $user = Uni::$app->request->post("user");
                $u = UserModel::findOne(["id" => $user]);
                if ($u) {
                    if ($u->per_id != -1) {
                        $u->per_id = -1;
                        if ($u->save()) {
                            echo "success";
                            Uni::$app->session->setFlash("success", "Рабочего места свободен");
                        }
                    } else {
                        echo "User already released";
                    }
                } else {
                    echo "User not found!";
                }
            } elseif ($action == "setpersonal") {
                $user = Uni::$app->request->post("user");
                $personal = Uni::$app->request->post("personal");
                $u = UserModel::findOne(["id" => $user]);
                if ($u) {

                    $u->per_id = $personal;
                    if ($u->save()) {
                        echo "success";
                        Uni::$app->session->setFlash("success", "Сотрудник рабочего места изменила");
                    } else {
                        echo "User not updated";
                    }
                }else {
                    echo "User not found!";
                }
            }elseif($action=="blockuser"){
                $user = Uni::$app->request->post("user");
                $u = UserModel::findOne(["id" => $user]);
                if($u){
                   if($u->status==1) $u->status=0;else{
                       $u->status=1;
                   }
                   if($u->save(false)){
                       if($u->status==0)Uni::$app->session->setFlash("success", "Пользователь заблокирован");else{
                           Uni::$app->session->setFlash("success", "Пользователь разблокирован");
                       }
                   }else{
                       Uni::$app->session->setFlash("danger", "Рабочего места свободен");
                   };

                }
                }
            }
        return "";
    }
    public function actionRegister(){
        $user=new UserModel();
        $viloyat = Viloyat::find()->where(['status'=>Viloyat::STATUS_ACTIVE])->all();
        if(Uni::$app->language=='ru')$name = 'name_ru';
        else $name = 'name_uz';
        $items = ArrayHelper::map($viloyat,'id',$name);
        $groups = Groups::find()->where(['active'=>1])->all();
        $item_group = ArrayHelper::map($groups,'id','title');
//        if(Uni::$app->request->isPost){
//            $user->load(Uni::$app->request->post());
//            $user->status=1;
////            var_dump($user); die;
//            if($user->validate()){
//                if($user->isNewRecord) $user->setPassword($user->password);
//                $user->save(false);
//                Uni::$app->response->redirect(Url::to('cpanel/users/view/'.$user->id));
//            }
//        }
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
            else {
                return $this->redirect('index');
            }
        }

        return $this->render('add'/*$view*/,["model"=>new SedPersonal(), 'items'=>$items, 'group'=>$item_group, 'userModel'=>$user]);
    }

    public function actionList()
    {
        $id = $_GET['id'];
        $tuman = Tuman::find()->where(['status'=>Tuman::STATUS_ACTIVE, 'viloyat_id'=>$id])->all();
        if (!empty($tuman)){
            //echo "<option>".Uni::t('app', 'Select')."...</option>";
            foreach ($tuman as $item){
                if(Uni::$app->language=='ru')echo "<option value='".$item->id."'>".$item->name_ru."</option>";
                else echo "<option value='".$item->id."'>".$item->name_uz."</option>";
            }
        }
        else echo "<option> - </option>";
    }

    public function actionHududlist()
    {
        $id = $_GET['id'];
        $uchastka = Uchastka::find()->where(['status'=>Uchastka::STATUS_ACTIVE, 'tuman_id'=>$id])->all();
        if (!empty($uchastka)){
            foreach ($uchastka as $item){
                if(Uni::$app->language=='ru')echo "<option value='".$item->id."'>".$item->name_ru."</option>";
                else echo "<option value='".$item->id."'>".$item->name_uz."</option>";
            }
        }
        else echo "<option> - </option>";
    }

    public function actionChangestatus($id){
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $direction = UserModel::findOne($id);
        if (!empty($direction)){
            if($direction->status == 0){
                $direction->status = 1;
            }
            else{
                $direction->status = 0;
            }
            if($direction->save(false)){
                return ['status' => 'statusChanged'];
            }
            return ['status' => $direction->status];
        }
        else return ['status' => 'statusUnchanged'];
    }

    public function actionDelete($id)
    {
        $model = UserModel::findOne($id);
        if (!empty($model)){
            $model->status = 9;
//            $model->user_id = Uni::$app->getUser()->getId();
//            $model->updated_at = time();
            $model->save(false);
            Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            return ['status'=>'success'];
        }
        else return ['status'=>'error'];
    }
    public function actionUchastka($id)
    {
        
    }

}