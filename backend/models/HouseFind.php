<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\House;

class HouseFind extends House
{
    public $idFrom;
    public $idTo;
    public $count_roomFrom;
    public $count_roomTo;
    public $priceFrom;
    public $priceTo;
    public $floor_allFrom;
    public $floor_allTo;
    public $building_yearFrom;
    public $building_yearTo;
    public $total_areaFrom;
    public $total_areaTo;
    public $total_area_houseFrom;
    public $total_area_houseTo;
    public $date_addedFrom;
    public $date_addedTo;
    public $date_modifiedFrom;
    public $date_modifiedTo;
    public $street;

    public $state_act = '0';
    public $photo_exist = '0';
    public $no_mediators = '0';
    public $exchange = '0';
    public $enabled = '2';
    public $note = '0';


    public function rules()
    {
        return [
            [['id', 'idFrom', 'idTo', 'count_roomFrom', 'count_roomTo', 'priceFrom', 'priceTo', 'floor_allFrom', 'floor_allTo', 'building_yearFrom', 'building_yearTo',
                'total_areaFrom', 'total_areaTo', 'total_area_houseFrom', 'total_area_houseTo', 'type_object_id', 'locality_id', 'course_id', 'region_id', 'region_kharkiv_id', 'region_kharkiv_admin_id', 'street_id',
                'author_id', 'update_author_id', 'update_photo_user_id', 'exclusive_user_id', 'condit_id', 'wall_material_id', 'partsite_id', 'parthouse_id',
                'water_id', 'sewage_id', 'gas_id', 'state_act', 'photo_exist', 'no_mediators', 'exchange', 'enabled', 'note', 'phone'], 'integer'],
            [['phone', 'id', 'street'], 'safe'],
            [['date_addedFrom', 'date_addedTo', 'date_modifiedFrom', 'date_modifiedTo'], 'date'],
        ];
    }

    public function search()
    {
        $get = Yii::$app->request->get('HouseFind');
        $query = House::find();
        //begin filters
        $query->andFilterWhere(['=', 'id', $get['id']]);
        $query->andFilterWhere(['>=', 'id', $get['idFrom']]);
        $query->andFilterWhere(['<=', 'id', $get['idTo']]);
        $query->andFilterWhere(['>=', 'count_room', $get['count_roomFrom']]);
        $query->andFilterWhere(['<=', 'count_room', $get['count_roomTo']]);
        $query->andFilterWhere(['>=', 'price', $get['priceFrom']]);
        $query->andFilterWhere(['<=', 'price', $get['priceTo']]);
        $query->andFilterWhere(['>=', 'floor_all', $get['floor_allFrom']]);
        $query->andFilterWhere(['<=', 'floor_all', $get['floor_allTo']]);
        $query->andFilterWhere(['>=', 'building_year', $get['building_yearFrom']]);
        $query->andFilterWhere(['<=', 'building_year', $get['building_yearTo']]);
        $query->andFilterWhere(['>=', 'total_area', $get['total_areaFrom']]);
        $query->andFilterWhere(['<=', 'total_area', $get['total_areaTo']]);
        $query->andFilterWhere(['>=', 'total_area_house', $get['total_area_houseFrom']]);
        $query->andFilterWhere(['<=', 'total_area_house', $get['total_area_houseTo']]);

        if($get['date_addedFrom']){
            $date = explode('.', $get['date_addedFrom']);
            $date = $date[2].'-'.$date[1].'-'.$date[0]. ' 00:00:00';
            $query->andFilterWhere(['>=', 'date_added', $date]);
        }
        if($get['date_addedTo']){
            $date = explode('.', $get['date_addedTo']);
            $date = $date[2].'-'.$date[1].'-'.$date[0]. ' 23:59:59';
            $query->andFilterWhere(['<=', 'date_added', $date]);
        }
        if($get['date_modifiedFrom']){
            $date = explode('.', $get['date_modifiedFrom']);
            $date = $date[2].'-'.$date[1].'-'.$date[0]. ' 00:00:00';
            $query->andFilterWhere(['>=', 'date_modified', $date]);
        }
        if($get['date_modifiedTo']){
            $date = explode('.', $get['date_modifiedTo']);
            $date = $date[2].'-'.$date[1].'-'.$date[0]. ' 23:59:59';
            $query->andFilterWhere(['<=', 'date_modified', $date]);
        }

        $query->andFilterWhere(['type_object_id' => $get['type_object_id']]);
        $query->andFilterWhere(['region_kharkiv_admin_id' => $get['region_kharkiv_admin_id']]);
        $query->andFilterWhere(['region_kharkiv_id' => $get['region_kharkiv_id']]);
        $query->andFilterWhere(['region_id' => $get['region_id']]);
        $query->andFilterWhere(['locality_id' => $get['locality_id']]);
        $query->andFilterWhere(['course_id' => $get['course_id']]);
        $query->andFilterWhere(['street_id' => $get['street_id']]);
        $query->andFilterWhere(['update_author_id' => $get['update_author_id']]);
        $query->andFilterWhere(['author_id' => $get['author_id']]);
        $query->andFilterWhere(['update_photo_user_id' => $get['update_photo_user_id']]);
        $query->andFilterWhere(['exclusive_user_id' => $get['exclusive_user_id']]);
        $query->andFilterWhere(['condit_id' => $get['condit_id']]);
        $query->andFilterWhere(['wall_material_id' => $get['wall_material_id']]);
        $query->andFilterWhere(['partsite_id' => $get['partsite_id']]);
        $query->andFilterWhere(['parthouse_id' => $get['parthouse_id']]);
        $query->andFilterWhere(['water_id' => $get['water_id']]);
        $query->andFilterWhere(['sewage_id' => $get['sewage_id']]);
        $query->andFilterWhere(['gas_id' => $get['gas_id']]);
        $query->andFilterWhere(['like', 'phone', $get['phone']]);
        $query->andFilterWhere(['street' => $get['street']]);

        if($get['state_act'] == '1' ){
            $query->andWhere(['=', 'state_act', '1']);
        }
        if($get['state_act'] == '2' ){
            $query->andWhere(['=', 'state_act', '0']);
        }

        if($get['no_mediators'] == '1' ){
            $query->andWhere(['is', 'mediator_id', NULL]);
        }
        if($get['no_mediators'] == '2' ){
            $query->andWhere(['not',['mediator_id' => NULL]]);
        }

        if($get['exchange'] == '1' ){
            $query->andWhere(['=', 'exchange', '1']);
        }
        if($get['exchange'] == '2' ){
            $query->andWhere(['=', 'exchange', '0']);
        }

        if($get['enabled'] == '1' ){
            $query->andFilterWhere(['=', 'enabled', '0']);
        }
        if($get['enabled'] == '2' ){
            $query->andFilterWhere(['=', 'enabled', '1']);
        }

        if($get['note'] == 1 ){
            $query->andFilterWhere(['>', 'length(note)', '0']);
        }
        if($get['note'] == 2 ){
            $query->andFilterWhere(['=', 'length(note)', '0']);
        }

        //TODO photo_exist
        /*
        if($get['photo_exist'] == '2'){
            $query->andFilterWhere(['or', 'floor = floor_all', 'floor=1']);
        }
        if($get['photo_exist'] == '1'){
            $query->andFilterWhere(['and', 'floor > 1', 'floor < floor_all']);
        }*/

        return $query;
    }

}

?>