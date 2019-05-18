<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Addsite;

/**
 * AddsiteSearch represents the model behind the search form about `backend\models\Addsite`.
 */
class AddsiteSearch extends Addsite
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idbase', 'user'], 'integer'],
            [['base'], 'safe'],
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
        $query = Addsite::find();

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
            'idbase' => $this->idbase,
            'user' => $this->user,
        ]);

        $query->andFilterWhere(['like', 'base', $this->base]);

        return $dataProvider;
    }
}
