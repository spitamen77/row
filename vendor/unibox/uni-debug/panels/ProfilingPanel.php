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
use uni\debug\models\search\Profile;

/**
 * Debugger panel that collects and displays performance profiling info.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class ProfilingPanel extends Panel
{
    /**
     * @var array current request profile timings
     */
    private $_models;


    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Profiling';
    }

    /**
     * @inheritdoc
     */
    public function getSummary()
    {
        return Uni::$app->view->render('panels/profile/summary', [
            'memory' => sprintf('%.3f MB', $this->data['memory'] / 1048576),
            'time' => number_format($this->data['time'] * 1000) . ' ms',
            'panel' => $this
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getDetail()
    {
        $searchModel = new Profile();
        $dataProvider = $searchModel->search(Uni::$app->request->getQueryParams(), $this->getModels());

        return Uni::$app->view->render('panels/profile/detail', [
            'panel' => $this,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'memory' => sprintf('%.3f MB', $this->data['memory'] / 1048576),
            'time' => number_format($this->data['time'] * 1000) . ' ms',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        $target = $this->module->logTarget;
        $messages = $target->filterMessages($target->messages, Logger::LEVEL_PROFILE);
        return [
            'memory' => memory_get_peak_usage(),
            'time' => microtime(true) - UNI_BEGIN_TIME,
            'messages' => $messages,
        ];
    }

    /**
     * Returns array of profiling models that can be used in a data provider.
     * @return array models
     */
    protected function getModels()
    {
        if ($this->_models === null) {
            $this->_models = [];
            $timings = Uni::getLogger()->calculateTimings($this->data['messages']);

            foreach ($timings as $seq => $profileTiming) {
                $this->_models[] = 	[
                    'duration' => $profileTiming['duration'] * 1000, // in milliseconds
                    'category' => $profileTiming['category'],
                    'info' => $profileTiming['info'],
                    'level' => $profileTiming['level'],
                    'timestamp' => $profileTiming['timestamp'] * 1000, //in milliseconds
                    'seq' => $seq,
                ];
            }
        }

        return $this->_models;
    }
}
