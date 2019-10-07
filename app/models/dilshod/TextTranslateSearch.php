<?php

namespace app\models\dilshod;

use uni\base\Model;
use uni\data\ActiveDataProvider;
use app\models\dilshod\TextTranslate;

/**
 * TextTranslateSearch represents the model behind the search form of `app\models\dilshod\TextTranslate`.
 */
class TextTranslateSearch extends TextTranslate
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'updated_date'], 'integer'],
            [['lang', 'slug', 'text'], 'safe'],
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
        $query = TextTranslate::find()->where(['lang'=>'uz-UZ', 'status'=>1])->orderBy(['id'=>SORT_DESC]);

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
            'status' => $this->status,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'lang', $this->lang])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
