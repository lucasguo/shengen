<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Hospital;

/**
 * HospitalSearch represents the model behind the search form about `backend\models\Hospital`.
 */
class HospitalSearch extends Hospital
{
    public $hospital_city_list;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hospital_province', 'hospital_city', 'hospital_district', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['hospital_name', 'comment'], 'safe'],
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

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['hospital_city_list'] = '医院所在城市';
        return $labels;
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
        $query = Hospital::find();

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
            'hospital_province' => $this->hospital_province,
            'hospital_city' => $this->hospital_city,
            'hospital_district' => $this->hospital_district,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'hospital_name', $this->hospital_name])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['in', 'hospital_city', $this->hospital_city_list]);

        return $dataProvider;
    }
}
