<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\behaviors;

use uni\base\InvalidConfigException;
use uni\db\BaseActiveRecord;
use uni\helpers\Inflector;
use uni\validators\UniqueValidator;
use Uni;

/**
 * SluggableBehavior automatically fills the specified attribute with a value that can be used a slug in a URL.
 *
 * To use SluggableBehavior, insert the following code to your ActiveRecord class:
 *
 * ```php
 * use uni\behaviors\SluggableBehavior;
 *
 * public function behaviors()
 * {
 *     return [
 *         [
 *             'class' => SluggableBehavior::className(),
 *             'attribute' => 'title',
 *             // 'slugAttribute' => 'slug',
 *         ],
 *     ];
 * }
 * ```
 *
 * By default, SluggableBehavior will fill the `slug` attribute with a value that can be used a slug in a URL
 * when the associated AR object is being validated. If your attribute name is different, you may configure
 * the [[slugAttribute]] property like the following:
 *
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         [
 *             'class' => SluggableBehavior::className(),
 *             'slugAttribute' => 'alias',
 *         ],
 *     ];
 * }
 * ```
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since alfa version
 */
class SluggableBehavior extends AttributeBehavior
{
    /**
     * @var string the attribute that will receive the slug value
     */
    public $slugAttribute = 'slug';
    /**
     * @var string|array the attribute or list of attributes whose value will be converted into a slug
     */
    public $attribute;
    /**
     * @var string|callable the value that will be used as a slug. This can be an anonymous function
     * or an arbitrary value. If the former, the return value of the function will be used as a slug.
     * The signature of the function should be as follows,
     *
     * ```php
     * function ($event)
     * {
     *     // return slug
     * }
     * ```
     */
    public $value;
    /**
     * @var boolean whether to generate a new slug if it has already been generated before.
     * If true, the behavior will not generate a new slug even if [[attribute]] is changed.
     * @since alfa version.2
     */
    public $immutable = false;
    /**
     * @var boolean whether to ensure generated slug value to be unique among owner class records.
     * If enabled behavior will validate slug uniqueness automatically. If validation fails it will attempt
     * generating unique slug value from based one until success.
     */
    public $ensureUnique = false;
    /**
     * @var array configuration for slug uniqueness validator. Parameter 'class' may be omitted - by default
     * [[UniqueValidator]] will be used.
     * @see UniqueValidator
     */
    public $uniqueValidator = [];
    /**
     * @var callable slug unique value generator. It is used in case [[ensureUnique]] enabled and generated
     * slug is not unique. This should be a PHP callable with following signature:
     *
     * ```php
     * function ($baseSlug, $iteration, $model)
     * {
     *     // return uniqueSlug
     * }
     * ```
     *
     * If not set unique slug will be generated adding incrementing suffix to the base slug.
     */
    public $uniqueSlugGenerator;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [BaseActiveRecord::EVENT_BEFORE_VALIDATE => $this->slugAttribute];
        }

        if ($this->attribute === null && $this->value === null) {
            throw new InvalidConfigException('Either "attribute" or "value" property must be specified.');
        }
    }

    /**
     * @inheritdoc
     */
    protected function getValue($event)
    {
        $isNewSlug = true;

        if ($this->attribute !== null) {
            $attributes = (array) $this->attribute;
            /* @var $owner BaseActiveRecord */
            $owner = $this->owner;
            if (!empty($owner->{$this->slugAttribute})) {
                $isNewSlug = false;
                if (!$this->immutable) {
                    foreach ($attributes as $attribute) {
                        if ($owner->isAttributeChanged($attribute)) {
                            $isNewSlug = true;
                            break;
                        }
                    }
                }
            }

            if ($isNewSlug) {
                $slugParts = [];
                foreach ($attributes as $attribute) {
                    $slugParts[] = $owner->{$attribute};
                }
                $slug = $this->generateSlug($slugParts);
            } else {
                $slug = $owner->{$this->slugAttribute};
            }
        } else {
            $slug = parent::getValue($event);
        }

        if ($this->ensureUnique && $isNewSlug) {
            $baseSlug = $slug;
            $iteration = 0;
            while (!$this->validateSlug($slug)) {
                $iteration++;
                $slug = $this->generateUniqueSlug($baseSlug, $iteration);
            }
        }
        return $slug;
    }

    /**
     * This method is called by [[getValue]] to generate the slug.
     * You may override it to customize slug generation.
     * The default implementation calls [[\uni\helpers\Inflector::slug()]] on the input strings
     * concatenated by dashes (`-`).
     * @param array $slugParts an array of strings that should be concatenated and converted to generate the slug value.
     * @return string the conversion result.
     */
    protected function generateSlug($slugParts)
    {
        return Inflector::slug(implode('-', $slugParts));
    }

    /**
     * Checks if given slug value is unique.
     * @param string $slug slug value
     * @return boolean whether slug is unique.
     */
    private function validateSlug($slug)
    {
        /* @var $validator UniqueValidator */
        /* @var $model BaseActiveRecord */
        $validator = Uni::createObject(array_merge(
            [
                'class' => UniqueValidator::className()
            ],
            $this->uniqueValidator
        ));

        $model = clone $this->owner;
        $model->clearErrors();
        $model->{$this->slugAttribute} = $slug;

        $validator->validateAttribute($model, $this->slugAttribute);
        return !$model->hasErrors();
    }

    /**
     * Generates slug using configured callback or increment of iteration.
     * @param string $baseSlug base slug value
     * @param integer $iteration iteration number
     * @return string new slug value
     * @throws \uni\base\InvalidConfigException
     */
    private function generateUniqueSlug($baseSlug, $iteration)
    {
        if (is_callable($this->uniqueSlugGenerator)) {
            return call_user_func($this->uniqueSlugGenerator, $baseSlug, $iteration, $this->owner);
        } else {
            return $baseSlug . '-' . ($iteration + 1);
        }
    }
}
