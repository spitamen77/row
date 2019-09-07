<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\i18n;

use uni\base\Event;

/**
 * MissingTranslationEvent represents the parameter for the [[MessageSource::EVENT_MISSING_TRANSLATION]] event.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class MissingTranslationEvent extends Event
{
    /**
     * @var string the message to be translated. An event handler may use this to provide a fallback translation
     * and set [[translatedMessage]] if possible.
     */
    public $message;
    /**
     * @var string the translated message. An event handler may overwrite this property
     * with a translated version of [[message]] if possible. If not set (null), it means the message is not translated.
     */
    public $translatedMessage;
    /**
     * @var string the category that the message belongs to
     */
    public $category;
    /**
     * @var string the language ID (e.g. en-US) that the message is to be translated to
     */
    public $language;
}
