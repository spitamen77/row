<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\debug\components\search\matchers;

use uni\base\Component;

/**
 * Base class for matchers that are used in a filter.
 *
 * @author Mark Jebri <mark.github@yandex.ru>
 * @since alfa version
 */
abstract class Base extends Component implements MatcherInterface
{
    /**
     * @var mixed base value to check
     */
    protected $baseValue;


    /**
     * @inheritdoc
     */
    public function setValue($value)
    {
        $this->baseValue = $value;
    }

    /**
     * @inheritdoc
     */
    public function hasValue()
    {
        return !empty($this->baseValue) || ($this->baseValue === '0');
    }
}
