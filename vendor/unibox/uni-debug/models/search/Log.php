<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\debug\models\search;

use uni\data\ArrayDataProvider;
use uni\debug\components\search\Filter;

/**
 * Search model for current request log.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @author Mark Jebri <mark.github@yandex.ru>
 * @since alfa version
 */
class Log extends Base
{
    /**
     * @var string ip attribute input search value
     */
    public $level;
    /**
     * @var string method attribute input search value
     */
    public $category;
    /**
     * @var integer message attribute input search value
     */
    public $message;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'message', 'category'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'level' => 'Level',
            'category' => 'Category',
            'message' => 'Message',
        ];
    }

    /**
     * Returns data provider with filled models. Filter applied if needed.
     *
     * @param array $params an array of parameter values indexed by parameter names
     * @param array $models data to return provider for
     * @return \uni\data\ArrayDataProvider
     */
    public function search($params, $models)
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => $models,
            'pagination' => false,
            'sort' => [
                'attributes' => ['time', 'level', 'category', 'message'],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $filter = new Filter();
        $this->addCondition($filter, 'level');
        $this->addCondition($filter, 'category', true);
        $this->addCondition($filter, 'message', true);
        $dataProvider->allModels = $filter->filter($models);

        return $dataProvider;
    }
}
