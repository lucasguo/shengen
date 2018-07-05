<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CardBuyer;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Expression;

/**
 * CardBuyerSearch represents the model behind the search form about `backend\models\CardBuyer`.
 */
class CardBuyerSearch extends CardBuyer
{
	public $cardlist;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'shop_id', 'updated_at', 'created_by', 'updated_by', 'intro_type'], 'integer'],
            [['buyername', 'sex', 'address', 'mobile', 'urgentperson', 'urgentmobile', 'symptom', 'cardlist', 'intro_name'], 'safe'],
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
        $query = CardBuyer::find()->joinWith('shop');

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
            'shop_id' => $this->shop_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'buyername', $this->buyername])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
//            ->andFilterWhere(['like', 'urgentperson', $this->urgentperson])
//            ->andFilterWhere(['like', 'urgentmobile', $this->urgentmobile])
            ->andFilterWhere(['like', 'symptom', $this->symptom]);

        return $dataProvider;
    }
    
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return SqlDataProvider
     */
    public function searchList($params)
    {
    	$query = (new Query())->select(["b.buyername", "b.mobile", "b.created_at", "b.id", new Expression("ifnull(j.cardlist, '') as cardlist"), new Expression("ifnull(j.lefttime, 0) as times")])
    			->from(CardBuyer::tableName() . ' b')
    			->leftJoin('(select group_concat(card_no) as cardlist, sum(left_times) as lefttime, buyer_id from card group by buyer_id) j ', new Expression('b.id = j.buyer_id'));

    	$dataProvider = new ActiveDataProvider([
    		'query' => $query,
    		'key' => 'id',
    		'sort' => [
    			"attributes" => [
    				'buyername',
    				'mobile',
    				'created_at',
    				'times',
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
    		'shop_id' => $this->shop_id,
    	]);
    			
    	$query->andFilterWhere(['like', 'buyername', $this->buyername])
    		->andFilterWhere(['like', 'cardlist', $this->cardlist]);
    			
    	return $dataProvider;
    }
}
