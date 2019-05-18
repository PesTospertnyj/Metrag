<?php

namespace frontend\models;

use common\models\Addsite;
use Yii;
use yii\base\Model;
use common\models\House;
use yii\data\ActiveDataProvider;

class HouseSearch extends House
{
    public $priceFrom;
    public $priceTo;
    public $total_areaFrom;
    public $total_areaTo;
    public $total_area_houseFrom;
    public $total_area_houseTo;

    public $location = '2';

    public function rules()
    {
        return [
            [['location', 'count_roomFrom', 'count_roomTo', 'priceFrom', 'priceTo', 'total_areaFrom', 'total_areaTo', 'total_area_houseFrom', 'total_area_houseTo',
                'type_object_id', 'region_id', 'region_kharkiv_id',], 'integer'],
            [['price'], 'number'],
        ];
    }

    public function search($params)
    {
        $query = House::find();

        $get = Yii::$app->request->get('HouseSearch');

        //begin filters
        $query->andFilterWhere(['>=', 'price', $get['priceFrom']]);
        $query->andFilterWhere(['<=', 'price', $get['priceTo']]);
        $query->andFilterWhere(['>=', 'total_area', $get['total_areaFrom']]);
        $query->andFilterWhere(['<=', 'total_area', $get['total_areaTo']]);
        $query->andFilterWhere(['>=', 'total_area_house', $get['total_area_houseFrom']]);
        $query->andFilterWhere(['<=', 'total_area_house', $get['total_area_houseTo']]);

        $query->andFilterWhere(['type_object_id' => $get['type_object_id']]);
        $query->andFilterWhere(['region_kharkiv_id' => $get['region_kharkiv_id']]);
        $query->andFilterWhere(['region_id' => $get['region_id']]);

        if($get['location'] == '1' ){
            $query->andWhere(['=', 'city_or_region', '1']);
        }
        if($get['location'] == '0' ){
            $query->andWhere(['=', 'city_or_region', '0']);
        }

        $subquery = Addsite::find()->select('idbase')->where(['base' => 'house']);
        $query->andFilterWhere(['in', 'id', $subquery]);

        return $query;
    }

}

?>