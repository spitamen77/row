<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\validators;

/**
 * DefaultValueValidator sets the attribute to be the specified default value.
 *
 * DefaultValueValidator is not really a validator. It is provided mainly to allow
 * specifying attribute default values when they are empty.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class DefaultValueValidator extends Validator
{
    /**
     * @var mixed the default value or an anonymous function that returns the default value which will
     * be assigned to the attributes being validated if they are empty. The signature of the anonymous function
     * should be as follows,
     *
     * ```php
     * function($model, $attribute) {
     *     // compute value
     *     return $value;
     * }
     * ```
     */
    public $value;
    /**
     * @var boolean this property is overwritten to be false so that this validator will
     * be applied when the value being validated is empty.
     */
    public $skipOnEmpty = false;


    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        if ($this->isEmpty($model->$attribute)) {
            if ($this->value instanceof \Closure) {
                $model->$attribute = call_user_func($this->value, $model, $attribute);
            } else {
                $model->$attribute = $this->value;
            }
        }
    }
}
