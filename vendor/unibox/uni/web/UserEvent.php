<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\web;

use uni\base\Event;

/**
 * This event class is used for Events triggered by the [[User]] class.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class UserEvent extends Event
{
    /**
     * @var IdentityInterface the identity object associated with this event
     */
    public $identity;
    /**
     * @var boolean whether the login is cookie-based. This property is only meaningful
     * for [[User::EVENT_BEFORE_LOGIN]] and [[User::EVENT_AFTER_LOGIN]] events.
     */
    public $cookieBased;
    /**
     * @var integer $duration number of seconds that the user can remain in logged-in status.
     * If 0, it means login till the user closes the browser or the session is manually destroyed.
     */
    public $duration;
    /**
     * @var boolean whether the login or logout should proceed.
     * Event handlers may modify this property to determine whether the login or logout should proceed.
     * This property is only meaningful for [[User::EVENT_BEFORE_LOGIN]] and [[User::EVENT_BEFORE_LOGOUT]] events.
     */
    public $isValid = true;
}
