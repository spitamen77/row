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
 * Search model for current request profiling log.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @author Mark Jebri <mark.github@yandex.ru>
 * @since alfa version
 */
class Profile extends Base
{
    /**
     * @var string method attribute input search value
     */
    public $category;
    /**
     * @var integer info attribute input search value
     */
    public $info;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'info'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category' => 'Category',
            'info' => 'Info',
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
                'attributes' => ['category', 'seq', 'duration', 'info'],
                'defaultOrder' => [
                    'seq' => SORT_ASC,
                ],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $filter = new Filter();
        $this->addCondition($filter, 'category', true);
        $this->addCondition($filter, 'info', true);
        $dataProvider->allModels = $filter->filter($models);

        return $dataProvider;
    }
}
