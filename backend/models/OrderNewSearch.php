<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OrderNew;
use yii\db\Expression;

/**
 * OrderNewSearch represents the model behind the search form about `backend\models\OrderNew`.
 */
class OrderNewSearch extends OrderNew
{
    public $model_list;
    public $hospital_list;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'model_id', 'sell_count', 'order_status', 'org_order_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['sell_amount'], 'number'],
            [['hospital_list', 'model_list'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        $labels =  parent::attributeLabels();
        $labels['model_list'] = '产品型号';
        $labels['hospital_list'] = '医院';
        return $labels;
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
        $subQuery = OrderNew::find()->select('org_order_id')->andWhere(['is not', 'org_order_id', null]);
        $query = OrderNew::find()->where(['not in', 'id', $subQuery]);

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
            'model_id' => $this->model_id,
            'sell_count' => $this->sell_count,
            'order_status' => $this->order_status,
            'org_order_id' => $this->org_order_id,
            'sell_amount' => $this->sell_amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['in', 'model_id', $this->model_list])
            ->andFilterWhere(['in', 'hospital_id', $this->hospital_list]);

        return $dataProvider;
    }
}
