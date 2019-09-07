<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

use uni\base\InvalidConfigException;
use uni\caching\DbCache;
use uni\db\Migration;

/**
 * Initializes Cache tables
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since alfa version.7
 */
class m150909_153426_cache_init extends Migration
{

    /**
     * @throws uni\base\InvalidConfigException
     * @return DbCache
     */
    protected function getCache()
    {
        $cache = Uni::$app->getCache();
        if (!$cache instanceof DbCache) {
            throw new InvalidConfigException('You should configure "cache" component to use database before executing this migration.');
        }
        return $cache;
    }

    /**
     * @inheritdoc
     */
    public function up()
    {
        $cache = $this->getCache();
        $this->db = $cache->db;

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($cache->cacheTable, [
            'id' => $this->string(128)->notNull(),
            'expire' => $this->integer(),
            'data' => $this->binary(),
            'PRIMARY KEY ([[id]])',
            ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $cache = $this->getCache();
        $this->db = $cache->db;

        $this->dropTable($cache->cacheTable);
    }
}
