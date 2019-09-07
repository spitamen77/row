<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\debug\panels;

use Uni;
use uni\debug\Panel;
use uni\log\Logger;
use uni\debug\models\search\Db;

/**
 * Debugger panel that collects and displays database queries performed.
 *
 * @property array $profileLogs This property is read-only.
 * @property string $summaryName Short name of the panel, which will be use in summary. This property is
 * read-only.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class DbPanel extends Panel
{
    /**
     * @var integer the threshold for determining whether the request has involved
     * critical number of DB queries. If the number of queries exceeds this number,
     * the execution is considered taking critical number of DB queries.
     */
    public $criticalQueryThreshold;

    /**
     * @var string the name of the database component to use for executing (explain) queries
     */
    public $db = 'db';

    /**
     * @var array db queries info extracted to array as models, to use with data provider.
     */
    private $_models;

    /**
     * @var array current database request timings
     */
    private $_timings;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->actions['db-explain'] = [
            'class' => 'uni\\debug\\actions\\db\\ExplainAction',
            'panel' => $this,
        ];
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Database';
    }

    /**
     * @return string short name of the panel, which will be use in summary.
     */
    public function getSummaryName()
    {
        return 'DB';
    }

    /**
     * @inheritdoc
     */
    public function getSummary()
    {
        $timings = $this->calculateTimings();
        $queryCount = count($timings);
        $queryTime = number_format($this->getTotalQueryTime($timings) * 1000) . ' ms';

        return Uni::$app->view->render('panels/db/summary', [
            'timings' => $this->calculateTimings(),
            'panel' => $this,
            'queryCount' => $queryCount,
            'queryTime' => $queryTime,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getDetail()
    {
        $searchModel = new Db();
        $dataProvider = $searchModel->search(Uni::$app->request->getQueryParams(), $this->getModels());

        return Uni::$app->view->render('panels/db/detail', [
            'panel' => $this,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'hasExplain' => $this->hasExplain()
        ]);
    }

    /**
     * Calculates given request profile timings.
     *
     * @return array timings [token, category, timestamp, traces, nesting level, elapsed time]
     */
    public function calculateTimings()
    {
        if ($this->_timings === null) {
            $this->_timings = Uni::getLogger()->calculateTimings($this->data['messages']);
        }

        return $this->_timings;
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        return ['messages' => $this->getProfileLogs()];
    }

    /**
     * Returns all profile logs of the current request for this panel. It includes categories such as:
     * 'uni\db\Command::query', 'uni\db\Command::execute'.
     * @return array
     */
    public function getProfileLogs()
    {
        $target = $this->module->logTarget;

        return $target->filterMessages($target->messages, Logger::LEVEL_PROFILE, ['uni\db\Command::query', 'uni\db\Command::execute']);
    }

    /**
     * Returns total query time.
     *
     * @param array $timings
     * @return integer total time
     */
    protected function getTotalQueryTime($timings)
    {
        $queryTime = 0;

        foreach ($timings as $timing) {
            $queryTime += $timing['duration'];
        }

        return $queryTime;
    }

    /**
     * Returns an  array of models that represents logs of the current request.
     * Can be used with data providers such as \uni\data\ArrayDataProvider.
     * @return array models
     */
    protected function getModels()
    {
        if ($this->_models === null) {
            $this->_models = [];
            $timings = $this->calculateTimings();

            foreach ($timings as $seq => $dbTiming) {
                $this->_models[] = [
                    'type' => $this->getQueryType($dbTiming['info']),
                    'query' => $dbTiming['info'],
                    'duration' => ($dbTiming['duration'] * 1000), // in milliseconds
                    'trace' => $dbTiming['trace'],
                    'timestamp' => ($dbTiming['timestamp'] * 1000), // in milliseconds
                    'seq' => $seq,
                ];
            }
        }

        return $this->_models;
    }

    /**
     * Returns database query type.
     *
     * @param string $timing timing procedure string
     * @return string query type such as select, insert, delete, etc.
     */
    protected function getQueryType($timing)
    {
        $timing = ltrim($timing);
        preg_match('/^([a-zA-z]*)/', $timing, $matches);

        return count($matches) ? mb_strtoupper($matches[0], 'utf8') : '';
    }

    /**
     * Check if given queries count is critical according settings.
     *
     * @param integer $count queries count
     * @return boolean
     */
    public function isQueryCountCritical($count)
    {
        return (($this->criticalQueryThreshold !== null) && ($count > $this->criticalQueryThreshold));
    }

    /**
     * Returns array query types
     *
     * @return array
     * @since alfa version.3
     */
    public function getTypes()
    {
        return array_reduce(
            $this->_models,
            function ($result, $item) {
                $result[$item['type']] = $item['type'];
                return $result;
            },
            []
        );
    }

    /**
     * @return boolean Whether the DB component has support for EXPLAIN queries
     */
    protected function hasExplain()
    {
        switch ($this->getDb()->getDriverName()) {
            case 'mysql':
            case 'sqlite':
            case 'pgsql':
            case 'cubrid':
                return true;
            default:
                return false;
        }
    }

    /**
     * Check if given query type can be explained.
     *
     * @param string $type query type
     * @return boolean
     *
     * @since alfa version.5
     */
    public static function canBeExplained($type)
    {
        return $type !== 'SHOW';
    }

    /**
     * Returns a reference to the DB component associated with the panel
     * 
     * @return \uni\db\Connection
     */
    public function getDb()
    {
        return Uni::$app->get($this->db);
    }
}
