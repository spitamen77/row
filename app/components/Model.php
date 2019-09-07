<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 07.06.2017
 * Time: 9:42
 */

namespace app\components;

use app\models\Lang;
use Uni;
use uni\web\UploadedFile;

abstract class Model extends \uni\db\ActiveRecord {
    public $upload_file=false;
    public $pic=null;
    public $notgen=[];
    protected $file_src="";
    public function getLocal(){
        $lang= Lang::getCurrent();
        return $lang->url;
    }
    //public abstract function getDropDownProp($prop);
    public static  function getLang(){
        $lang= Lang::getCurrent();
        return $lang->url;
    }
    public function beforeSave($insert){
        if($insert && $this->hasAttribute("created"))$this->created=time();
        if($this->hasProperty("updated"))$this->updated=time();
        return parent::beforeSave($insert);
    }

    public function getResizeImage($w,$h=false){
        if(isset($this->image)){
            $arr=explode(".",$this->image);
            $c=count($arr);
            if($c==2){
                if(!$h)$h=$w;
                return $arr[0].$w."x".$h.".".$arr[1];
            }
        }
    }
    public function uploadFile() {
        $image = UploadedFile::getInstance($this, 'upload_file');
        if (empty($image)) {
            return false;
        }
        $this->pic = Uni::$app->security->generateRandomString(). '.' . $image->extension;
        return $image;
    }
    public function getUploadedFile($modelname) {
        // return a default image placeholder if your source avatar is not found
        $pic = isset($this->pic) ? $this->pic : 'default.png';
        return Uni::$app->params['fileUploadUrl'] .$modelname."/". $pic;
    }
    public  function fio($f, $i, $o){
        $i = ucfirst(substr(trim($i), 0,2));
        $o = ucfirst(substr(trim($o), 0,2));
        $string = ucfirst(trim($f)).' '.$i.'.'.$o;
        return  $string;
    }

    public  function changeIcon($ext){
        switch(strtolower($ext)){
            case "pdf":
                $str = 'icon-f-office-pdf';
                break;

            case "doc":
                $str = 'icon-f-office-doc';
                break;

            case "docx":
                $str = 'icon-f-office-doc';
                break;

            case "xls":
                $str = 'icon-f-office-xls';
                break;

            case "xlsx":
                $str = 'icon-f-office-xls';
                break;

            case "ppt":
                $str = 'icon-f-office-ppt';
                break;

            case "pptx":
                $str = 'icon-f-office-ppt';
                break;

            case "jpg":
                $str = 'icon-f-office-jpg';
                break;

            case "jpeg":
                $str = 'icon-f-office-jpg';
                break;

            case "tif":
                $str = 'icon-f-office-ttf';
                break;

            case "tiff":
                $str = 'icon-f-office-ttf';
                break;

            case "zip":
                $str = 'icon-f-office-zip';
                break;

            case "rar":
                $str = 'icon-f-office-rar';
                break;

            case "rtf":
                $str = 'icon-f-office-rtf';
                break;

            case "txt":
                $str = 'icon-f-office-txt';
                break;
            default:
                $str = '';
                break;
        }

        return strtolower($str);
    }
    public function getExtension($filename) {
        $parse = explode('.', $filename);
        return count($parse)>0 ? end($parse) : '';
    }
    public function extractPattern($pattern){
        if($pattern && is_string($pattern)){
            $pattern = array_filter(explode(';',$pattern));
            $pattern = array_map(function($v){
                return preg_replace('/#_/i','',$v);
            },$pattern);
            return $pattern;
        }
        return $pattern;
    }
    public function zipPattern($items){
        $res="";

        foreach ($items as $item) {
            $res.="#_".$item.";";
        }
        return $res;
    }
    public function getSelectVal($field){
        return;
    }
    public function getFileWithIcons(){
        $str = 'Not added';
        $var="files";
        if($this->upload_file){
            $var=$this->upload_file;
        }
        if($this->{$var} == null){
            $str .= '<span class="label label-default">-</span>';
        }else{
            $arr=null;
            $arr = @unserialize(stripslashes($this->{$var}));
            $str = '';
            if(is_array($arr) && count($arr)>0){
                foreach($arr as $tr) {
                    $str .= '<a href="/'.$tr.'"  data-pjax=false class="btn btn-sm" target="_blank"><i class="fa '.$this->changeIcon($this->getExtension($tr)).'"></i></a><br>';
                }
            }else{
                $str= '<span class="label label-default">-</span>';
            }
        }
        return $str;
    }
}