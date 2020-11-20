<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CustomerSearch represents the model behind the search form about `app\models\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'price_from', 'price_to', 'total_area_from', 'total_area_to', 'is_public'], 'integer'],
            [['full_name', 'type', 'info'], 'safe'],
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
        $userId = Yii::$app->user->id;
        $query = Customer::find();
        $role = Yii::$app->authManager->getRolesByUser($userId);
        if(!isset($role['superAdmin'])){
            $query->where(['user_id' => $userId])->orWhere(['is_public' => 1]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
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
            'id' => $this->getParameter($params, 'id'),
            'is_public' => $this->getParameter($params, 'is_public'),
        ]);

        $query->andFilterWhere(['like', 'full_name', $this->getParameter($params, 'full_name')])
            ->andFilterWhere(['like', 'type', $this->getParameter($params, 'type')])
            ->andFilterWhere(['like', 'info', $this->getParameter($params, 'info')])
            ->andFilterWhere(['>=', 'price_from', $this->getParameter($params, 'price_from')])
            ->andFilterWhere(['<=', 'price_to', $this->getParameter($params, 'price_to')])
            ->andFilterWhere(['<=', 'total_area_from', $this->getParameter($params, 'total_area_from')])
            ->andFilterWhere(['<=', 'total_area_to', $this->getParameter($params, 'total_area_to')])
            ->andFilterWhere(['like', 'phone', $this->getParameter($params, 'phone')]);

        return $dataProvider;
    }

    private function getParameter($params, $key)
    {
        if (isset($params[$key])) {
            return $params[$key];
        }

        return null;
    }
}
