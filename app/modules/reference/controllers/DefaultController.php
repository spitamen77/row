<?php

namespace app\modules\reference\controllers;
use app\models\Groups;
use app\models\GroupsUsers;
use app\models\News;
use app\models\Speciality;
use app\models\Subject;
use app\models\Direction;
use app\models\Test;
use app\models\Answer;
use app\models\Video;
use app\models\Kasb;
use app\models\Attach;
use app\models\Notification;
use Uni;
use app\components\Controller;
use app\models\SourceMessage;
use app\models\UserModel;
use uni\data\ActiveDataProvider;
use uni\web\NotFoundHttpException;


class DefaultController extends Controller
{
    public $cm="reference";
    public $layout="/settings";
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionUsers(){
        $data = new ActiveDataProvider([
            'query' => UserModel::find()
        ]);
        return $this->render('users', [
            'data'=>$data
        ]);
    }
    public function actionTranslation(){
        $query=SourceMessage::find()->joinWith('messages')->orderBy(['id'=>SORT_DESC]);
        if(isset($_GET['q'])){
            $q=$_GET['q'];
            $query->orFilterWhere(['like','message.translation',$q])->orFilterWhere(['like','message',$q]);
        }else{

        }
        $data = new ActiveDataProvider([
            'query' => $query
        ]);
       return $this->render('translation', [
            'data' => $data
        ]);
    }
    public function actionGroups(){
        $data = new ActiveDataProvider([
            'query' => Groups::find()->orderBy(['id'=>SORT_DESC]),
        ]);
        return $this->render('groups', [
            'data' => $data
        ]);
    }
    public function actionNews(){
        $data = new ActiveDataProvider([
            'query' => News::find()->orderBy(['id'=>SORT_DESC]),
        ]);
        return $this->render('news', [
            'data' => $data
        ]);
    }
    public function actionVideo(){
        $data = new ActiveDataProvider([
            'query' => Video::find()
        ]);
        return $this->render('video',['data' => $data]);
    }
    public function actionSpeciality(){
        $this->cm = "speciality";
        $data = new ActiveDataProvider([
            'query' => Speciality::find()
        ]);
        return $this->render('speciality',['data' => $data]);
    }
    public function actionDirection(){
        $this->cm = "direction";
        $data = new ActiveDataProvider([
            'query' => Direction::find()
        ]);
        return $this->render('direction',['data' => $data]);
    }
	public function actionSubject(){
        $this->cm = "subject";
        $data = new ActiveDataProvider([
            'query' => Subject::find()
        ]);
        return $this->render('subject',['data' => $data]);
    }
    public function actionKasb(){
        $this->cm = "kasb";
        $data = new ActiveDataProvider([
            'query' => Kasb::find()
        ]);
        return $this->render('kasb',['data' => $data]);
    }
    public function actionAttach(){
        $this->cm = "attach";
        $data = new ActiveDataProvider([
            'query' => Attach::find()->orderBy('order_number')
        ]);
        return $this->render('attach',['data' => $data]);
    }
    public function actionTest(){
        $this->cm = "test";
        $data = new ActiveDataProvider([
            'query' => Test::find()
        ]);
        return $this->render('test',['data' => $data]);
    }
    public function actionAnswer(){
        $data = new ActiveDataProvider([
            'query' => Answer::find()
        ]);
        return $this->render('answer',['data' => $data]);
    }
    public function actionNotification(){
        $data = new ActiveDataProvider([
            'query' => Notification::find()
        ]);
        return $this->render('notification',['data' => $data]);
    }
    public function actionError(){
        if (($exception = Uni::$app->getErrorHandler()->exception) === null) {
            return '';
        }

        if ($exception instanceof HttpException) {
            $code = $exception->statusCode;
        } else {
            $code = $exception->getCode();
        }
        if ($exception instanceof Exception) {
            $name = $exception->getName();
        } else {
            $name =  Uni::t('app', 'Error');
        }
        $name=Uni::t("app",$name);
        if ($code) {
            $name .= " (#$code)";
        }

        if ($exception instanceof UserException) {
            $message = $exception->getMessage();
        } else {
            $message =  Uni::t('app', 'An internal server error occurred.');
        }

        if (Uni::$app->getRequest()->getIsAjax()) {
            return "$name: $message";
        } else {
            return $this->render("error", [
                'name' => $name,
                'message' => $message,
                'exception' => $exception,
            ]);
        }
    }
}
