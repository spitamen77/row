<?php
namespace app\components\graphics\image;
use Uni;
class ImageOptimizer{

    private $filePreviewWidth;
    private $uploadsPath;
    private $parameters = array();
    public $mimeTypes = array(
        'image/gif' => 'gif',
        'image/jpeg' => 'jpg',
        'image/png' => 'png'
    );

    public $paths = array(
        'crm' => 'crm/products',
        'hr' => 'hr/avatars',
        'edoc' => 'edoc/files',
        'business' => 'business/company',
    );

    public $typeConstants = array(
        IMAGETYPE_GIF => 'gif',
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG => 'png'
    );

    public function __construct()
    {
        $this->uploadsPath = Uni::getAlias("@rootPath").'/files/upload/';
        $this->filePreviewWidth = 277;
        $this->parameters = Uni::$app->params["images"];
    }



    public function makeImage($src,$module,$mode,$format)
    {
        $image = $this->uploadsPath.$this->paths[$module].'/'.$src;
        if (empty($src) || !file_exists($image)) {
            $img_r = imagecreatefrompng($this->uploadsPath.$this->paths[$module]."/default.png");
        } else {

        switch (exif_imagetype($image)) {
            case IMAGETYPE_JPEG:
                $img_r = imagecreatefromjpeg($image);
                break;

            case IMAGETYPE_PNG:
                $img_r = imagecreatefrompng($image);
                break;

            case IMAGETYPE_GIF:
                $img_r = imagecreatefromgif($image);
                break;

            default:
                $img_r = imagecreatefromjpeg($image);
                break;
        }
        }

        $dstW = $this->parameters[$module][$mode]['w'];
        $dstH = $this->parameters[$module][$mode]['h'];
        return $this->makeResponse($img_r, $dstW, $dstH, $format);
    }

    public function getName($name){
        $name = substr($name,0,strstr($name,'.')-1);
        return $name;
    }

    public function createTmpImage($src){
        $image = $this->uploadsPath.'/'.$src;
        $ext = $this->typeConstants[exif_imagetype($image)];
        $imagePath = $this->uploadsPath."tmp/".$this->getName($src).".png";
        switch ($ext) {
            case "jpg":
            case "jpeg":
                $img_r = imagecreatefromjpeg($image);
                break;

            case "png":
                $img_r = imagecreatefrompng($image);
                break;

            case "gif":
                $img_r = imagecreatefromgif($image);
                break;

            default:
                $img_r = imagecreatefromjpeg($image);
                break;
        }
        imagepng($img_r,$imagePath,1);
        return $imagePath;
    }

    public function cropImage($src,$x,$y,$w,$h){
        $image = $this->uploadsPath.'/'.$src;
        $ext = $this->typeConstants[exif_imagetype($image)];
        switch ($ext) {
            case "jpg":
            case "jpeg":
                $img_r = imagecreatefromjpeg($image);
                break;

            case "png":
                $img_r = imagecreatefrompng($image);
                break;

            case "gif":
                $img_r = imagecreatefromgif($image);
                break;

            default:
                $img_r = imagecreatefromjpeg($image);
                break;
        }

        $dst_r = ImageCreateTrueColor($w,$h);

        imagecopyresampled($dst_r,$img_r,0,0,$x,$y,
            $w,$h,$w,$h);
        imagejpeg($dst_r,$image,92);
    }


    public function fileAction($path)
    {
        $pathParts = pathinfo($path);
        $ext  = strtolower($pathParts['extension']);

        $fileRootPath = $this->uploadsPath . "/" . $pathParts['basename'];
        if (!file_exists($fileRootPath)) {
            $srcIm = imagecreatefromjpeg(realpath(__DIR__ . "/../Resources/public/images/defaultimage.jpg"));
        } else {
            switch ($ext) {
                case "jpg":
                case "jpeg":
                    $srcIm = imagecreatefromjpeg(realpath($fileRootPath));
                    break;

                case "png":
                    $srcIm = imagecreatefrompng(realpath($fileRootPath));
                    break;

                case "gif":
                    $srcIm = imagecreatefromgif(realpath($fileRootPath));
                    break;

                default:
                    $srcIm = imagecreatefromjpeg(realpath(__DIR__ . "/../Resources/public/images/defaultimage.jpg"));
                    break;
            }
        }

        $dstW = $this->filePreviewWidth;
        $dstH = $dstW * imagesy($srcIm) / imagesx($srcIm);

        return $this->makeResponse($srcIm, $dstW, $dstH);
    }

    private function makeResponse($srcIm, $dstW, $dstH, $format = "jpg") {
        $dstIm = $this->fillImage($srcIm, abs((int) $dstW), abs((int) $dstH));
        imagedestroy($srcIm);

        ob_start();
        switch (strtolower($format)) {
            default:
            case 'jpg':
            case 'jpeg':
                imagejpeg($dstIm, null, 92);
                $fileMimeType = 'image/jpeg';
                $fileRef = 'jpg';
                break;

            case 'png':
                imagepng($dstIm);
                $fileMimeType = 'image/png';
                $fileRef = 'png';
                break;

            case 'gif':
                imagegif($dstIm);
                $fileMimeType = 'image/gif';
                $fileRef = 'gif';
                break;
        }
        $img = ob_get_clean();
        imagedestroy($dstIm);

            header('Content-Type: '.$fileMimeType);
            header('Content-Disposition: inline; filename="image.' . $fileRef . '"');
            return $img;
    }

