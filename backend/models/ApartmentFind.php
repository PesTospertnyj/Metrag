<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Apartment;

class ApartmentFind extends Apartment
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
    public $floor_areaFrom;
    public $floor_areaTo;
    public $kitchen_areaFrom;
    public $kitchen_areaTo;
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

   public function rules()
    {
        return [
            [['id', 'floor', 'idFrom', 'idTo', 'count_roomFrom', 'count_roomTo', 'priceFrom', 'priceTo', 'floorFrom', 'floorTo', 'floor_allFrom', 'floor_allTo',
                'total_areaFrom', 'total_areaTo', 'floor_areaFrom', 'floor_areaTo', 'kitchen_areaFrom', 'kitchen_areaTo', 'middle_floor', 'no_mediators',
                'exchange', 'note', 'type_object_id', 'locality_id', 'course_id', 'region_id', 'region_kharkiv_id', 'region_kharkiv_admin_id', 'street_id', 'condit_id', 'mediator_id',
                'wc_id', 'wall_material_id', 'exclusive_user_id', 'author_id', 'update_author_id', 'update_photo_user_id', 'enabled'], 'integer'],
            [['number_building', 'corps', 'number_apartment', 'exchange_formula', 'landmark', 'phone', 'comment', 'note', 'notesite', 'street'], 'safe'],
            [['price', 'total_area', 'floor_area', 'kitchen_area'], 'number'],
            [['date_added', 'date_modified', 'date_modified_photo', 'date_addedFrom', 'date_addedTo', 'date_modifiedFrom', 'date_modifiedTo'], 'date']
        ];
    }

   public function search()
    {
        $get = Yii::$app->request->get('ApartmentFind');
        $query = Apartment::find();
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
        $query->andFilterWhere(['>=', 'floor_all', $get['floor_allFrom']]);
        $query->andFilterWhere(['<=', 'floor_all', $get['floor_allTo']]);
        $query->andFilterWhere(['>=', 'total_area', $get['total_areaFrom']]);
        $query->andFilterWhere(['<=', 'total_area', $get['total_areaTo']]);
        $query->andFilterWhere(['>=', 'floor_area', $get['floor_areaFrom']]);
        $query->andFilterWhere(['<=', 'floor_area', $get['floor_areaTo']]);
        $query->andFilterWhere(['>=', 'kitchen_area', $get['kitchen_areaFrom']]);
        $query->andFilterWhere(['<=', 'kitchen_area', $get['kitchen_areaTo']]);

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
        $query->andFilterWhere(['wall_material_id' => $get['wall_material_id']]);
        $query->andFilterWhere(['condit_id' => $get['condit_id']]);
        $query->andFilterWhere(['wc_id' => $get['wc_id']]);
        $query->andFilterWhere(['street' => $get['street']]);
        $query->andFilterWhere(['update_author_id' => $get['update_author_id']]);
        $query->andFilterWhere(['author_id' => $get['author_id']]);
        $query->andFilterWhere(['update_photo_user_id' => $get['update_photo_user_id']]);
        $query->andFilterWhere(['exclusive_user_id' => $get['exclusive_user_id']]);
        $query->andFilterWhere(['like', 'phone', $get['phone']]);

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

        return $query;
    }
    
}

?>