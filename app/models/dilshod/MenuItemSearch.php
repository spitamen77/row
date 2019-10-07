<?php

namespace app\models\dilshod;

use uni\base\Model;
use uni\data\ActiveDataProvider;
use app\models\dilshod\MenuItem;

/**
 * MenuItemSearch represents the model behind the search form of `app\models\dilshod\MenuItem`.
 */
class MenuItemSearch extends MenuItem
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'menu_id', 'views', 'status', 'price', 'sale', 'user_id', 'created_date', 'updated_date'], 'integer'],
            [['title', 'photo', 'short', 'text', 'slug','file'], 'safe'],
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
        // $query = MenuItem::find()->where(['status'=>1])->orderBy(['id'=>SORT_DESC]);
        $query = MenuItem::find()->where(['status'=>[1,0]])->orderBy(['id'=>SORT_DESC]);

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
            'menu_id' => $this->menu_id,
            'views' => $this->views,
            'status' => $this->status,
            'price' => $this->price,
            'sale' => $this->sale,
            'user_id' => $this->user_id,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'short', $this->short])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }
}
