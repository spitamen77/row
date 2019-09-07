<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\rbac;

use Uni;
use uni\base\BaseObject;

/**
 * Assignment represents an assignment of a role to a user.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @since alfa version
 */
class Assignment extends BaseObject
{
    /**
     * @var string|integer user ID (see [[\uni\web\User::id]])
     */
    public $userId;
    /**
     * @var string the role name
     */
    public $roleName;
    /**
     * @var integer UNIX timestamp representing the assignment creation time
     */
    public $createdAt;
}
