<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductModel;

/**
 * ProductModelSearch represents the model behind the search form about `backend\models\ProductModel`.
 */
class ProductModelSearch extends ProductModel
{
    public $product_list;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['model_name', 'product_list'], 'safe'],
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
        $query = ProductModel::find();

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
            'product_id' => $this->product_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);


        $products = [];
        if (is_array($this->product_list)) {
            foreach ($this->product_list as $key => $value) {
                $products[] = $value;
            }
        }

        $query->andFilterWhere(['like', 'model_name', $this->model_name])
            ->andFilterWhere(['in', 'product_id', $products]);

        return $dataProvider;
    }
}
