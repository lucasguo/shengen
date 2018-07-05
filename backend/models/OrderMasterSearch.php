<?php

namespace backend\models;

use Yii;
use yii\helpers\Html;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OrderMaster;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * OrderMasterSearch represents the model behind the search form about `backend\models\OrderMaster`.
 */
class OrderMasterSearch extends OrderMaster
{
	public $machine_sn;
	public $customer_name;
	public $daterange;
	
	public $amount_from;
	public $amount_to;
	public $status_set;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'sold_count', 'sold_datetime', 'need_invoice', 'order_status', 'warranty_in_month', 'created_at', 'updated_at'], 'integer'],
            [['sold_amount', 'amount_from', 'amount_to'], 'number'],
        	[['machine_sn', 'customer_name', 'order_sn', 'daterange'], 'string']
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
        //$query = OrderMaster::find();

    	$query = new Query();
    	
    	$query->select("m.*, c.customer_name")->from("order_master m")->leftJoin("customer c", "m.customer_id = c.id");
    	
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
        	'key' => 'id',
            'query' => $query,
        	'sort' => [
                'defaultOrder' => ['sold_datetime'=>SORT_DESC],
        		'attributes' => [
        			'order_sn',
        			'customer_name',
		            'sold_amount',
        			'sold_count',
		            'sold_datetime',
		            'order_status',
        		],
        	],
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
            'customer_id' => $this->customer_id,
            'sold_count' => $this->sold_count,
            'sold_amount' => $this->sold_amount,
            'sold_datetime' => $this->sold_datetime,
            'need_invoice' => $this->need_invoice,
            'order_status' => $this->order_status,
            'warranty_in_month' => $this->warranty_in_month,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        if(!empty($this->machine_sn)) {
        	$machines = MachineMaster::findAll(['like', 'machine_sn', $this->machine_sn]);
        	$machineIds = ArrayHelper::getColumn($machines, "id");
        	$details = OrderDetail::findAll(['in', 'machine_id', $machineIds]);
        	$masterIds = ArrayHelper::getColumn($details, "master_id");
        	$query->andFilterWhere(['in', 'id', $masterIds]);
        }
        
        if(!empty($this->status_set)) {
        	$query->andFilterWhere(['in', 'order_status', $this->status_set]);
        }
        
        $query->andFilterWhere(['like', 'customer_name', $this->customer_name])
        	->andFilterWhere(['like', 'order_sn', $this->order_sn]);

        $daterange = explode(" - ", $this->daterange);
        if(count($daterange) == 2)
        {
        	$from = strtotime($daterange[0]);
        	$to = strtotime($daterange[1]);
        	if($from && $to)
        	{
        		$query->andFilterWhere([
        			'between', 'sold_date', $daterange[0], $daterange[1]
        		]);
        	}
        }
        
        if(!empty($this->amount_from)) {
        	$query->andFilterWhere([
        		'>=', 'sold_amount', $this->amount_from
        	]);
        }
        
        if(!empty($this->amount_to)) {
        	$query->andFilterWhere([
        		'<=', 'sold_amount', $this->amount_to
        	]);
        }
        
        return $dataProvider;
    }
    
    public function renderAmountRangeFilter()
    {
    	$filter = "";
    	$filter .= "<div class='form-inline'>";
    	$filter .= Html::activeTextInput($this, "amount_from", [
    		'type' => 'number',
    		'class' => 'form-control',
    		'style' => 'width: 7em;',
    	]);
    	$filter .= " - ";
    	$filter .= Html::activeTextInput($this, "amount_to", [
    		'type' => 'number',
    		'class' => 'form-control',
    		'style' => 'width: 7em;',
    	]);
    	$filter .= "</div>";
    	return $filter;
    }
}
