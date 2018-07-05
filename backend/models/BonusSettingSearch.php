<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BonusSetting;

/**
 * BonusSettingSearch represents the model behind the search form about `backend\models\BonusSetting`.
 */
class BonusSettingSearch extends BonusSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level_limit', 'return_day_limit', 'product_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['single_price', 'once_return', 'sale_bonus', 'manage_bonus'], 'number'],
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
        $query = BonusSetting::find();

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
            'single_price' => $this->single_price,
            'once_return' => $this->once_return,
            'sale_bonus' => $this->sale_bonus,
            'manage_bonus' => $this->manage_bonus,
            'level_limit' => $this->level_limit,
            'return_day_limit' => $this->return_day_limit,
            'product_id' => $this->product_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }
}
