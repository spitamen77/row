<?php
namespace app\components;
use app\components\manager\Url;
use app\models\forms\LoginForm;
use app\models\Notification;
use app\models\OnlineUser;
use app\models\Groups;
use app\models\GroupsUsers;
use Uni;
use uni\filters\AccessControl;
use uni\filters\VerbFilter;
use uni\helpers\ArrayHelper;
use uni\web\Cookie;
use uni\web\ErrorAction;
use uni\web\NotFoundHttpException;
use uni\web\UploadedFile;
use uni\web\View;

abstract  class Controller extends \uni\web\Controller
{
    public $layout="/core";
    public $error="/error";
    public $cm="home";
    public $historyLabel="Your history";
    public $fileupload=false;
    public $messages=[];
    public $block="top";
    public $companies=[];
    public $top=false;
    public $body_class="";
    public $private=true;
    public function behaviors()
    {
        if($this->private){
            return [
                'access' => [
                    'class' => AccessControl::className(),

                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['login'],
                            'roles' => ['?'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['logout'],
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
//                    'logout' => ['post'],
                    ],
                ],
            ];
        }else{
            return [];
        }

    }

    public function flash($type, $message)
    {
        Uni::$app->getSession()->setFlash($type=='error'?'danger':$type, $message);
    }
    public function to($url){
        return "/".Model::getLang()."/".$url;
    }
    public function back()
    {
        return $this->redirect(Uni::$app->request->referrer);
    }
    public function afterAction($action,$result){
        if(!empty($this->messages)){
            foreach($this->messages as $key=>$v){
                Uni::$app->session->setFlash($key."_".$v["type"],$v['message']);
            }
        }
        return parent::afterAction($action,$result);
    }
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'uni\captcha\CaptchaAction',
                'fixedVerifyCode' => UNI_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function beforeAction($action){
        if (isset($_GET['notific'])){
            $model = Notification::find()->where(['status'=>1, 'id'=>$_GET['notific']])->one();
            if ($model){
                $model->status = 0;
                $model->save(false);
            }
        }
        Uni::$app->view->on(View::EVENT_BEGIN_BODY, function () {
            $this->fillBreadcrumbs();
        });
        if($action instanceof ErrorAction) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return parent::beforeAction($action);
    }
    public function fillBreadcrumbs(){
        $breadcrumbs = [];

        $module=Uni::$app->controller->module->id;
        $controller=Uni::$app->controller->id;
        $action=Uni::$app->controller->action->id;
        if($module){
            $label = $this->getModuleName($module);
            $breadcrumbs[] = (Url::to($this->route)  == Url::to($module)) ? $label : [
                'label' => $label,
                'url' => [Url::to($module)],
            ];
        }
        if($controller!="default"&&$controller!="site"){
            $label =Uni::t("app",ucfirst($controller));
            $breadcrumbs[] = (Url::to($this->route)  == Url::to($module."/".$controller)) ? $label : [
                'label' => $label,
                'url' => [ Url::to($module."/".$controller)],
            ];}
        if($action!='index'){
            $label =Uni::t("app",ucfirst($action));
            $breadcrumbs[] = (Url::to($this->route) == Url::to($module."/".$controller."/".$action)) ? $label : [
                'label' => $label,
                'url' => [ Url::to($module."/".$controller."/".$action)],
            ];
        }
        $this->mergeBreadCrumbs($breadcrumbs);
    }
    protected function getModuleName($id){
        switch($id){
            case "hr":
                return Uni::t("app","Human Resource");
            case"edoc":
                return Uni::t("app","E-doc");
            case"cpanel":
                return "Панель управления";
            case"admin":
                return "Панель управления";
            case"techsupport":
                return "Тех-поддержка";
        }
    }
    protected function mergeBreadcrumbs($breadcrumbs)
    {
        $existingBreadcrumbs = ArrayHelper::getValue($this->view->params, 'breadcrumbs', []);
        $this->view->params['breadcrumbs'] = array_merge($breadcrumbs, $existingBreadcrumbs);
    }
    public function actionIndex()
    {
        $this->autorization();
        $this->layout="frontend";
        return $this->render('index');
    }

