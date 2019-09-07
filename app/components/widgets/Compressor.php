<?php
/**
 * Created by PhpStorm.
 * User: Rashidov
 * Date: 25.04.2015
 * Time: 16:00
 */

namespace app\components\widgets;
use uni\base\Widget;

class Compressor extends Widget
{
    /**
     * Starts capturing an output to be cleaned from whitespace characters between HTML tags.
     */
    public function init()
    {
        ob_start();
        ob_implicit_flush(false);
    }

    /**
     * Marks the end of content to be cleaned from whitespace characters between HTML tags.
     * Stops capturing an output and echoes cleaned result.
     */
    public function run()
    {
   if(!UNI_ENV_DEV){
        $output=ob_get_clean();
        $output = preg_replace('/<!--.*?-->/ms', '', $output);
        $output = preg_replace('/\s{3,}/', '', $output);
        echo trim(preg_replace('/(\r?\n)/', '', $output));
        }

    }
}
