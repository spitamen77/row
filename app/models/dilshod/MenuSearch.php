<?php

namespace app\models\dilshod;

use uni\base\Model;
use uni\data\ActiveDataProvider;
use app\models\dilshod\Menu;

/**
 * MenuSearch represents the model behind the search form of `app\models\dilshod\Menu`.
 */
class MenuSearch extends Menu
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'template_id', 'tree', 'child', 'status', 'user_id', 'updated_date'], 'integer'],
            [['title', 'slug'], 'safe'],
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
        $query = Menu::find()->where(['status'=>Menu::STATUS_ACTIVE])->orderBy(['child'=>SORT_ASC]);

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
            'template_id' => $this->template_id,
            'tree' => $this->tree,
            'child' => $this->child,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }
}
