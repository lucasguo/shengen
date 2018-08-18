<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CustomerNew;

/**
 * CustomerNewSearch represents the model behind the search form about `backend\models\CustomerNew`.
 */
class CustomerNewSearch extends CustomerNew
{
    public $hospital_list;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['customer_name', 'customer_mobile', 'customer_company', 'customer_job', 'comment', 'hospital_list'], 'safe'],
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
        $labels =  parent::attributeLabels();
        $labels['hospital_list'] = '关联医院';
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
        $query = CustomerNew::find()->distinct()->leftJoin(CustomerHospitalMapping::tableName(), CustomerNew::tableName() . '.id = ' . CustomerHospitalMapping::tableName() . '.customer_id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['updated_at'=>SORT_DESC]],
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'customer_type' => $this->customer_type,
        ]);

        $hospitals = [];
        if (is_array($this->hospital_list)) {
            foreach ($this->hospital_list as $key => $value) {
                $hospitals[] = $value;
            }
        }

        $query->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'customer_mobile', $this->customer_mobile])
            ->andFilterWhere(['like', 'customer_company', $this->customer_company])
            ->andFilterWhere(['like', 'customer_job', $this->customer_job])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['in', 'hospital_id', $hospitals]);

        return $dataProvider;
    }
}
