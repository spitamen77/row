<?php
/**
 * Created by PhpStorm.
 * User: Rashidov
 * Date: 03.07.2015
 * Time: 17:29
 */

namespace app\modules\filemanager\controllers;
use app\models\Personal;
use uni\web\Controller;
use uni\web\NotFoundHttpException;
use app\components\graphics\image\ImageOptimizer;
use uni\web\UploadedFile;

class UploadsController extends Controller {
    public $layout=false;
    public function actionIndex($module,$folder,$file='default.png',$mode="icon",$download=false)
    {
        $optimiser=new ImageOptimizer();
        return $optimiser->makeImage($file,$module,$mode,"jpg");

    }
	 public function actionEdoc($module,$folder,$file,$download=false)
    {
$path=\Uni::$app->getBasePath()."\\files\\upload\\{$module}\\{$folder}\\$file";
  if(!file_exists($path)){
  throw new  NotFoundHttpException("Sorry! File not found");
  }
        $fsize = filesize($path);
        $path_parts = pathinfo($path);
        $ext = strtolower($path_parts["extension"]);

        // Determine Content Type
        switch ($ext) {
            case "pdf": $ctype="application/pdf"; break;
            case "exe": $ctype="application/octet-stream"; break;
            case "zip": $ctype="application/zip"; break;
            case "doc": $ctype="application/msword"; break;
            case "xls": $ctype="application/vnd.ms-excel"; break;
            case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
            case "gif": $ctype="image/gif"; break;
            case "png": $ctype="image/png"; break;
            case "jpeg":
            case "jpg": $ctype="image/jpg"; break;
            default: $ctype="application/force-download";
        }
header("Pragma: public"); // required
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false); // required for certain browsers
        header("Content-Type: $ctype");
        header("Content-Disposition: attachment; filename=\"".basename($path)."\";" );
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".$fsize);
        ob_clean();
        flush();
        readfile( $path );
    }
    public function actionUploadavatar(){
            $id=isset($_GET["per_id"])?$_GET["per_id"]:-1;
        $model=Personal::findOne(["per_id"=>$id]);
        if($model){
            $name=\Uni::$app->security->generateRandomString(20);
            $file = UploadedFile::getInstance($model, 'personal_picture');
            if($file){
                $uploaded = $file->saveAs( \Uni::$app->basePath . '/web/files/upload/hr/avatars/'. $name . '.' . $file->extension );
                if($uploaded){
                    $model->personal_picture=$name . '.' . $file->extension;
                    $model->save();
                }
            }



        }else{
            echo "File not found";
        }
    }
} 