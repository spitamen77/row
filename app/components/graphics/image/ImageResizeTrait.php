<?php

namespace app\components\graphics\image;

trait ImageResizeTrait{


    /**
     * Трансформирует передаваемое изображение так, чтобы оно занимало заданную область
     * и возвращает результат в виде ресурса изображения
     *
     * @param resource $srcIm Ресурс изображения
     * @param integer $resWidth Ширина заполняемой области
     * @param integer $resHeight Высота заполняемой области
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
     * Трансформирует передаваемое изображение так, чтобы оно умещалось по центру в
     * заданную область и возвращает результат в виде ресурса изображения
     *
     * @param resource $srcIm Ресурс изображения
     * @param integer $resWidth Ширина заполняемой области
     * @param integer $resHeight Высота заполняемой области
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