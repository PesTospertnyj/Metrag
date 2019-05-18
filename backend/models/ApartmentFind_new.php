<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Apartment;
use yii\data\ActiveDataProvider;

class ApartmentFind extends Apartment
{
	public $id;
    public $idFrom;
    public $idTo;
    public $count_roomFrom;
    public $count_roomTo;
    public $priceFrom;
    public $priceTo;
    public $floorFrom;
    public $floorTo;
    public $floor_allFrom;
    public $floor_allTo;
    public $total_areaFrom;
    public $total_areaTo;
    public $floor_areaFrom;
    public $floor_areaTo;
    public $kitchen_areaFrom;
    public $kitchen_areaTo;
	public $date_addedFrom;
    public $date_addedTo;

    public $city_or_region = '0';
    
    public $image;
    public $imageFiles;
    public $file;
    public $del_img;

    public $middle_floor = '2';
    public $no_mediators = '2';
    public $exchange = '2';
    public $enabled = '1';
    public $note = '2';
    public $phone;

    public function rules()
    {
        return [
            [['id', 'type_object_id', 'count_room', 'layout_id', 'floor', 'floor_all', 'city_or_region',  'locality_id', 'course_id', 'region_id', 'region_kharkiv_id', 'street_id', 'exchange', 'condit_id', 'source_info_id', 'mediator_id', 'metro_id', 'wc_id', 'wall_material_id', 'count_balcony', 'count_balcony_glazed', 'exclusive_user_id', 'phone_line', 'bath', 'author_id', 'update_author_id', 'update_photo_user_id', 'enabled'], 'integer'],
            [['number_building', 'corps', 'number_apartment', 'exchange_formula', 'landmark', 'phone', 'comment', 'note', 'notesite', 'date_added', 'date_modified', 'date_modified_photo'], 'safe'],
            [['price', 'total_area', 'floor_area', 'kitchen_area'], 'number'],
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
        //$get = Yii::$app->request->get();

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
        //$query->andFilterWhere([
            /*'id' => $this->id,
            'type_object_id' => $this->type_object_id,
            'count_room' => $this->count_room,
            'layout_id' => $this->layout_id,
            'floor' => $this->floor,
            'floor_all' => $this->floor_all,
            'city_or_region' => $this->city_or_region,*/
            /*'region_kharkiv_admin_id' => $this->region_kharkiv_admin_id,
            'locality_id' => $this->locality_id,
            'course_id' => $this->course_id,
            'region_id' => $this->region_id,
            'region_kharkiv_id' => $this->region_kharkiv_id,
            'street_id' => $this->street_id,
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
            'enabled' => $this->enabled,*/
            //]);
        
        $query->andFilterWhere(['>=', 'id', $params['ApartmentFind']['idFrom']]);
        if(!empty($get['ApartmentFind']['idTo']))
        $query->andFilterWhere(['<=', 'id', $get['ApartmentFind']['idTo']]);
        if(!empty($get['ApartmentFind']['count_roomFrom']))
        $query->andFilterWhere(['>=', 'count_room', $get['ApartmentFind']['count_roomFrom']]);
        if(!empty($get['ApartmentFind']['count_roomTo']))
        $query->andFilterWhere(['<=', 'count_room', $get['ApartmentFind']['count_roomTo']]);
        if(!empty($get['ApartmentFind']['priceFrom']))
        $query->andFilterWhere(['>=', 'price', $get['ApartmentFind']['priceFrom']]);
        if(!empty($get['ApartmentFind']['priceTo']))
        $query->andFilterWhere(['<=', 'price', $get['ApartmentFind']['priceTo']]);
        if(!empty($get['ApartmentFind']['floorFrom']))
        $query->andFilterWhere(['>=', 'floor', $get['ApartmentFind']['floorFrom']]);
        if(!empty($get['ApartmentFind']['floorTo']))
        $query->andFilterWhere(['<=', 'floor', $get['ApartmentFind']['floorTo']]);
        if(!empty($get['ApartmentFind']['floorFrom']))
        $query->andFilterWhere(['>=', 'floor', $get['ApartmentFind']['floorFrom']]);
        if(!empty($get['ApartmentFind']['floorTo']))
        $query->andFilterWhere(['<=', 'floor', $get['ApartmentFind']['floorTo']]);
        if(!empty($get['ApartmentFind']['total_areaFrom']))
        $query->andFilterWhere(['>=', 'total_area', $get['ApartmentFind']['total_areaFrom']]);
        if(!empty($get['ApartmentFind']['total_areaTo']))
        $query->andFilterWhere(['<=', 'total_area', $get['ApartmentFind']['total_areaTo']]);
        if(!empty($get['ApartmentFind']['floor_areaFrom']))
        $query->andFilterWhere(['>=', 'floor_area', $get['ApartmentFind']['floor_areaFrom']]);
        if(!empty($get['ApartmentFind']['floor_areaTo']))
        $query->andFilterWhere(['<=', 'floor_area', $get['ApartmentFind']['floor_areaTo']]);
        if(!empty($get['ApartmentFind']['kitchen_areaFrom']))
        $query->andFilterWhere(['>=', 'kitchen_area', $get['ApartmentFind']['kitchen_areaFrom']]);
        if(!empty($get['ApartmentFind']['kitchen_areaTo']))
        $query->andFilterWhere(['<=', 'kitchen_area', $get['ApartmentFind']['kitchen_areaTo']]);
        //if(!empty($get['ApartmentFind']['date_addedFrom']))
        //        $query->andFilterWhere(['>=', 'date_added', $get['ApartmentFind']['kitchen_areaFrom']]);
        //if(!empty($get['ApartmentFind']['date_addedTo']))
        //        $query->andFilterWhere(['<=', 'date_added', $get['ApartmentFind']['date_addedTo']]);
        
        if(!empty($get['ApartmentFind']['date_addedFrom']))
                $query->andFilterWhere(['>=', 'date_added', Yii::$app->formatter->asDateTime($get['ApartmentFind']['date_addedFrom'], 'yyyy-MM-dd HH:mm:ss')]);
        if(!empty($get['ApartmentFind']['date_addedTo']))
                $query->andFilterWhere(['<=', 'date_added', Yii::$app->formatter->asDateTime($get['ApartmentFind']['date_addedTo'], 'yyyy-MM-dd HH:mm:ss')]);

        //if(!empty($get['TypeObject']['type_object_id']))
        //$query->andwhere(['type_object_id' => $get['TypeObject']['type_object_id']]);
        if(!empty($get['ApartmentFind']['type_object_id']))
        $query->andwhere(['type_object_id' => $get['ApartmentFind']['type_object_id']]);
        

        if(!empty($get['RegionKharkivAdmin']['region_kharkiv_admin_id']))
        $query->andwhere(['region_kharkiv_admin_id' => $get['RegionKharkivAdmin']['region_kharkiv_admin_id']]);
        if(!empty($get['RegionKharkiv']['region_kharkiv_id']))
        $query->andwhere(['region_kharkiv_id' => $get['RegionKharkiv']['region_kharkiv_id']]);
        if(!empty($get['Region']['region_id']))
        $query->andwhere(['region_id' => $get['Region']['region_id']]);
        if(!empty($get['Locality']['locality_id']))
        $query->andwhere(['locality_id' => $get['Locality']['locality_id']]);
        if(!empty($get['Course']['course_id']))
        $query->andwhere(['course_id' => $get['Course']['course_id']]);
        if(!empty($get['Street']['street_id']))
        $query->andwhere(['street_id' => $get['Street']['street_id']]);
        if(!empty($get['WallMaterial']['wall_material_id']))
        $query->andwhere(['wall_material_id' => $get['WallMaterial']['wall_material_id']]);
        if(!empty($get['Condit']['condit_id']))
        $query->andwhere(['condit_id' => $get['Condit']['condit_id']]);
        if(!empty($get['Wc']['wc_id']))
        $query->andwhere(['wc_id' => $get['Wc']['wc_id']]);
        if(!empty($get['Users']['update_author_id']))
        $query->andwhere(['update_author_id' => $get['Users']['update_author_id']]);
        if(!empty($get['Users']['author_id']))
        $query->andwhere(['author_id' => $get['Users']['author_id']]);
        if(!empty($get['Users']['update_photo_user_id']))
        $query->andwhere(['update_photo_user_id' => $get['Users']['update_photo_user_id']]);
        if(!empty($get['Users']['exclusive_user_id']))
        $query->andwhere(['exclusive_user_id' => $get['Users']['exclusive_user_id']]);
        
        if($get['ApartmentFind']['middle_floor'] == '0'){
            $query->andWhere(['floor' => '1']);    
            //$query->orWhere(['like', 'floor', apartment.floor_all]);    
        }
        return $dataProvider;
    }
}

?>