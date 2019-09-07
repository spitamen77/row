<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\web;

/**
 * ResponseFormatterInterface specifies the interface needed to format a response before it is sent out.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
interface ResponseFormatterInterface
{
    /**
     * Formats the specified response.
     * @param Response $response the response to be formatted.
     */
    public function format($response);
}
