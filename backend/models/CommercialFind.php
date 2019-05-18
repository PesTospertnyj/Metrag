<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Commercial;

class CommercialFind extends Commercial
{
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
    public $total_area_houseFrom;
    public $total_area_houseTo;
    public $date_addedFrom;
    public $date_addedTo;
    public $date_modifiedFrom;
    public $date_modifiedTo;
    public $street;

    public $middle_floor = '0';
    public $no_mediators = '0';
    public $exchange = '0';
    public $enabled = '2';
    public $note = '0';
    public $avtorampa = '0';
    public $red_line = '0';
    public $rent = '0';
    public $detached_building = '0';
    public $separate_entrance = '0';
    public $housing = '0';

    public function rules()
    {
        return [
            [['id', 'idFrom', 'idTo', 'count_roomFrom', 'count_roomTo', 'priceFrom', 'priceTo', 'floorFrom', 'floorTo', 'floor_allFrom', 'floor_allTo',
                'total_areaFrom', 'total_areaTo', 'total_area_houseFrom', 'total_area_houseTo', 'type_object_id', 'locality_id', 'course_id', 'region_id',
                'region_kharkiv_id', 'region_kharkiv_admin_id', 'street_id', 'exclusive_user_id', 'author_id', 'update_author_id', 'update_photo_user_id',
                'condit_id', 'middle_floor', 'no_mediators', 'exchange', 'enabled', 'note', 'avtorampa', 'red_line', 'rent', 'detached_building',
                'separate_entrance', 'housing'], 'integer'],
            [['phone', 'street'], 'safe'],
            [['date_modified_photo', 'date_addedFrom', 'date_addedTo', 'date_modifiedFrom', 'date_modifiedTo'], 'date']
        ];
    }

    public function search()
    {
        $get = Yii::$app->request->get('CommercialFind');
        $query = Commercial::find();
        //begin filters
        $query->andFilterWhere(['=', 'id', $get['id']]);
        $query->andFilterWhere(['>=', 'id', $get['idFrom']]);
        $query->andFilterWhere(['<=', 'id', $get['idTo']]);
        $query->andFilterWhere(['>=', 'count_room', $get['count_roomFrom']]);
        $query->andFilterWhere(['<=', 'count_room', $get['count_roomTo']]);
        $query->andFilterWhere(['>=', 'price', $get['priceFrom']]);
        $query->andFilterWhere(['<=', 'price', $get['priceTo']]);
        $query->andFilterWhere(['>=', 'floor', $get['floorFrom']]);
        $query->andFilterWhere(['<=', 'floor', $get['floorTo']]);
        $query->andFilterWhere(['>=', 'floor', $get['floor_allFrom']]);
        $query->andFilterWhere(['<=', 'floor', $get['floor_allTo']]);
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

        $query->andFilterWhere(['like', 'phone', $get['phone']]);
        $query->andFilterWhere(['street' => $get['street']]);

        if($get['middle_floor'] == '2'){
            $query->andFilterWhere(['or', 'floor = floor_all', 'floor=1']);
        }
        if($get['middle_floor'] == '1'){
            $query->andFilterWhere(['and', 'floor > 1', 'floor < floor_all']);
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

        if($get['avtorampa'] == '1' ){
            $query->andWhere(['=', 'avtorampa', '1']);
        }
        if($get['avtorampa'] == '2' ){
            $query->andWhere(['=', 'avtorampa', '0']);
        }

        if($get['red_line'] == '1' ){
            $query->andWhere(['=', 'red_line', '1']);
        }
        if($get['red_line'] == '2' ){
            $query->andWhere(['=', 'red_line', '0']);
        }

        if($get['rent'] == '1' ){
            $query->andWhere(['=', 'rent', '1']);
        }
        if($get['rent'] == '2' ){
            $query->andWhere(['=', 'rent', '0']);
        }

        if($get['detached_building'] == '1' ){
            $query->andWhere(['=', 'detached_building', '1']);
        }
        if($get['detached_building'] == '2' ){
            $query->andWhere(['=', 'detached_building', '0']);
        }

        if($get['separate_entrance'] == '1' ){
            $query->andWhere(['=', 'separate_entrance', '1']);
        }
        if($get['separate_entrance'] == '2' ){
            $query->andWhere(['=', 'separate_entrance', '0']);
        }

        if($get['housing'] == '1' ){
            $query->andWhere(['=', 'housing', '1']);
        }
        if($get['housing'] == '2' ){
            $query->andWhere(['=', 'housing', '0']);
        }

        return $query;
    }

}

?>