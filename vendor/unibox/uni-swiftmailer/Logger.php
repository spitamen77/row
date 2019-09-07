<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\swiftmailer;

use Uni;

/**
 * Logger is a SwiftMailer plugin, which allows passing of the SwiftMailer internal logs to the
 * Uni logging mechanism. Each native SwiftMailer log message will be converted into Uni 'info' log entry.
 *
 * In order to catch logs written by this class, you need to setup a log route for 'uni\swiftmailer\Logger::add' category.
 * For example:
 *
 * ~~~
 * 'log' => [
 *     'targets' => [
 *         [
 *             'class' => 'uni\log\FileTarget',
 *             'categories' => ['uni\swiftmailer\Logger::add'],
 *         ],
 *     ],
 * ],
 * ~~~
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since alfa version
 */
class Logger implements \Swift_Plugins_Logger
{
    /**
     * @inheritdoc
     */
    public function add($entry)
    {
        Uni::info($entry, __METHOD__);
    }

    /**
     * @inheritdoc
     */
    public function clear()
    {
        // do nothing
    }

    /**
     * @inheritdoc
     */
    public function dump()
    {
        return '';
    }
}