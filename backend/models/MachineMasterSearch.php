<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MachineMaster;
use yii\db\Query;

/**
 * MachineMasterSearch represents the model behind the search form about `backend\models\MachineMaster`.
 */
class MachineMasterSearch extends MachineMaster
{
	public $daterange;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'machine_status', 'in_datetime', 'out_datetime', 'created_at', 'updated_at'], 'integer'],
            [['machine_sn', 'daterange'], 'safe'],
            [['machine_cost'], 'number'],
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
        //$query = MachineMaster::find();
        
    	$query = new Query();
    	$query->select("m.*, p.product_name")->from("machine m")->leftJoin("machine_product p", "m.product_id = p.id");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
        	'key' => 'id',
            'query' => $query,
        	'sort' => [
        		'attributes' => [
        			'product_id',
        			'machine_sn',
        			'machine_status',
        			'in_datetime',
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
            'product_id' => $this->product_id,
            'machine_cost' => $this->machine_cost,
            'machine_status' => $this->machine_status,
            'in_datetime' => $this->in_datetime,
            'out_datetime' => $this->out_datetime,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'machine_sn', $this->machine_sn]);
        
        $daterange = explode(" - ", $this->daterange);
        if(count($daterange) == 2)
        {
        	$from = $daterange[0];
        	$to = $daterange[1];
        	if($from) {
        		$query->andFilterWhere([
        			'>=', 'in_datetime', $from
        		]);
        	}
        	if($to) {
        		$query->andFilterWhere([
        			'<=', 'in_datetime', $from
        		]);
        	}
        }

        return $dataProvider;
    }
}
