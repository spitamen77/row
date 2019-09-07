<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\base;

/**
 * ExitException represents a normal termination of an application.
 *
 * Do not catch ExitException. Uni will handle this exception to terminate the application gracefully.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class ExitException extends \Exception
{
    /**
     * @var integer the exit status code
     */
    public $statusCode;


    /**
     * Constructor.
     * @param integer $status the exit status code
     * @param string $message error message
     * @param integer $code error code
     * @param \Exception $previous The previous exception used for the exception chaining.
     */
    public function __construct($status = 0, $message = null, $code = 0, \Exception $previous = null)
    {
        $this->statusCode = $status;
        parent::__construct($message, $code, $previous);
    }
}
