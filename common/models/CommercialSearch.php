<?php

namespace common\models;

use backend\models\Communication;
use backend\models\Ownership;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Commercial;
use backend\models\Condit;
use backend\models\Course;
use backend\models\Locality;
use backend\models\Mediator;
use backend\models\Region;
use backend\models\RegionKharkiv;
use backend\models\RegionKharkivAdmin;
use backend\models\SourceInfo;
use backend\models\Street;
use backend\models\TypeObject;
/**
 * CommercialSearch represents the model behind the search form about `common\models\Commercial`.
 */
class CommercialSearch extends Commercial
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'count_room', 'ownership_id', 'floor', 'floor_all', 'city_or_region', 'locality_id', 'course_id', 'region_id', 'region_kharkiv_id', 'street_id', 'exchange', 'condit_id', 'source_info_id', 'mediator_id', 'metro_id', 'communication_id', 'exclusive_user_id', 'housing', 'detached_building', 'documents', 'rent', 'topicality', 'avtorampa', 'red_line', 'infinite_period', 'separate_entrance', 'delivered', 'phone_line', 'author_id', 'update_photo_user_id', 'enabled'], 'integer'],
            [['update_author_id', 'region_kharkiv_admin_id', 'type_object_id', 'number_office', 'corps', 'exchange_formula', 'landmark', 'phone', 'comment', 'note', 'notesite', 'date_added', 'date_modified', 'date_modified_photo'], 'safe'],
            [['price', 'price_square_meter', 'total_area_house', 'total_area'], 'number'],
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
        $query = Commercial::find();

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

        if(!empty($this->type_object_id)){
            $type_object_id = TypeObject::find()->where(['like', 'name', $this->type_object_id])->one()->type_object_id;
        }
        if(!empty($this->ownership_id)){
            $ownership_id = Ownership::find()->where(['like', 'name', $this->ownership_id])->one()->ownership_id;
        }
        if(!empty($this->region_kharkiv_admin_id)){
            $region_kharkiv_admin_id = RegionKharkivAdmin::find()->where(['like', 'name', $this->region_kharkiv_admin_id])->one()->region_kharkiv_admin_id;
        }
        if(!empty($this->locality_id)){
            $locality_id = Locality::find()->where(['like', 'name', $this->locality_id])->one()->locality_id;
        }
        if(!empty($this->course_id)){
            $course_id = Course::find()->where(['like', 'name', $this->course_id])->one()->course_id;
        }
        if(!empty($this->region_id)){
            $region_id = Region::find()->where(['like', 'name', $this->region_id])->one()->region_id;
        }
        if(!empty($this->region_kharkiv_id)){
            $region_kharkiv_id = RegionKharkiv::find()->where(['like', 'name', $this->region_kharkiv_id])->one()->region_kharkiv_id;
        }
        if(!empty($this->street_id)){
            $street_id = Street::find()->where(['like', 'name', $this->street_id])->one()->street_id;
        }
        if(!empty($this->condit_id)){
            $condit_id = Condit::find()->where(['like', 'name', $this->condit_id])->one()->condit_id;
        }
        if(!empty($this->source_info_id)){
            $source_info_id = SourceInfo::find()->where(['like', 'name', $this->source_info_id])->one()->source_info_id;
        }
        if(!empty($this->mediator_id)){
            $mediator_id = Mediator::find()->where(['like', 'name', $this->mediator_id])->one()->mediator_id;
        }
        if(!empty($this->metro_id)){
            $metro_id = Metro::find()->where(['like', 'name', $this->metro_id])->one()->metro_id;
        }
        if(!empty($this->communication_id)){
            $communication_id = Communication::find()->where(['like', 'name', $this->communication_id])->one()->communication_id;
        }
        if(!empty($this->exclusive_user_id)){
            $exclusive_user_id = User::find()->where(['like', 'username', $this->exclusive_user_id])->one()->id;
        }
        if(!empty($this->author_id)){
            $author_id = User::find()->where(['like', 'username', $this->author_id])->one()->id;
        }
        if(!empty($this->update_author_id)){
            $update_author_id = User::find()->where(['like', 'username', $this->update_author_id])->one()->id;
        }
        if(!empty($this->update_photo_user_id)){
            $update_photo_user_id = User::find()->where(['like', 'username', $this->update_photo_user_id])->one()->id;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'type_object_id' => $type_object_id,
            'count_room' => $this->count_room,
            'ownership_id' => $ownership_id,
            'floor' => $this->floor,
            'floor_all' => $this->floor_all,
            'city_or_region' => $this->city_or_region,
            'region_kharkiv_admin_id' => $region_kharkiv_admin_id,
            'locality_id' => $locality_id,
            'course_id' => $course_id,
            'region_id' => $region_id,
            'region_kharkiv_id' => $region_kharkiv_id,
            'street_id' => $street_id,
            'exchange' => $this->exchange,
            'condit_id' => $condit_id,
            'source_info_id' => $source_info_id,
            'price' => $this->price,
            'price_square_meter' => $this->price_square_meter,
            'mediator_id' => $mediator_id,
            'metro_id' => $metro_id,
            'total_area_house' => $this->total_area_house,
            'total_area' => $this->total_area,
            'communication_id' => $communication_id,
            'exclusive_user_id' => $exclusive_user_id,
            'housing' => $this->housing,
            'detached_building' => $this->detached_building,
            'documents' => $this->documents,
            'rent' => $this->rent,
            'topicality' => $this->topicality,
            'avtorampa' => $this->avtorampa,
            'red_line' => $this->red_line,
            'infinite_period' => $this->infinite_period,
            'separate_entrance' => $this->separate_entrance,
            'delivered' => $this->delivered,
            'phone_line' => $this->phone_line,
            'date_added' => $this->date_added,
            'date_modified' => $this->date_modified,
            'date_modified_photo' => $this->date_modified_photo,
            'author_id' => $author_id,
            'update_author_id' => $update_author_id,
            'update_photo_user_id' => $update_photo_user_id,
            'enabled' => $this->enabled,
        ]);

        $query->andFilterWhere(['like', 'number_office', $this->number_office])
            ->andFilterWhere(['like', 'corps', $this->corps])
            ->andFilterWhere(['like', 'exchange_formula', $this->exchange_formula])
            ->andFilterWhere(['like', 'landmark', $this->landmark])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'notesite', $this->notesite])
            ->andFilterWhere(['like', 'street', $this->street]);

        return $dataProvider;
    }
}
