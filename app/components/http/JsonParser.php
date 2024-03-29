<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\components\http;

use uni\base\BaseObject;
use uni\helpers\Json;

/**
 * JsonParser parses HTTP message content as JSON.
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 2.0
 */
class JsonParser extends BaseObject implements ParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function parse(Response $response)
    {
        return Json::decode($response->getContent());
    }
}