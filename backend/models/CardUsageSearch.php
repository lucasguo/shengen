<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CardUsage;

/**
 * CardUsageSearch represents the model behind the search form about `backend\models\CardUsage`.
 */
class CardUsageSearch extends CardUsage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'card_id', 'use_datetime', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['record', 'helpername'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = CardUsage::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'buyer_id' => $this->buyer_id,
            'card_id' => $this->card_id,
            'use_datetime' => $this->use_datetime,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'record', $this->record])
            ->andFilterWhere(['like', 'helpername', $this->helpername]);

        return $dataProvider;
    }
}
