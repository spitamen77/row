<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\validators;

use Uni;
use uni\base\Component;
use uni\base\NotSupportedException;

/**
 * Validator is the base class for all validators.
 *
 * Child classes should override the [[validateValue()]] and/or [[validateAttribute()]] methods to provide the actual
 * logic of performing data validation. Child classes may also override [[clientValidateAttribute()]]
 * to provide client-side validation support.
 *
 * Validator declares a set of [[builtInValidators|built-in validators] which can
 * be referenced using short names. They are listed as follows:
 *
 * - `boolean`: [[BooleanValidator]]
 * - `captcha`: [[\uni\captcha\CaptchaValidator]]
 * - `compare`: [[CompareValidator]]
 * - `date`: [[DateValidator]]
 * - `default`: [[DefaultValueValidator]]
 * - `double`: [[NumberValidator]]
 * - `each`: [[EachValidator]]
 * - `email`: [[EmailValidator]]
 * - `exist`: [[ExistValidator]]
 * - `file`: [[FileValidator]]
 * - `filter`: [[FilterValidator]]
 * - `image`: [[ImageValidator]]
 * - `in`: [[RangeValidator]]
 * - `integer`: [[NumberValidator]]
 * - `match`: [[RegularExpressionValidator]]
 * - `required`: [[RequiredValidator]]
 * - `safe`: [[SafeValidator]]
 * - `string`: [[StringValidator]]
 * - `trim`: [[FilterValidator]]
 * - `unique`: [[UniqueValidator]]
 * - `url`: [[UrlValidator]]
 * - `ip`: [[IpValidator]]
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class Validator extends Component
{
    /**
     * @var array list of built-in validators (name => class or configuration)
     */
    public static $builtInValidators = [
        'boolean' => 'uni\validators\BooleanValidator',
        'captcha' => 'uni\captcha\CaptchaValidator',
        'compare' => 'uni\validators\CompareValidator',
        'date' => 'uni\validators\DateValidator',
        'default' => 'uni\validators\DefaultValueValidator',
        'double' => 'uni\validators\NumberValidator',
        'each' => 'uni\validators\EachValidator',
        'email' => 'uni\validators\EmailValidator',
        'exist' => 'uni\validators\ExistValidator',
        'file' => 'uni\validators\FileValidator',
        'filter' => 'uni\validators\FilterValidator',
        'image' => 'uni\validators\ImageValidator',
        'in' => 'uni\validators\RangeValidator',
        'integer' => [
            'class' => 'uni\validators\NumberValidator',
            'integerOnly' => true,
        ],
        'match' => 'uni\validators\RegularExpressionValidator',
        'number' => 'uni\validators\NumberValidator',
        'required' => 'uni\validators\RequiredValidator',
        'safe' => 'uni\validators\SafeValidator',
        'string' => 'uni\validators\StringValidator',
        'trim' => [
            'class' => 'uni\validators\FilterValidator',
            'filter' => 'trim',
            'skipOnArray' => true,
        ],
        'unique' => 'uni\validators\UniqueValidator',
        'url' => 'uni\validators\UrlValidator',
        'ip' => 'uni\validators\IpValidator',
    ];
    /**
     * @var array|string attributes to be validated by this validator. For multiple attributes,
     * please specify them as an array; for single attribute, you may use either a string or an array.
     */
    public $attributes = [];
    /**
     * @var string the user-defined error message. It may contain the following placeholders which
     * will be replaced accordingly by the validator:
     *
     * - `{attribute}`: the label of the attribute being validated
     * - `{value}`: the value of the attribute being validated
     *
     * Note that some validators may introduce other properties for error messages used when specific
     * validation conditions are not met. Please refer to individual class API documentation for details
     * about these properties. By convention, this property represents the primary error message
     * used when the most important validation condition is not met.
     */
    public $message;
    /**
     * @var array|string scenarios that the validator can be applied to. For multiple scenarios,
     * please specify them as an array; for single scenario, you may use either a string or an array.
     */
    public $on = [];
    /**
     * @var array|string scenarios that the validator should not be applied to. For multiple scenarios,
     * please specify them as an array; for single scenario, you may use either a string or an array.
     */
    public $except = [];
    /**
     * @var boolean whether this validation rule should be skipped if the attribute being validated
     * already has some validation error according to some previous rules. Defaults to true.
     */
    public $skipOnError = true;
    /**
     * @var boolean whether this validation rule should be skipped if the attribute value
     * is null or an empty string.
     */
    public $skipOnEmpty = true;
    /**
     * @var boolean whether to enable client-side validation for this validator.
     * The actual client-side validation is done via the JavaScript code returned
     * by [[clientValidateAttribute()]]. If that method returns null, even if this property
     * is true, no client-side validation will be done by this validator.
     */
    public $enableClientValidation = true;
    /**
     * @var callable a PHP callable that replaces the default implementation of [[isEmpty()]].
     * If not set, [[isEmpty()]] will be used to check if a value is empty. The signature
     * of the callable should be `function ($value)` which returns a boolean indicating
     * whether the value is empty.
     */
    public $isEmpty;
    /**
     * @var callable a PHP callable whose return value determines whether this validator should be applied.
     * The signature of the callable should be `function ($model, $attribute)`, where `$model` and `$attribute`
     * refer to the model and the attribute currently being validated. The callable should return a boolean value.
     *
     * This property is mainly provided to support conditional validation on the server side.
     * If this property is not set, this validator will be always applied on the server side.
     *
     * The following example will enable the validator only when the country currently selected is USA:
     *
     * ```php
     * function ($model) {
     *     return $model->country == Country::USA;
     * }
     * ```
     *
     * @see whenClient
     */
    public $when;
    /**
     * @var string a JavaScript function name whose return value determines whether this validator should be applied
     * on the client side. The signature of the function should be `function (attribute, value)`, where
     * `attribute` is an object describing the attribute being validated (see [[clientValidateAttribute()]])
     * and `value` the current value of the attribute.
     *
     * This property is mainly provided to support conditional validation on the client side.
     * If this property is not set, this validator will be always applied on the client side.
     *
     * The following example will enable the validator only when the country currently selected is USA:
     *
     * ```php
     * function (attribute, value) {
     *     return $('#country').val() === 'USA';
     * }
     * ```
     *
     * @see when
     */
    public $whenClient;


    /**
     * Creates a validator object.
     * @param mixed $type the validator type. This can be a built-in validator name,
     * a method name of the model class, an anonymous function, or a validator class name.
     * @param \uni\base\Model $model the data model to be validated.
     * @param array|string $attributes list of attributes to be validated. This can be either an array of
     * the attribute names or a string of comma-separated attribute names.
     * @param array $params initial values to be applied to the validator properties
     * @return Validator the validator
     */
    public static function createValidator($type, $model, $attributes, $params = [])
    {
        $params['attributes'] = $attributes;

        if ($type instanceof \Closure || $model->hasMethod($type)) {
            // method-based validator
            $params['class'] = __NAMESPACE__ . '\InlineValidator';
            $params['method'] = $type;
        } else {
            if (isset(static::$builtInValidators[$type])) {
                $type = static::$builtInValidators[$type];
            }
            if (is_array($type)) {
                $params = array_merge($type, $params);
            } else {
                $params['class'] = $type;
            }
        }

        return Uni::createObject($params);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->attributes = (array) $this->attributes;
        $this->on = (array) $this->on;
        $this->except = (array) $this->except;
    }

    /**
     * Validates the specified object.
     * @param \uni\base\Model $model the data model being validated
     * @param array|null $attributes the list of attributes to be validated.
     * Note that if an attribute is not associated with the validator,
     * it will be ignored.
     * If this parameter is null, every attribute listed in [[attributes]] will be validated.
     */
    public function validateAttributes($model, $attributes = null)
    {
        if (is_array($attributes)) {
            $attributes = array_intersect($this->attributes, $attributes);
        } else {
            $attributes = $this->attributes;
        }
        foreach ($attributes as $attribute) {
            $skip = $this->skipOnError && $model->hasErrors($attribute)
                || $this->skipOnEmpty && $this->isEmpty($model->$attribute);
            if (!$skip) {
                if ($this->when === null || call_user_func($this->when, $model, $attribute)) {
                    $this->validateAttribute($model, $attribute);
                }
            }
        }
    }

    /**
     * Validates a single attribute.
     * Child classes must implement this method to provide the actual validation logic.
     * @param \uni\base\Model $model the data model to be validated
     * @param string $attribute the name of the attribute to be validated.
     */
    public function validateAttribute($model, $attribute)
    {
        $result = $this->validateValue($model->$attribute);
        if (!empty($result)) {
            $this->addError($model, $attribute, $result[0], $result[1]);
        }
    }

    /**
     * Validates a given value.
     * You may use this method to validate a value out of the context of a data model.
     * @param mixed $value the data value to be validated.
     * @param string $error the error message to be returned, if the validation fails.
     * @return boolean whether the data is valid.
     */
    public function validate($value, &$error = null)
    {
        $result = $this->validateValue($value);
        if (empty($result)) {
            return true;
        }

        list($message, $params) = $result;
        $params['attribute'] = Uni::t('uni', 'the input value');
        $params['value'] = is_array($value) ? 'array()' : $value;
        $error = Uni::$app->getI18n()->format($message, $params, Uni::$app->language);

        return false;
    }

    /**
     * Validates a value.
     * A validator class can implement this method to support data validation out of the context of a data model.
     * @param mixed $value the data value to be validated.
     * @return array|null the error message and the parameters to be inserted into the error message.
     * Null should be returned if the data is valid.
     * @throws NotSupportedException if the validator does not supporting data validation without a model
     */
    protected function validateValue($value)
    {
        throw new NotSupportedException(get_class($this) . ' does not support validateValue().');
    }

    /**
     * Returns the JavaScript needed for performing client-side validation.
     *
     * You may override this method to return the JavaScript validation code if
     * the validator can support client-side validation.
     *
     * The following JavaScript variables are predefined and can be used in the validation code:
     *
     * - `attribute`: an object describing the the attribute being validated.
     * - `value`: the value being validated.
     * - `messages`: an array used to hold the validation error messages for the attribute.
     * - `deferred`: an array used to hold deferred objects for asynchronous validation
     * - `$form`: a jQuery object containing the form element
     *
     * The `attribute` object contains the following properties:
     * - `id`: a unique ID identifying the attribute (e.g. "loginform-username") in the form
     * - `name`: attribute name or expression (e.g. "[0]content" for tabular input)
     * - `container`: the jQuery selector of the container of the input field
     * - `input`: the jQuery selector of the input field under the context of the form
     * - `error`: the jQuery selector of the error tag under the context of the container
     * - `status`: status of the input field, 0: empty, not entered before, 1: validated, 2: pending validation, 3: validating
     *
     * @param \uni\base\Model $model the data model being validated
     * @param string $attribute the name of the attribute to be validated.
     * @param \uni\web\View $view the view object that is going to be used to render views or view files
     * containing a model form with this validator applied.
     * @return string the client-side validation script. Null if the validator does not support
     * client-side validation.
     * @see \uni\widgets\Form::enableClientValidation
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        return null;
    }

    /**
     * Returns a value indicating whether the validator is active for the given scenario and attribute.
     *
     * A validator is active if
     *
     * - the validator's `on` property is empty, or
     * - the validator's `on` property contains the specified scenario
     *
     * @param string $scenario scenario name
     * @return boolean whether the validator applies to the specified scenario.
     */
    public function isActive($scenario)
    {
        return !in_array($scenario, $this->except, true) && (empty($this->on) || in_array($scenario, $this->on, true));
    }

    /**
     * Adds an error about the specified attribute to the model object.
     * This is a helper method that performs message selection and internationalization.
     * @param \uni\base\Model $model the data model being validated
     * @param string $attribute the attribute being validated
     * @param string $message the error message
     * @param array $params values for the placeholders in the error message
     */
    public function addError($model, $attribute, $message, $params = [])
    {
        $value = $model->$attribute;
        $params['attribute'] = $model->getAttributeLabel($attribute);
        $params['value'] = is_array($value) ? 'array()' : $value;
        $model->addError($attribute, Uni::$app->getI18n()->format($message, $params, Uni::$app->language));
    }

    /**
     * Checks if the given value is empty.
     * A value is considered empty if it is null, an empty array, or an empty string.
     * Note that this method is different from PHP empty(). It will return false when the value is 0.
     * @param mixed $value the value to be checked
     * @return boolean whether the value is empty
     */
    public function isEmpty($value)
    {
        if ($this->isEmpty !== null) {
            return call_user_func($this->isEmpty, $value);
        } else {
            return $value === null || $value === [] || $value === '';
        }
    }
}
