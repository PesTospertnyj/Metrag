<?php

namespace frontend\models;

use common\models\Addsite;
use Yii;
use yii\base\Model;
use common\models\Rent;
use yii\data\ActiveDataProvider;

class RentSearch extends Rent
{
    public $count_roomFrom;
    public $count_roomTo;
    public $priceFrom;
    public $priceTo;
    public $floorFrom;
    public $floorTo;
    public $floor_allFrom;
    public $floor_allTo;

    public $location = '2';

    public function rules()
    {
        return [
            [['location', 'count_roomFrom', 'count_roomTo', 'priceFrom', 'priceTo', 'floorFrom', 'floorTo', 'floor_allFrom', 'floor_allTo',
                'type_object_id', 'region_id', 'region_kharkiv_id',], 'integer'],
            [['price'], 'number'],
        ];
    }

    public function search($params)
    {
        $query = Rent::find();
        $get = Yii::$app->request->get('RentSearch');

        //begin filters
        $query->andFilterWhere(['>=', 'count_room', $get['count_roomFrom']]);
        $query->andFilterWhere(['<=', 'count_room', $get['count_roomTo']]);
        $query->andFilterWhere(['>=', 'price', $get['priceFrom']]);
        $query->andFilterWhere(['<=', 'price', $get['priceTo']]);
        $query->andFilterWhere(['>=', 'floor', $get['floorFrom']]);
        $query->andFilterWhere(['<=', 'floor', $get['floorTo']]);
        $query->andFilterWhere(['>=', 'floor_all', $get['floor_allFrom']]);
        $query->andFilterWhere(['<=', 'floor_all', $get['floor_allTo']]);

        $query->andFilterWhere(['type_object_id' => $get['type_object_id']]);
        $query->andFilterWhere(['region_kharkiv_id' => $get['region_kharkiv_id']]);
        $query->andFilterWhere(['region_id' => $get['region_id']]);

        if($get['location'] == '1' ){
            $query->andWhere(['=', 'city_or_region', '1']);
        }
        if($get['location'] == '0' ){
            $query->andWhere(['=', 'city_or_region', '0']);
        }

        $subquery = Addsite::find()->select('idbase')->where(['base' => 'rent']);
        $query->andFilterWhere(['in', 'id', $subquery]);

        return $query;
    }

}

?>