    public function loadModel($modelname, $id="id",$data=false){
        $smes=false;
        $oldfile="";
        $class="\\app\\models\\".$modelname;
         //var_dump(Uni::$app->request->post());exit;
        if(\Uni::$app->request->post($modelname)||($data!==false&&isset($data[$modelname]))){


            if (is_numeric($id)) $model = $class::findOne($id);
            else $model = new $class();
            if($data!=false){
                if ($id && isset($data[$modelname]) && isset($data[$modelname][$id])) {
                    $m = $model->findOne([$id => $data[$modelname][$id]]);
                    if($m)$model=$m;

                }
            }else{
                if ($id && isset($_POST[$modelname]) && isset($_POST[$modelname][$id])) {
                    $m = $model->findOne([$id => $_POST[$modelname][$id]]);
                    if($m)$model=$m;

                }
            }

            if($data)$model->load($data);else{
                $model->load(\Uni::$app->request->post());
            }
             //var_dump($model);exit;
            if ($model->validate()){
                // var_dump($model);exit;
                if ($this->fileupload!=false) {
                    $model->upload_file = UploadedFile::getInstances($model, $this->fileupload);
                    $oldfile = $model->{$this->fileupload};

                    if (is_array($model->upload_file) && !empty($model->upload_file)) {
                        $files=[];
                        foreach ($model->upload_file as $key => $file) {

                            $name=\Uni::$app->security->generateRandomString(20);
                            $month=date("F");
                            $day=date("d");
                            $year=date("Y");
                            $path=\Uni::$app->basePath . '/../files/upload/' .strtolower($modelname).'/'.$year.'/'.$month.'/'.$day;
                            if(!is_dir($path)){
                                $mask = umask(0);
                                mkdir($path, 0777,true);
                                umask($mask);
                            }
                            if ($file->saveAs($path.'/'. $name . '.' . $file->extension)) {
                                $files []= addslashes('/files/upload/'.strtolower($modelname).'/'.$year.'/'.$month.'/'.$day.'/'.$name.'.' . $file->extension);
                            };
                        }
                        if(!empty($files)) $model->{$this->fileupload}=serialize($files);
                        if (!empty($model->{$this->fileupload})) {
                            $arr = $oldfile;
                            if(is_array($arr)) foreach ($arr as $ar) {
                                if ($ar != "") {
                                    if (file_exists(\Uni::$app->basePath . '/../' . $ar)) {
                                        @unlink(\Uni::$app->basePath . '/../' . $ar);
                                    }
                                }
                            }
                        }else{
                            $model->{$this->fileupload}=$oldfile;
                            $model->upload_file = null;}
                        if( $model->validate()){
                            $smes=true;
                            $model->save();
                            //Uni::$app->session->setFlash('success', "Information is saved!");
                        };
                        return $model;
                    }else{
                        $model->{$this->fileupload}=$oldfile;
                        $model->save();
                        //Uni::$app->session->setFlash("warning", "You don t add any files to document!");
                    }
                }
            } else {
                //Uni::$app->session->setFlash('danger', "You fill not valid information!");
            }
            $model->save();//var_dump($model);
            if(!$smes)   //Uni::$app->session->setFlash('success', "Information is saved!");
            return $model;
        }
        return false;
    }
    public function access($rule){
        $userid=Uni::$app->user->getId();
        //  echo $userid;
        $group=Groups::findOne(["groupp"=>$rule]);
        if(!$group)return false;
        $per=GroupsUsers::findOne(["group_id"=>$group->id,"user_id"=>$userid]);
        if(!$per) return false; else return true;
    }
    public function saveToHistory(){
        $current=[];
        $current["action"]=Uni::$app->request->getAbsoluteUrl();
        $current["label"]=$this->historyLabel;
        $history=Uni::$app->request->getCookies()->get("history");
        $cookie=new Cookie();
        if($history){$history=unserialize($history); $history=array_unique(array_merge($history,[$current]),SORT_REGULAR);}
        else $history=[$current];
        $cookie->name="history";
        $cookie->value=serialize($history);
        Uni::$app->response->cookies->add($cookie);
    }
    public function autorization(){
        $model = new LoginForm();
        if ($model->load(Uni::$app->request->post()) && $model->login()) {

            return $this->subdomainRedirect("","my",200);

        } else {

            return false;
        }
    }
    public function subdomainRedirect($url, $subdomain = 'www', $terminate = true, $statusCode = 302) {
        preg_match("/^(?<protocol>(http|https):\/\/)(((?<subdomain>[a-z]+)\.)*)((.*\.)*(?<domain>.+\.[a-z]+))$/", Uni::$app->request->hostInfo, $matches);

        if ($url== '/') {
            $url = '/' . $url;
        }

        $url = $matches['protocol'] . $subdomain . '.' . $matches['domain'] . $url;
        $this->redirect($url, $terminate, $statusCode);
    }
    public function formatResponse($success = '', $back = true)
    {
        if(Uni::$app->request->isAjax){
            Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
            if($this->error){
                return ['result' => 'error', 'error' => $this->error];
            } else {
                $response = ['result' => 'success'];
                if($success) {
                    if(is_array($success)){
                        $response = array_merge(['result' => 'success'], $success);
                    } else {
                        $response = array_merge(['result' => 'success'], ['message' => $success]);
                    }
                }
                return $response;
            }
        }
        else{
            if($this->error){
                $this->flash('error', $this->error);
            } else {
                if(is_array($success) && isset($success['message'])){
                    $this->flash('success', $success['message']);
                }
                elseif(is_string($success)){
                    $this->flash('success', $success);
                }
            }
            return $back ? $this->back() : $this->refresh();
        }
    }

}
