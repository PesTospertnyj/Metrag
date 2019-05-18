<?php

namespace app\modules\parsercd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\parsercd\models\Parsercd;

/**
 * ParsercdSearch represents the model behind the search form about `backend\models\Parsercd`.
 */
class ParsercdSearch extends Parsercd
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['enabled', 'id', 'region_kharkiv_id', 'street_id', 'metro_id', 'type_object_id', 'count_room', 'floor', 'floor_all', 'total_area', 'floor_area', 'kitchen_area', 'price', 'kolfoto'], 'integer'],
            [['link1', 'link2', 'date', 'phone', 'status', 'note', 'image', 'view'], 'safe'],
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
        $query = Parsercd::find()->where(['enabled' => '10']);

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
            'region_kharkiv_id' => $this->region_kharkiv_id,
            'street_id' => $this->street_id,
            'metro_id' => $this->metro_id,
            'type_object_id' => $this->type_object_id,
            'count_room' => $this->count_room,
            'floor' => $this->floor,
            'floor_all' => $this->floor_all,
            'total_area' => $this->total_area,
            'floor_area' => $this->floor_area,
            'kitchen_area' => $this->kitchen_area,
            'price' => $this->price,
            'kolfoto' => $this->kolfoto,
        ]);

        $query->andFilterWhere(['like', 'link1', $this->link1])
            ->andFilterWhere(['like', 'link2', $this->link2])
            ->andFilterWhere(['like', 'link2', $this->link2])
            ->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'view', $this->view]);

        return $dataProvider;
    }
}
