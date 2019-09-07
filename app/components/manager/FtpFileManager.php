<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.12.2015
 * Time: 22:22
 */

namespace app\components\manager;


use app\models\Configuration;
use uni\web\UploadedFile;

class FtpFileManager extends UploadedFile
{
    public $status=false;
    public $connection=false;
    public $conf=[];
    public function init(){
        $conf=Configuration::find()->where(["name"=>"ftp"])->one();
        if($conf){

        }
        parent::init();
    }
    public function connect(){
        if($this->status!=false) {
            $this->connection = ftp_connect($this->conf["server"], 21);

            $main_folder = 'docflow';

            $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);


            if ((!$conn_id) || (!$login_result)) {
                echo "Не удалось утсановить соединение с FTP сервером!";
                exit;
            }
        }

    }
    public function close(){

    }
    function getExtension($filename) {
        return preg_match('/\.(.*)$/U', $filename, $matches)? $matches[1]: '';
    }
    public function read(){
        if($this->connection){
            if($_GET["path"]){
        $path="";
        $ext = strtolower($this->getExtension($path));

        switch($ext){
            case "tiff":
                $local_file = '/tmp/incom_tiff.'.$ext;
                if (ftp_get($this->connection, $local_file, $path, FTP_BINARY)) {
                    header('Content-Type: image/tiff');
                    readfile($local_file);
                    echo "Successfully written to $local_file\n";
                    exit;
                } else {
                    echo "There was a problem\n";
                }
                break;
            case "jpg":
                $local_file = '/tmp/incom_jpg.'.$ext;
                if (ftp_get($this->connection, $local_file, $path, FTP_BINARY)) {
                    header('Content-Type: image/jpeg');
                    readfile($local_file);
                    echo "Successfully written to $local_file\n";
                    exit;
                } else {
                    echo "There was a problem\n";
                }
                break;
            case "pdf":
                $local_file = '/tmp/incom_doc.'.$ext;
                if (ftp_get($this->connection, $local_file, $path, FTP_BINARY)) {
                    header('Content-Type: application/pdf');
                    readfile($local_file);
                    echo "Successfully written to $local_file\n";
                    exit;
                } else {
                    echo "There was a problem\n";
                }
                break;

            case "doc" || "docx" || "zip" ||  "rar":
                $local_file = '/tmp/incom_doc.'.$ext;
                if (ftp_get($this->connection, $local_file, $path, FTP_BINARY)) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename='.$local_file);
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($local_file));
                    ob_clean();
                    flush();
                    readfile($local_file);
                    exit;
                } else {
                    echo "There was a problem\n";
                }
                break;
                }

            }else{
            return "<strong>Ошибка:</strong> ID файла не передан!";
        }
        }else{
    return "<strong>Ошибка:</strong> Типа документа не определен!";
    }


        return "<strong>Ошибка:</strong> Типа документа не определен!";
        exit;
    }
    public function saveAs($file, $deleteTempFile = true){
        if(!$this->status){
            return parent::saveAs($file,$deleteTempFile);
        }
    }
    public function saveAsFtp($file,$deleteTempFile = true){

    }
}