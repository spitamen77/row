<?php
/**
 * Uni bootstrap file.
 *
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

require(__DIR__ . '/BaseUni.php');

/**
 * Uni is a helper class serving common framework functionalities.
 *
 * It extends from [[\uni\BaseUni]] which provides the actual implementation.
 * By writing your own Uni class, you can customize some functionalities of [[\uni\BaseUni]].
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class Uni extends \uni\BaseUni
{
}

spl_autoload_register(['Uni', 'autoload'], true, true);
Uni::$classMap = require(__DIR__ . '/classes.php');
Uni::$container = new uni\di\Container();
