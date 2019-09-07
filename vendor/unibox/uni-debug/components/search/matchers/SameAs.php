<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\debug\components\search\matchers;

/**
 * Checks if the given value is exactly or partially same as the base one.
 *
 * @author Mark Jebri <mark.github@yandex.ru>
 * @since alfa version
 */
class SameAs extends Base
{
    /**
     * @var boolean if partial match should be used.
     */
    public $partial = false;


    /**
     * @inheritdoc
     */
    public function match($value)
    {
        if ($this->partial) {
            return mb_stripos($value, $this->baseValue, 0, \Uni::$app->charset) !== false;
        } else {
            return strcmp(mb_strtoupper($this->baseValue, \Uni::$app->charset), mb_strtoupper($value, \Uni::$app->charset)) === 0;
        }
    }
}
