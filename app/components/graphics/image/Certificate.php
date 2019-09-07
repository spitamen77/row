<?php
namespace app\components\graphics\image;
use Uni;
use app\models\Sertificate;
class Certificate{
    public $course_path;
    public function certificate($id){
        
        $cert = Sertificate::findOne(['id'=>$id]);
        if(!$cert) throw new NotFoundHttpException();
        $this->course_path = Uni::getAlias('@webroot/files/certificates/');
        header('Content-Type: image/png');
        $user = Uni::$app->getUser()->getIdentity();
        $user = $user->lastname." ".$user->username." ".$user->middlename;
        //$user = "Rashidov Nuriddin Narzullayevich";
        $course = $cert->course->title;
        $fan = $cert->subject->title;
        $certnumber = $cert->cer_number;
        $foiz = $cert->natija;
        
        $im = imagecreatefrompng(Uni::getAlias('@webroot/themes/images/Certificate.png'));
        
        $font = Uni::getAlias('@webroot/themes/kasb/fonts/OpenSans-Regular.ttf');
        
        $black = imagecolorallocate($im, 25, 25, 25);

        $fontSize = 55; // Font size is in pixels.
        
        $imageX = imagesx($im);
        $textWidth = imagettfbbox($fontSize, 0,$font, $user);
        $textWidth = $textWidth[0] + $textWidth[2];
        imagettftext($im, $fontSize, 0, ($imageX - $textWidth)/2, 1465, $black, $font, $user);

        $imageX = imagesx($im);
        $textWidth = imagettfbbox($fontSize, 0,$font, $course);
        $textWidth = $textWidth[0] + $textWidth[2];
        imagettftext($im, $fontSize, 0, ($imageX - $textWidth)/2, 1095, $black, $font, $course);
        
        $imageX = imagesx($im);
        $textWidth = imagettfbbox($fontSize, 0,$font, $course);
        $textWidth = $textWidth[0] + $textWidth[2];
        imagettftext($im, $fontSize, 0, ($imageX - $textWidth)/2, 925, $black, $font, $fan);
        
        $imageX = imagesx($im);
        $textWidth = imagettfbbox($fontSize, 0,$font, $course);
        $textWidth = $textWidth[0] + $textWidth[2];
        imagettftext($im, $fontSize, 0, ($imageX - $textWidth)/2 -1035, 825, $black, $font, $certnumber);
        
        $imageX = imagesx($im);
        $textWidth = imagettfbbox($fontSize, 0,$font, $course);
        $textWidth = $textWidth[0] + $textWidth[2];
        imagettftext($im, 75, 0, ($imageX - $textWidth)/2 -710, 1710, $black, $font, $foiz."%");
        $filename = uniqid($certnumber);
        if(imagepng($im,$this->course_path.$filename.".png")){
            $cert->source_file = $filename.".png";
            $cert->save();
        }
        echo imagepng($im);
        imagedestroy($im);
    }
}