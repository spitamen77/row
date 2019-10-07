<?php

namespace app\models\dilshod;

use uni\base\Model;
use uni\data\ActiveDataProvider;
use app\models\dilshod\MenuItemTrans;

/**
 * MenuItemTransSearch represents the model behind the search form of `app\models\dilshod\MenuItemTrans`.
 */
class MenuItemTransSearch extends MenuItemTrans
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'item_id', 'status', 'updated_date'], 'integer'],
            [['lang', 'title', 'short', 'text'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MenuItemTrans::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                 'forcePageParam' => false,
                 'pageSizeParam' => false,
                'pageSize' => 10
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'item_id' => $this->item_id,
            'status' => $this->status,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'lang', $this->lang])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'short', $this->short])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }

    public function getItem()
    {
        return $this->hasOne(MenuItem::className(), ['id' => 'item_id']);
    }
}
