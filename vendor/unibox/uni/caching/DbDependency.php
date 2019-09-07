<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\caching;

use Uni;
use uni\base\InvalidConfigException;
use uni\db\Connection;
use uni\di\Instance;

/**
 * DbDependency represents a dependency based on the query result of a SQL statement.
 *
 * If the query result changes, the dependency is considered as changed.
 * The query is specified via the [[sql]] property.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class DbDependency extends Dependency
{
    /**
     * @var string the application component ID of the DB connection.
     */
    public $db = 'db';
    /**
     * @var string the SQL query whose result is used to determine if the dependency has been changed.
     * Only the first row of the query result will be used.
     */
    public $sql;
    /**
     * @var array the parameters (name => value) to be bound to the SQL statement specified by [[sql]].
     */
    public $params = [];


    /**
     * Generates the data needed to determine if dependency has been changed.
     * This method returns the value of the global state.
     * @param Cache $cache the cache component that is currently evaluating this dependency
     * @return mixed the data needed to determine if dependency has been changed.
     * @throws InvalidConfigException if [[db]] is not a valid application component ID
     */
    protected function generateDependencyData($cache)
    {
        $db = Instance::ensure($this->db, Connection::className());
        if ($this->sql === null) {
            throw new InvalidConfigException('DbDependency::sql must be set.');
        }

        if ($db->enableQueryCache) {
            // temporarily disable and re-enable query caching
            $db->enableQueryCache = false;
            $result = $db->createCommand($this->sql, $this->params)->queryOne();
            $db->enableQueryCache = true;
        } else {
            $result = $db->createCommand($this->sql, $this->params)->queryOne();
        }

        return $result;
    }
}
