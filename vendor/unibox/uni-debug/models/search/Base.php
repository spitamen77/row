<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\debug\models\search;

use uni\base\Model;
use uni\debug\components\search\Filter;
use uni\debug\components\search\matchers;

/**
 * Base search model
 *
 * @author Mark Jebri <mark.github@yandex.ru>
 * @since alfa version
 */
class Base extends Model
{
    /**
     * Adds filtering condition for a given attribute
     *
     * @param Filter $filter filter instance
     * @param string $attribute attribute to filter
     * @param boolean $partial if partial match should be used
     */
    public function addCondition(Filter $filter, $attribute, $partial = false)
    {
        $value = $this->$attribute;

        if (mb_strpos($value, '>') !== false) {
            $value = intval(str_replace('>', '', $value));
            $filter->addMatcher($attribute, new matchers\GreaterThan(['value' => $value]));

        } elseif (mb_strpos($value, '<') !== false) {
            $value = intval(str_replace('<', '', $value));
            $filter->addMatcher($attribute, new matchers\LowerThan(['value' => $value]));
        } else {
            $filter->addMatcher($attribute, new matchers\SameAs(['value' => $value, 'partial' => $partial]));
        }
    }
}
