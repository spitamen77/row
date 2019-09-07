<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\web;

/**
 * UnprocessableEntityHttpException represents an "Unprocessable Entity" HTTP 
 * exception with status code 422.
 *
 * Use this exception to inform that the server understands the content type of
 * the request entity and the syntax of that request entity is correct but the server 
 * was unable to process the contained instructions. For example, to return form 
 * validation errors. 
 *
 * @link http://www.webdav.org/specs/rfc2518.html#STATUS_422
 * @author Jan Silva <janfrs3@gmail.com>
 * @since alfa version.7
 */
class UnprocessableEntityHttpException extends HttpException
{
    /**
     * Constructor.
     * @param string $message error message
     * @param integer $code error code
     * @param \Exception $previous The previous exception used for the exception chaining.
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct(422, $message, $code, $previous);
    }
}
