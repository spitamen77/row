<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 12.06.2017
 * Time: 14:03
 */

namespace app\modules\page\controllers;


use app\components\Controller;
use uni\db\Query;
use app\components\manager\Url;
use app\models\Feedback;
use app\models\Kasb;
use app\models\Video;
use app\models\Course;
use app\models\MyCourses;
use app\models\WachedVideo;
use Uni;


class VideoController extends Controller
{
    public $block="users";
    public $layout = '/kasb';
    public $private = false;
    public function actionIndex(){
        
        $mostviews = Video::find()->where(['status'=>1])->limit(6)->orderBy(['view' => SORT_DESC])->all();
        $trendkasbl = Kasb::find()->where(['status'=>1])->all();
        
        $subKasb = (new Query())->select('title')->from('kasb');
        $trendkasblar = $subQuery = (new Query())->select('COUNT(*) as n, kasb.title as title, kasb.create_date as sana, kasb.image as img')->from('kasb_student')->leftJoin('kasb_courses as kasb', 'kasb.id = kasb_student.kasb_id')->where(['kasb_student.status'=>1])->groupBy('kasb.id')->orderBy(['n'=>SORT_DESC])->all();
        $trendkursl = Course::find()->where(['status'=>1])->all();
        //var_dump(@unserialize($trendkasblar[0]['img'])[0]);exit;
        //var_dump($trendkasblar);exit;
        //var_dump(KasbStudent::find()->all());exit;
        //var_dump($mostviews);exit;
        return $this->render('index',[
            'mostviews'=>$mostviews,
            'trendkasbl'=>$trendkasbl,
            'trendkursl' => $trendkursl,
        ]);
    }

    public function actionContact()
    {
       return $this->render('contact');
    }
    public function actionView($id)
    {
        
        $video = Video::findOne(['id'=>$id]);
        //echo $video->view."<br>";
        $video->addView();

        if(!Uni::$app->getUser()->isGuest&&Uni::$app->access('STD')){
            $isview = WachedVideo::findOne(['video_id'=>$id,'user_id'=>Uni::$app->getUser()->getId()]);
            if(!$isview){
                $newRec = new WachedVideo();
                $newRec->video_id = $id;
                //$model = Video::findOne();
                //$model->course->id;
                $newRec->course_id = $video->course->id;
                // var_dump($newRec);exit;
                if(!$newRec->save()) return "saqlamadi!!";
            }
            MyCourses::addMyCourses($id);
        }
        $trendkasblar = $subQuery = (new Query())->select('COUNT(*) as n,kasb.id as id, kasb.created_date as created_date, kasb.title')->from('kasb_student')->leftJoin('kasb', 'kasb.id = kasb_student.kasb_id')->where(['kasb_student.status'=>1])->groupBy('kasb_id')->orderBy(['n'=>SORT_DESC])->all();

        $mostviews = Video::find()->where(['status'=>1])->limit(5)->orderBy(['view' => SORT_DESC])->all();
        //var_dump(Video::countVideoComment($id));exit;
        //Video::addview($id);   
        //var_dump($video->user->avatar);exit;
        return $this->render('view',['video'=>$video,'mostviews'=>$mostviews,'trendkasblar'=>$trendkasblar]);
    }
    public function actionList($id)
    {
        $videos = Video::find()->where(['status'=>1, 'course_id'=>$id])->all();
        $vcount = Video::find()->where(['status'=>1, 'course_id'=>$id])->count();
        $course = Course::findOne(['id'=>$id]);
        return $this->render('list',['videos'=>$videos,'course'=>$course,'vc'=>$vcount]);
    }
    public function actionSave()
    {
        Uni::$app->response->format = \uni\web\Response::FORMAT_JSON;
        $model = new Feedback();
        parse_str($_POST['data'],$data);
        if ($model->load($data)) {
            if ($model->save()) {
                return ['status'=>'success'];
            } else {
            }
        }
        return ['error'=>'ok','message'=>$model->errors];
    }


    public function actionCreate(){
            $model=new DocumentsType();
        if (Uni::$app->request->post('save')) {
            $fields = Uni::$app->request->post('Field') ? : [];
            $result = [];

            foreach ($fields as $field) {
                $temp = json_decode($field);

                if ($temp === null && json_last_error() !== JSON_ERROR_NONE ||
                    empty($temp->name) ||
                    empty($temp->title) ||
                    empty($temp->type) ||
                    !($temp->name = trim($temp->name)) ||
                    !($temp->title = trim($temp->title)) ||
                    !array_key_exists($temp->type, DocumentsType::$fieldTypes)
                ) {
                    continue;
                }
                $options = '';
                if ($temp->type == 'select' || $temp->type == 'checkbox') {
                    if (empty($temp->options) || !($temp->options = trim($temp->options))) {
                        continue;
                    }
                    $options = [];
                    foreach (explode(',', $temp->options) as $option) {
                        $options[] = trim($option);
                    }
                }

                $result[] = [
                    'name' => \uni\helpers\Inflector::slug($temp->name),
                    'title' => $temp->title,
                    'type' => $temp->type,
                    'options' => $options
                ];
            }

            $model->fields = $result;

            if ($model->save()) {
                $this->flash('success', Uni::t('app', 'Category updated'));
            } else {
                $this->flash('error', Uni::t('app', 'Update error. {0}', $model->formatErrors()));
            }
            return $this->refresh();
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
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