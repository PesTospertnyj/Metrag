<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * CustomerSearch represents the model behind the search form about `app\models\Customer`.
 */
class CustomerFind extends Customer
{
    public $id;
    public $id_from;
    public $id_to;
    public $price_from;
    public $price_to;
    public $total_area_from;
    public $total_area_to;
    public $is_public;
    public $full_name;
    public $type;
    public $info;
    public $phone;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'price_from', 'price_to', 'total_area_from', 'total_area_to', 'is_public'], 'integer'],
            [['full_name', 'type', 'info', 'phone'], 'safe'],
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
     * @return ActiveQuery
     */
    public function search($params)
    {
        $query = Customer::find();

        if ($params['regions']) {
            $query = $query->joinWith(['regions' => function($query) use ($params) {
                return $query->where(['in', 'region.region_id', $params['regions']]);
            }]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->getParameter($params, 'id'),
            'is_public' => $this->getParameter($params, 'is_public'),
        ]);

        $query
            ->andFilterWhere(['like', 'full_name', $this->getParameter($params, 'full_name')])
            ->andFilterWhere(['like', 'type', $this->getParameter($params, 'type')])
            ->andFilterWhere(['type' => $this->getParameter($params, 'types')])
            ->andFilterWhere(['like', 'info', $this->getParameter($params, 'info')])
            ->andFilterWhere(['>=', 'id', $this->getParameter($params, 'id_from')])
            ->andFilterWhere(['<=', 'id', $this->getParameter($params, 'id_to')])
            ->andFilterWhere(['>=', 'price_from', $this->getParameter($params, 'price_from')])
            ->andFilterWhere(['<=', 'price_to', $this->getParameter($params, 'price_to')])
            ->andFilterWhere(['>=', 'total_area_from', $this->getParameter($params, 'total_area_from')])
            ->andFilterWhere(['<=', 'total_area_to', $this->getParameter($params, 'total_area_to')])
            ->andFilterWhere(['like', 'phone', $this->getParameter($params, 'phone')]);

        return $query;
    }

    private function getParameter($params, $key)
    {
        if (isset($params[$key])) {
            return $params[$key];
        }

        return null;
    }
}
