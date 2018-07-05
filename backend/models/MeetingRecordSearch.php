<?php

namespace backend\models;

use yii\db\Query;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MeetingRecord;

/**
 * MeetingRecordSearch represents the model behind the search form about `backend\models\MeetingRecord`.
 */
class MeetingRecordSearch extends MeetingRecord
{
	public $username;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['meeting_date', 'file_path'], 'safe'],
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
//         $query = MeetingRecord::find();
		$query = (new Query())->select("m.*, u.username")
				->from("meeting_record m")
				->leftJoin("user u", "m.created_by = u.id");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'key' => 'id',
            'query' => $query,
        	'sort' => [
        		'defaultOrder' => ['created_at'=>SORT_DESC],
        		'attributes' => [
        			'created_at',
        			'username',
        			'file_type',
        			'topic',
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
            'meeting_date' => $this->meeting_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'file_path', $this->file_path]);
        $query->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
