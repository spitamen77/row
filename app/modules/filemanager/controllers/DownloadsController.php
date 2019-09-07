<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 11.06.2017
 * Time: 11:15
 */

namespace app\modules\filemanager\controllers;

use Uni;
use app\components\Controller;
use app\models\Documents;
use uni\web\NotFoundHttpException;
use uni\web\Response;
use uni\web\UploadedFile;

class DownloadsController extends Controller
{
    public function init()
    {
        $this->enableCsrfValidation=false;
        parent::init();
    }


    public function actionDocuments(){
        $this->fileupload='doc_file';
        Uni::$app->response->format=Response::FORMAT_JSON;;
            $model=new Documents();
            $name=\Uni::$app->security->generateRandomString(20);
            $model->upload_file = UploadedFile::getInstanceByName('files');
            $oldfile=$model->{$this->fileupload};
        if (is_array($model->upload_file) && !empty($model->upload_file)) {
            $files=[];
            foreach ($model->upload_file as $key => $file) {
                $name=\Uni::$app->security->generateRandomString(20);
                $month=date("F");
                $day=date("d");
                $year=date("Y");

                $path=\Uni::getAlias("@rootPath") . '/files/upload/edoc/documents/'.$year.'/'.$month.'/'.$day;
                $dp='/files/upload/edoc/documents/'.$year.'/'.$month.'/'.$day;
                if(!is_dir($path)){
                    $mask = umask(0);
                    mkdir($path, 0777,true);
                    umask($mask);
                }
                if ($file->saveAs($path.'/'. $name . '.' . $file->extension)) {
                    $files []= addslashes('/files/upload/edoc/documents/'.$year.'/'.$month.'/'.$day.'/'.$name.'.' . $file->extension);
                }else{
                    echo $path.'/'. $name . '.' . $file->extension;
                };
            }
            return ['file'=>$dp.'/'.$name.".".$file->extension];
        }else{
            return ['status'=>'error'];
        }
    }
}