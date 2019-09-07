<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\codeception;

use uni\test\InitDbFixture;

/**
 * Base class for database test cases
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class DbTestCase extends TestCase
{
    /**
     * @inheritdoc
     */
    public function globalFixtures()
    {
        return [
            InitDbFixture::className(),
        ];
    }
}
