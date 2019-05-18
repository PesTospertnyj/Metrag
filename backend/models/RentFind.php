<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Rent;

class RentFind extends Rent
{
    public $idFrom;
    public $idTo;
    public $count_roomFrom;
    public $count_roomTo;
    public $count_room_rentFrom;
    public $count_room_rentTo;
    public $priceFrom;
    public $priceTo;
    public $floorFrom;
    public $floorTo;
    public $floor_allFrom;
    public $floor_allTo;
    public $date_addedFrom;
    public $date_addedTo;
    public $date_modifiedFrom;
    public $date_modifiedTo;
    public $street;
    public $enabled = '2';
    public $note = '0';

    public function rules()
    {
        return [
            [['id', 'idFrom', 'idTo', 'count_roomFrom', 'count_roomTo', 'count_room_rentFrom', 'count_room_rentTo',
                'priceFrom', 'priceTo', 'floorFrom', 'floorTo', 'floor_allFrom', 'floor_allTo', 'type_object_id',
                'locality_id', 'course_id', 'region_id', 'region_kharkiv_id', 'region_kharkiv_admin_id', 'street_id',
                'author_id', 'update_author_id', 'update_photo_user_id', 'condit_id', 'enabled', 'note'], 'integer'],
            [['phone', 'landmark', 'price_note', 'street'], 'safe'],
            [['date_addedFrom', 'date_addedTo', 'date_modifiedFrom', 'date_modifiedTo', 'date_modified', 'date_modified_photo'], 'date']
        ];
    }

    public function search()
    {
        $get = Yii::$app->request->get('RentFind');
        $query = Rent::find();
        //begin filters
        $query->andFilterWhere(['=', 'id', $get['id']]);
        $query->andFilterWhere(['>=', 'id', $get['idFrom']]);
        $query->andFilterWhere(['<=', 'id', $get['idTo']]);
        $query->andFilterWhere(['>=', 'count_room', $get['count_roomFrom']]);
        $query->andFilterWhere(['<=', 'count_room', $get['count_roomTo']]);
        $query->andFilterWhere(['>=', 'count_room', $get['count_room_rentFrom']]);
        $query->andFilterWhere(['<=', 'count_room', $get['count_room_rentTo']]);
        $query->andFilterWhere(['>=', 'price', $get['priceFrom']]);
        $query->andFilterWhere(['<=', 'price', $get['priceTo']]);
        $query->andFilterWhere(['>=', 'floor', $get['floorFrom']]);
        $query->andFilterWhere(['<=', 'floor', $get['floorTo']]);
        $query->andFilterWhere(['>=', 'floor', $get['floor_allFrom']]);
        $query->andFilterWhere(['<=', 'floor', $get['floor_allTo']]);

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
        $query->andFilterWhere(['condit_id' => $get['condit_id']]);

        $query->andFilterWhere(['like', 'phone', $get['phone']]);
        $query->andFilterWhere(['street' => $get['street']]);

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
        $query->andFilterWhere(['like', 'landmark', $get['landmark']]);
        $query->andFilterWhere(['like', 'price_note', $get['price_note']]);

        return $query;
    }

}

?>