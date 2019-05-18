<?php

namespace frontend\models;

use common\models\Addsite;
use Yii;
use yii\base\Model;
use common\models\Area;
use yii\data\ActiveDataProvider;

class AreaSearch extends Area
{
    public $priceFrom;
    public $priceTo;
    public $total_areaFrom;
    public $total_areaTo;

    public $location = '2';

    public function rules()
    {
        return [
            [['location', 'priceFrom', 'priceTo', 'total_areaFrom', 'total_areaTo',
                'type_object_id', 'region_id', 'region_kharkiv_id',], 'integer'],
            [['price'], 'number'],
        ];
    }

    public function search($params)
    {
        $query = Area::find();

        $get = Yii::$app->request->get('AreaSearch');

        //begin filters
        $query->andFilterWhere(['>=', 'price', $get['priceFrom']]);
        $query->andFilterWhere(['<=', 'price', $get['priceTo']]);
        $query->andFilterWhere(['>=', 'total_area', $get['total_areaFrom']]);
        $query->andFilterWhere(['<=', 'total_area', $get['total_areaTo']]);

        $query->andFilterWhere(['type_object_id' => $get['type_object_id']]);
        $query->andFilterWhere(['region_kharkiv_id' => $get['region_kharkiv_id']]);
        $query->andFilterWhere(['region_id' => $get['region_id']]);

        if($get['location'] == '1' ){
            $query->andWhere(['=', 'city_or_region', '1']);
        }
        if($get['location'] == '0' ){
            $query->andWhere(['=', 'city_or_region', '0']);
        }

        $subquery = Addsite::find()->select('idbase')->where(['base' => 'area']);
        $query->andFilterWhere(['in', 'id', $subquery]);

        return $query;
    }

}

?>