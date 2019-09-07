<?php

namespace app\components\widgets;

class CommonWidgets extends \uni\ui\Widget{

    public static function nestedSelect($data = [],$template = "<option value='{{value}}'>{{text}}</option>"){
        $output = "";
        foreach($data as $key => $items) {
            $output.= "<optgroup label='".$key."'>";
                if (is_array($items)) {
                    foreach ($items as $k => $v) {
                        $output.= "<option value='".$k."'>".$v."</option>";
                    }
                }
            $output.= "</optgroup>";
        }
        return $output;
    }


}