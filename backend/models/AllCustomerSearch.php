<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use backend\models\Customer;

/**
 * CustomerSearch represents the model behind the search form about `backend\models\Customer`.
 */
class AllCustomerSearch extends Customer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_status', 'belongto', 'created_at', 'updated_at'], 'integer'],
            [['customer_name', 'customer_mobile', 'customer_address', 'customer_sn'], 'safe'],
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
        $query = Customer::find();
        
        $query = new Query();
        
        $query->select("c.*, u.username")
        	->from(['customer c'])
        	->leftJoin("user u", "c.belongto = u.id");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        	'key' => 'id',
        	'sort' => [
        		'attributes' => [
        			'customer_name',
        			'customer_mobile',
        			'customer_address',
        			'belongto',
        			'customer_sn',
        			'created_at',
        		]
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
            'customer_status' => $this->customer_status,
        	'belongto' => $this->belongto,
        ]);

        $query->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'customer_mobile', $this->customer_mobile])
            ->andFilterWhere(['like', 'customer_address', $this->customer_address])
        	->andFilterWhere(['like', 'customer_sn', $this->customer_sn]);

        return $dataProvider;
    }
}
