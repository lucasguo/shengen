<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Part;
use yii\db\Query;

/**
 * PartSearch represents the model behind the search form about `backend\models\Part`.
 */
class PartSearch extends Part
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'part_type', 'status', 'created_at', 'updated_at'], 'integer'],
            [['part_sn'], 'safe'],
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
         $query = Part::find()->joinWith('partType');

//    	$query = new Query();
//
//    	$query->select("p.*, t.part_name")->from("part p")->leftJoin("part_type t", "p.part_type = t.id");
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        	'sort' => [
        		'attributes' => [
        			'part_type',
        			'part_sn',
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
            'part_type' => $this->part_type,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'part_sn', $this->part_sn]);

        return $dataProvider;
    }
}
