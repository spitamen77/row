<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\debug\components\search\matchers;

/**
 * MatcherInterface should be implemented by all matchers that are used in a filter.
 *
 * @author Mark Jebri <mark.github@yandex.ru>
 * @since alfa version
 */
interface MatcherInterface
{
    /**
     * Checks if the value passed matches base value.
     *
     * @param mixed $value value to be matched
     * @return boolean if there is a match
     */
    public function match($value);

    /**
     * Sets base value to match against
     *
     * @param mixed $value
     */
    public function setValue($value);

    /**
     * Checks if base value is set
     *
     * @return boolean if base value is set
     */
    public function hasValue();
}
