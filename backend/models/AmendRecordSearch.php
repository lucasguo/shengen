<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AmendRecord;

/**
 * AmendRecordSearch represents the model behind the search form about `backend\models\AmendRecord`.
 */
class AmendRecordSearch extends AmendRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'machine_id', 'before_part_id', 'after_part_id', 'ament_type', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['comment'], 'safe'],
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
        $query = AmendRecord::find()->joinWith('oldPart')->joinWith('newPart')->with('machine');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at'=>SORT_ASC],
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
            'machine_id' => $this->machine_id,
            'before_part_id' => $this->before_part_id,
            'after_part_id' => $this->after_part_id,
            'ament_type' => $this->ament_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
