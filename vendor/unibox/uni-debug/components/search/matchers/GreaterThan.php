<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\debug\components\search\matchers;

/**
 * Checks if the given value is greater than the base one.
 *
 * @author Mark Jebri <mark.github@yandex.ru>
 * @since alfa version
 */
class GreaterThan extends Base
{
    /**
     * @inheritdoc
     */
    public function match($value)
    {
        return ($value > $this->baseValue);
    }
}
