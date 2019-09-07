<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\helpers;

/**
 * Markdown provides an ability to transform markdown into HTML.
 *
 * Basic usage is the following:
 *
 * ```php
 * $myHtml = Markdown::process($myText); // use original markdown flavor
 * $myHtml = Markdown::process($myText, 'gfm'); // use github flavored markdown
 * $myHtml = Markdown::process($myText, 'extra'); // use markdown extra
 * ```
 *
 * You can configure multiple flavors using the [[$flavors]] property.
 *
 * For more details please refer to the [Markdown library documentation](https://github.com/cebe/markdown#readme).
 *
 * @author Carsten Brandt <mail@cebe.cc>
 * @since alfa version
 */
class Markdown extends BaseMarkdown
{
}
