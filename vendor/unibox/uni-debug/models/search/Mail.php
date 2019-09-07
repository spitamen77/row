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
 * Mail represents the model behind the search form about current send emails.
 *
 * @author Mark Jebri <mark.github@yandex.ru>
 * @since alfa version
 */
class Mail extends Base
{
    /**
     * @var string from attribute input search value
     */
    public $from;
    /**
     * @var string to attribute input search value
     */
    public $to;
    /**
     * @var string reply attribute input search value
     */
    public $reply;
    /**
     * @var string cc attribute input search value
     */
    public $cc;
    /**
     * @var string bcc attribute input search value
     */
    public $bcc;
    /**
     * @var string subject attribute input search value
     */
    public $subject;
    /**
     * @var string body attribute input search value
     */
    public $body;
    /**
     * @var string charset attribute input search value
     */
    public $charset;
    /**
     * @var string headers attribute input search value
     */
    public $headers;
    /**
     * @var string file attribute input search value
     */
    public $file;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from', 'to', 'reply', 'cc', 'bcc', 'subject', 'body', 'charset'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'from' => 'From',
            'to' => 'To',
            'reply' => 'Reply',
            'cc' => 'Copy receiver',
            'bcc' => 'Hidden copy receiver',
            'subject' => 'Subject',
            'charset' => 'Charset'
        ];
    }

    /**
     * Returns data provider with filled models. Filter applied if needed.
     * @param array $params
     * @param array $models
     * @return \uni\data\ArrayDataProvider
     */
    public function search($params, $models)
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => $models,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['from', 'to', 'reply', 'cc', 'bcc', 'subject', 'body', 'charset'],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $filter = new Filter();
        $this->addCondition($filter, 'from', true);
        $this->addCondition($filter, 'to', true);
        $this->addCondition($filter, 'reply', true);
        $this->addCondition($filter, 'cc', true);
        $this->addCondition($filter, 'bcc', true);
        $this->addCondition($filter, 'subject', true);
        $this->addCondition($filter, 'body', true);
        $this->addCondition($filter, 'charset', true);
        $dataProvider->allModels = $filter->filter($models);

        return $dataProvider;
    }
}
