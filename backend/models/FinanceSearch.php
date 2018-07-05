<?php

namespace backend\models;

use Yii;
use yii\helpers\Html;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Finance;

/**
 * FinanceSearch represents the model behind the search form about `backend\models\Finance`.
 */
class FinanceSearch extends Finance
{
	public $amount_from;
	public $amount_to;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'userid', 'status', 'relate_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['amount', 'amount_from', 'amount_to'], 'number'],
            [['content', 'relate_table'], 'safe'],
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
    public function search($params, $isNew)
    {
        if ($isNew) {
            $query = FinanceNew::find();
        } else {
            $query = Finance::find();
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        	'sort' => [
        		'defaultOrder' => ['occur_date'=>SORT_DESC],
        		'attributes' => [
        			'type',
        			'amount',
        			'content',
        			'occur_date',
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
            'type' => $this->type,
            'amount' => $this->amount,
            'userid' => $this->userid,
            'status' => $this->status,
            'relate_id' => $this->relate_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'relate_table', $this->relate_table]);

        if(!empty($this->amount_from))
        {
        	$query->andFilterWhere(['>=', 'amount', $this->amount_from]);
        }
        if(!empty($this->amount_to))
        {
        	$query->andFilterWhere(['<=', 'amount', $this->amount_to]);
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
