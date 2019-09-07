<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\web;

/**
 * GoneHttpException represents a "Gone" HTTP exception with status code 410
 *
 * Throw a GoneHttpException when a user requests a resource that no longer exists
 * at the requested url. For example, after a record is deleted, future requests
 * for that record should return a 410 GoneHttpException instead of a 404
 * [[NotFoundHttpException]].
 *
 * @link http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.11
 * @author Dan Schmidt <danschmidt5189@gmail.com>
 * @since alfa version
 */
class GoneHttpException extends HttpException
{
    /**
     * Constructor.
     * @param string $message error message
     * @param integer $code error code
     * @param \Exception $previous The previous exception used for the exception chaining.
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct(410, $message, $code, $previous);
    }
}
