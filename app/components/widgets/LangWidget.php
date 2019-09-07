<?php
/**
 * Created by PhpStorm.
 * User: Rashidov
 * Date: 27.03.2015
 * Time: 12:02
 */

namespace app\components\widgets;


use app\models\Lang;

class LangWidget extends \uni\ui\Widget
{
    public function init(){}

    public function run() {
        return $this->render('lang/view', [
            'current' => Lang::getCurrent(),
            'langs' => Lang::find()->where('id != :current_id', [':current_id' => Lang::getCurrent()->id])->all(),
        ]);
    }
}