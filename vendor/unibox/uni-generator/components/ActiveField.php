<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\generator\components;

use uni\generator\Generator;
use uni\helpers\Json;

/**
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class ActiveField extends \uni\widgets\ActiveField
{
    /**
     * @var Generator
     */
    public $model;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $stickyAttributes = $this->model->stickyAttributes();
        if (in_array($this->attribute, $stickyAttributes)) {
            $this->sticky();
        }
        $hints = $this->model->hints();
        if (isset($hints[$this->attribute])) {
            $this->hint($hints[$this->attribute]);
        }
        $autoCompleteData = $this->model->autoCompleteData();
        if (isset($autoCompleteData[$this->attribute])) {
            if (is_callable($autoCompleteData[$this->attribute])) {
                $this->autoComplete(call_user_func($autoCompleteData[$this->attribute]));
            } else {
                $this->autoComplete($autoCompleteData[$this->attribute]);
            }
        }
    }

    /**
     * Makes field remember its value between page reloads
     * @return static the field object itself
     */
    public function sticky()
    {
        $this->options['class'] .= ' sticky';

        return $this;
    }

    /**
     * Makes field auto completable
     * @param  array  $data auto complete data (array of callables or scalars)
     * @return static the field object itself
     */
    public function autoComplete($data)
    {
        static $counter = 0;
        $this->inputOptions['class'] .= ' typeahead-' . (++$counter);
        foreach ($data as &$item) {
            $item = ['word' => $item];
        }
        $this->form->getView()->registerJs("uni.generator.autocomplete($counter, " . Json::encode($data) . ");");

        return $this;
    }
}
