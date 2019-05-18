<?php

namespace common\models;

use backend\models\Gas;
use backend\models\Purpose;
use backend\models\Sewage;
use backend\models\Water;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Area;
use backend\models\RegionKharkivAdmin;
use backend\models\Partsite;
use backend\models\TypeObject;
use backend\models\Course;
use backend\models\Locality;
use backend\models\Mediator;
use backend\models\Region;
use backend\models\RegionKharkiv;
use backend\models\SourceInfo;
use backend\models\Street;

/**
 * AreaSearch represents the model behind the search form about `common\models\Area`.
 */
class AreaSearch extends Area
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'city_or_region', 'locality_id', 'course_id', 'region_id', 'region_kharkiv_id', 'street_id', 'exchange', 'source_info_id', 'mediator_id', 'water_id', 'sewage_id', 'purpose_id', 'gas_id', 'house_demolition', 'exclusive_user_id', 'phone_line', 'state_act', 'electric', 'author_id', 'update_photo_user_id', 'enabled'], 'integer'],
            [['update_author_id', 'region_kharkiv_admin_id', 'type_object_id', 'partsite_id', 'number_building', 'exchange_formula', 'landmark', 'phone', 'comment', 'note', 'notesite', 'date_added', 'date_modified', 'date_modified_photo'], 'safe'],
            [['price', 'total_area'], 'number'],
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
        $query = Area::find();

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
        if(!empty($this->partsite_id)){
            $partsite_id = Partsite::find()->where(['like', 'name', $this->partsite_id])->one()->partsite_id;
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
        if(!empty($this->source_info_id)){
            $source_info_id = SourceInfo::find()->where(['like', 'name', $this->source_info_id])->one()->source_info_id;
        }
        if(!empty($this->mediator_id)){
            $mediator_id = Mediator::find()->where(['like', 'name', $this->mediator_id])->one()->mediator_id;
        }
        if(!empty($this->water_id)){
            $water_id = Water::find()->where(['like', 'name', $this->water_id])->one()->water_id;
        }
        if(!empty($this->sewage_id)){
            $sewage_id = Sewage::find()->where(['like', 'name', $this->sewage_id])->one()->sewage_id;
        }
        if(!empty($this->purpose_id)){
            $purpose_id = Purpose::find()->where(['like', 'name', $this->purpose_id])->one()->purpose_id;
        }
        if(!empty($this->gas_id)){
            $gas_id = Gas::find()->where(['like', 'name', $this->gas_id])->one()->gas_id;
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
            'partsite_id' => $partsite_id,
            'city_or_region' => $this->city_or_region,
            'region_kharkiv_admin_id' => $region_kharkiv_admin_id,
            'locality_id' => $locality_id,
            'course_id' => $course_id,
            'region_id' => $region_id,
            'region_kharkiv_id' => $region_kharkiv_id,
            'street_id' => $street_id,
            'exchange' => $this->exchange,
            'source_info_id' => $source_info_id,
            'price' => $this->price,
            'mediator_id' => $mediator_id,
            'water_id' => $water_id,
            'total_area' => $this->total_area,
            'sewage_id' => $sewage_id,
            'purpose_id' => $purpose_id,
            'gas_id' => $gas_id,
            'house_demolition' => $this->house_demolition,
            'exclusive_user_id' => $exclusive_user_id,
            'phone_line' => $this->phone_line,
            'state_act' => $this->state_act,
            'electric' => $this->electric,
            'date_added' => $this->date_added,
            'date_modified' => $this->date_modified,
            'date_modified_photo' => $this->date_modified_photo,
            'author_id' => $author_id,
            'update_author_id' => $update_author_id,
            'update_photo_user_id' => $update_photo_user_id,
            'enabled' => $this->enabled,
        ]);

        $query->andFilterWhere(['like', 'number_building', $this->number_building])
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
