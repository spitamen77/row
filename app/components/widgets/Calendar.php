<?php
namespace app\components\widgets;
use uni\ui\Widget;

class Calendar  extends Widget{
    public $str="";
    public $wrapPanel=true;

    public function run() {
        return $this->render('calendar', [
            'wrap'=>$this->wrapPanel

        ]);
    }
}