    /**
     * РўСЂР°РЅСЃС„РѕСЂРјРёСЂСѓРµС‚ РїРµСЂРµРґР°РІР°РµРјРѕРµ РёР·РѕР±СЂР°Р¶РµРЅРёРµ С‚Р°Рє, С‡С‚РѕР±С‹ РѕРЅРѕ Р·Р°РЅРёРјР°Р»Рѕ Р·Р°РґР°РЅРЅСѓСЋ РѕР±Р»Р°СЃС‚СЊ
     * Рё РІРѕР·РІСЂР°С‰Р°РµС‚ СЂРµР·СѓР»СЊС‚Р°С‚ РІ РІРёРґРµ СЂРµСЃСѓСЂСЃР° РёР·РѕР±СЂР°Р¶РµРЅРёСЏ
     *
     * @param resource $srcIm Р РµСЃСѓСЂСЃ РёР·РѕР±СЂР°Р¶РµРЅРёСЏ
     * @param integer $resWidth РЁРёСЂРёРЅР° Р·Р°РїРѕР»РЅСЏРµРјРѕР№ РѕР±Р»Р°СЃС‚Рё
     * @param integer $resHeight Р’С‹СЃРѕС‚Р° Р·Р°РїРѕР»РЅСЏРµРјРѕР№ РѕР±Р»Р°СЃС‚Рё
     * @return resource
     */
    private function fillImage($srcIm, $resWidth, $resHeight)
    {
        $srcWidth  = imagesx($srcIm);
        $srcHeight = imagesy($srcIm);

        $scaledWidth  = $resHeight * $srcWidth / $srcHeight;

        if ($scaledWidth > $resWidth) {
            $tWidth  = floor($srcHeight * $resWidth / $resHeight);
            $tHeight = $srcHeight;
            $srcX = ($srcWidth - $tWidth) / 2;
            $srcY = 0;
        }
        else {
            $tWidth  = $srcWidth;
            $tHeight = floor($srcWidth * $resHeight / $resWidth);
            $srcX = 0;
            $srcY = ($srcHeight - $tHeight) / 2;
        }

        $resIm = imagecreatetruecolor($resWidth, $resHeight);
        imagefill($resIm, 0, 0, imagecolorallocate($resIm, 255, 255, 255));
        imagecopyresampled($resIm, $srcIm, 0, 0, $srcX, $srcY, $resWidth, $resHeight, $tWidth, $tHeight);

        return $resIm;
    }

    /**
     * РўСЂР°РЅСЃС„РѕСЂРјРёСЂСѓРµС‚ РїРµСЂРµРґР°РІР°РµРјРѕРµ РёР·РѕР±СЂР°Р¶РµРЅРёРµ С‚Р°Рє, С‡С‚РѕР±С‹ РѕРЅРѕ СѓРјРµС‰Р°Р»РѕСЃСЊ РїРѕ С†РµРЅС‚СЂСѓ РІ
     * Р·Р°РґР°РЅРЅСѓСЋ РѕР±Р»Р°СЃС‚СЊ Рё РІРѕР·РІСЂР°С‰Р°РµС‚ СЂРµР·СѓР»СЊС‚Р°С‚ РІ РІРёРґРµ СЂРµСЃСѓСЂСЃР° РёР·РѕР±СЂР°Р¶РµРЅРёСЏ
     *
     * @param resource $srcIm Р РµСЃСѓСЂСЃ РёР·РѕР±СЂР°Р¶РµРЅРёСЏ
     * @param integer $resWidth РЁРёСЂРёРЅР° Р·Р°РїРѕР»РЅСЏРµРјРѕР№ РѕР±Р»Р°СЃС‚Рё
     * @param integer $resHeight Р’С‹СЃРѕС‚Р° Р·Р°РїРѕР»РЅСЏРµРјРѕР№ РѕР±Р»Р°СЃС‚Рё
     * @return resource
     */
    private function fitImage($srcIm, $resWidth, $resHeight)
    {
        $srcWidth = imagesx($srcIm);
        $srcHeight = imagesy($srcIm);

        $tWidth  = $resWidth;
        $tHeight = $resHeight;

        if ($srcWidth >= $resWidth or $srcHeight >= $resHeight) {
            if ($srcWidth > $srcHeight) {
                $tHeight = $srcHeight * $resWidth / $srcWidth;
            }
            if ($srcHeight > $srcWidth) {
                $tWidth = $srcWidth * $resHeight / $srcHeight;
            }
        }
        else {
            if ($srcWidth < $resWidth) {
                $resX = ($resWidth - $srcWidth) / 2;
                $tHeight = $srcHeight;
            }
            if ($tHeight != $srcHeight and $srcHeight < $resHeight) {
                $resY = ($resHeight - $srcHeight) / 2;
                $tWidth = $srcWidth;
            }
        }
        $resIm = imagecreatetruecolor($tWidth, $tHeight);
        imagefill($resIm, 0, 0, imagecolorallocate($resIm, 255, 255, 255));

        if ($srcWidth >= $resWidth or $srcHeight >= $resHeight) {
            imagecopyresampled($resIm, $srcIm, 0, 0, 0, 0, $tWidth, $tHeight, $srcWidth, $srcHeight);
        }
        else {
            imagecopyresampled($resIm, $srcIm, $resX, $resY, 0, 0, $srcWidth, $srcHeight, $srcWidth, $srcHeight);
        }

        return $resIm;
    }

}