<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\web;

/**
 * TooManyRequestsHttpException represents a "Too Many Requests" HTTP exception with status code 429
 *
 * Use this exception to indicate that a client has made too many requests in a
 * given period of time. For example, you would throw this exception when
 * 'throttling' an API user.
 *
 * @link http://tools.ietf.org/search/rfc6585#section-4
 * @author Dan Schmidt <danschmidt5189@gmail.com>
 * @since alfa version
 */
class TooManyRequestsHttpException extends HttpException
{
    /**
     * Constructor.
     * @param string $message error message
     * @param integer $code error code
     * @param \Exception $previous The previous exception used for the exception chaining.
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct(429, $message, $code, $previous);
    }
}
