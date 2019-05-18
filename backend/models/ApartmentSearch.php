<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Apartment;
use backend\models\Agents;
/**
 * ApartmentSearch represents the model behind the search form about `common\models\Apartment`.
 */
class ApartmentSearch extends Apartment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_object_id', 'count_room', 'layout_id', 'floor', 'floor_all', 'city_or_region', 'region_kharkiv_admin_id', 'locality_id', 'course_id', 'region_id', 'region_kharkiv_id', 'street_id', 'exchange', 'condit_id', 'source_info_id', 'mediator_id', 'metro_id', 'wc_id', 'wall_material_id', 'count_balcony', 'count_balcony_glazed', 'exclusive_user_id', 'phone_line', 'bath', 'author_id', 'update_author_id', 'update_photo_user_id', 'enabled'], 'integer'],
            [['number_building', 'corps', 'number_apartment', 'exchange_formula', 'landmark', 'phone', 'comment', 'note', 'notesite', 'date_added', 'date_modified', 'date_modified_photo', 'street'], 'safe'],
            [['price', 'total_area', 'floor_area', 'kitchen_area'], 'number'],
            [['street'], 'string'],
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
        $query = Apartment::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
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
            'type_object_id' => $this->type_object_id,
            'count_room' => $this->count_room,
            'layout_id' => $this->layout_id,
            'floor' => $this->floor,
            'floor_all' => $this->floor_all,
            'city_or_region' => $this->city_or_region,
            'region_kharkiv_admin_id' => $this->region_kharkiv_admin_id,
            'locality_id' => $this->locality_id,
            'course_id' => $this->course_id,
            'region_id' => $this->region_id,
            'region_kharkiv_id' => $this->region_kharkiv_id,
            'street_id' => $this->street_id,
            'street' => $this->street,
            'exchange' => $this->exchange,
            'condit_id' => $this->condit_id,
            'source_info_id' => $this->source_info_id,
            'price' => $this->price,
            'mediator_id' => $this->mediator_id,
            'metro_id' => $this->metro_id,
            'total_area' => $this->total_area,
            'floor_area' => $this->floor_area,
            'kitchen_area' => $this->kitchen_area,
            'wc_id' => $this->wc_id,
            'wall_material_id' => $this->wall_material_id,
            'count_balcony' => $this->count_balcony,
            'count_balcony_glazed' => $this->count_balcony_glazed,
            'exclusive_user_id' => $this->exclusive_user_id,
            'phone_line' => $this->phone_line,
            'bath' => $this->bath,
            'date_added' => $this->date_added,
            'date_modified' => $this->date_modified,
            'date_modified_photo' => $this->date_modified_photo,
            'author_id' => $this->author_id,
            'update_author_id' => $this->update_author_id,
            'update_photo_user_id' => $this->update_photo_user_id,
            'enabled' => $this->enabled,
        ]);

        $query->andFilterWhere(['like', 'number_building', $this->number_building])
            ->andFilterWhere(['like', 'corps', $this->corps])
            ->andFilterWhere(['like', 'number_apartment', $this->number_apartment])
            ->andFilterWhere(['like', 'exchange_formula', $this->exchange_formula])
            ->andFilterWhere(['like', 'landmark', $this->landmark])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'notesite', $this->notesite]);

        return $dataProvider;
    }
}
