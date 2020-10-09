<?php

namespace backend\controllers;

use backend\models\ApartmentFind;
use backend\models\Condit;
use backend\models\ModelData;
use backend\models\RegionKharkiv;
use common\models\Apartment;

use common\models\Area;
use common\models\Building;
use common\models\Commercial;
use common\models\House;
use common\models\Rent;
use Yii;
use backend\models\Customer;
use backend\models\CustomerSearch;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerRealtiesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $id = Yii::$app->request->get('id');
        $customer = Customer::find()
            ->where(['id' => $id])
            ->one();

        $conditions = array_map(function ($item) {
            return $item['condit_id'];
        }, $customer->condits);

        $regions = array_map(function ($item) {
            return $item['region_kharkiv_id'];
        }, $customer->regionsKharkiv);

        $localities = array_map(function ($item) {
            return $item['locality_id'];
        }, $customer->localities);

        $viewName = '';
        switch ($customer->type) {
            case 'flats':
                $viewName = 'find-result-flats';
                $query = Apartment::find();
                $query->andFilterWhere(['>=', 'price', $customer->price_from]);
                $query->andFilterWhere(['<=', 'price', $customer->price_to]);
                $query->andFilterWhere(['>=', 'total_area', $customer->total_area_from]);
                $query->andFilterWhere(['<=', 'total_area', $customer->total_area_to]);
                $query->andFilterWhere(['in', 'condit_id', $conditions]);
                $query->andFilterWhere(['=', 'is_publish', 1]);
                if(count($regions) > 0) {
                    $query->andFilterWhere(['in', 'region_kharkiv_id', $regions]);
                }
                else{
                    $query->andFilterWhere(['in', 'locality_id', $localities]);
                }
                break;
            case 'new_buildings':
                $viewName = 'find-result-building';
                $query = Building::find();
                $query->andFilterWhere(['>=', 'price', $customer->price_from]);
                $query->andFilterWhere(['<=', 'price', $customer->price_to]);
                $query->andFilterWhere(['>=', 'total_area', $customer->total_area_from]);
                $query->andFilterWhere(['<=', 'total_area', $customer->total_area_to]);
                $query->andFilterWhere(['in', 'condit_id', $conditions]);
                $query->andFilterWhere(['=', 'is_publish', 1]);
                if(count($regions) > 0) {
                    $query->andFilterWhere(['in', 'region_kharkiv_id', $regions]);
                }
                else{
                    $query->andFilterWhere(['in', 'locality_id', $localities]);
                }
                break;
            case 'houses':
                $viewName = 'find-result-houses';
                $query = House::find();
                $query->andFilterWhere(['>=', 'price', $customer->price_from]);
                $query->andFilterWhere(['<=', 'price', $customer->price_to]);
                $query->andFilterWhere(['>=', 'total_area', $customer->total_area_from]);
                $query->andFilterWhere(['<=', 'total_area', $customer->total_area_to]);
                $query->andFilterWhere(['in', 'condit_id', $conditions]);
                $query->andFilterWhere(['=', 'is_publish', 1]);
                if(count($regions) > 0) {
                    $query->andFilterWhere(['in', 'region_kharkiv_id', $regions]);
                }
                else{
                    $query->andFilterWhere(['in', 'locality_id', $localities]);
                }
                break;
            case 'flats-new_buildings_not_work':
                $viewName = 'find-result-flats';
                $query = Apartment::find();

                $query->from('apartment');
                $query->select([
                    'type_object_id',
                    'region_kharkiv_id',
                    'street_id',
                    'number_building',
                    'count_room',
                    'floor',
                    'floor_all',
                    'total_area',
                    'floor_area',
                    'kitchen_area',
                    'condit_id',
                    'price',
                    'phone',
                     'layout_id'
                ]);
                $query->andFilterWhere(['>=', 'price', $customer->price_from]);
                $query->andFilterWhere(['<=', 'price', $customer->price_to]);
                $query->andFilterWhere(['>=', 'total_area', $customer->total_area_from]);
                $query->andFilterWhere(['<=', 'total_area', $customer->total_area_to]);
                $query->andFilterWhere(['in', 'condit_id', $conditions]);
                $query->andFilterWhere(['=', 'is_publish', 1]);
                if(count($regions) > 0) {
                    $query->andFilterWhere(['in', 'region_kharkiv_id', $regions]);
                }
                else{
                    $query->andFilterWhere(['in', 'locality_id', $localities]);
                }

                $query2 = Building::find();
                $query2->select([
                    'type_object_id',
                    'region_kharkiv_id',
                    'street_id',
                    'number_building',
                    'count_room',
                    'floor',
                    'floor_all',
                    'total_area',
                    'floor_area',
                    'kitchen_area',
                    'condit_id',
                    'price',
                    'phone',
                    'layout_id'
                    ]);
                $query2->from('building');
                $query2->andFilterWhere(['>=', 'price', $customer->price_from]);
                $query2->andFilterWhere(['<=', 'price', $customer->price_to]);
                $query2->andFilterWhere(['>=', 'total_area', $customer->total_area_from]);
                $query2->andFilterWhere(['<=', 'total_area', $customer->total_area_to]);
                $query2->andFilterWhere(['in', 'condit_id', $conditions]);
                $query->andFilterWhere(['=', 'is_publish', 1]);
                if(count($regions) > 0) {
                    $query2->andFilterWhere(['in', 'region_kharkiv_id', $regions]);
                }
                else{
                    $query2->andFilterWhere(['in', 'locality_id', $localities]);
                }
                $query->union($query2);
                break;
            case 'land_plot':
                $viewName = 'find-result-area';
                $query = Area::find();
                $query->andFilterWhere(['>=', 'price', $customer->price_from]);
                $query->andFilterWhere(['<=', 'price', $customer->price_to]);
                $query->andFilterWhere(['>=', 'total_area', $customer->total_area_from]);
                $query->andFilterWhere(['<=', 'total_area', $customer->total_area_to]);
                $query->andFilterWhere(['=', 'is_publish', 1]);
                if(count($regions) > 0) {
                    $query->andFilterWhere(['in', 'region_kharkiv_id', $regions]);
                }
                else{
                    $query->andFilterWhere(['in', 'locality_id', $localities]);
                }
                break;
            case 'commercial':
                $viewName = 'find-result-commercial';
                $query = Commercial::find();
                $query->andFilterWhere(['>=', 'price', $customer->price_from]);
                $query->andFilterWhere(['<=', 'price', $customer->price_to]);
                $query->andFilterWhere(['>=', 'total_area', $customer->total_area_from]);
                $query->andFilterWhere(['<=', 'total_area', $customer->total_area_to]);
                $query->andFilterWhere(['in', 'realty_state_id', $conditions]);
                $query->andFilterWhere(['=', 'is_publish', 1]);
                if(count($regions) > 0) {
                    $query->andFilterWhere(['in', 'region_kharkiv_id', $regions]);
                }
                else{
                    $query->andFilterWhere(['in', 'locality_id', $localities]);
                }
                break;
            case 'rent_house':
                $viewName = 'find-result-rent';
                $query = Rent::find();
                $query->andFilterWhere(['in', 'type_object_id', [5, 7]]);
                $query->andFilterWhere(['>=', 'price', $customer->price_from]);
                $query->andFilterWhere(['<=', 'price', $customer->price_to]);
                $query->andFilterWhere(['in', 'condit_id', $conditions]);
                $query->andFilterWhere(['=', 'is_publish', 1]);
                if(count($regions) > 0) {
                    $query->andFilterWhere(['in', 'region_kharkiv_id', $regions]);
                }
                else{
                    $query->andFilterWhere(['in', 'locality_id', $localities]);
                }
                break;
            case 'rent_flat':
                $viewName = 'find-result-rent';
                $query = Rent::find();
                $query->andFilterWhere(['in', 'type_object_id', [4, 6]]);
                $query->andFilterWhere(['>=', 'price', $customer->price_from]);
                $query->andFilterWhere(['<=', 'price', $customer->price_to]);
                $query->andFilterWhere(['in', 'condit_id', $conditions]);
                $query->andFilterWhere(['=', 'is_publish', 1]);
                if(count($regions) > 0) {
                    $query->andFilterWhere(['in', 'region_kharkiv_id', $regions]);
                }
                else{
                    $query->andFilterWhere(['in', 'locality_id', $localities]);
                }
                break;
            case 'rent_commercial':
                $viewName = 'find-result-rent';
                $query = Rent::find();
                $query->andFilterWhere(['in', 'type_object_id', [11]]);
                $query->andFilterWhere(['>=', 'price', $customer->price_from]);
                $query->andFilterWhere(['<=', 'price', $customer->price_to]);
                $query->andFilterWhere(['in', 'condit_id', $conditions]);
                $query->andFilterWhere(['=', 'is_publish', 1]);
                if(count($regions) > 0) {
                    $query->andFilterWhere(['in', 'region_kharkiv_id', $regions]);
                }
                else{
                    $query->andFilterWhere(['in', 'locality_id', $localities]);
                }
                break;
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);
        $dataProvider->setTotalCount(15);
        return $this->render($viewName, [
            'dataProvider' => $dataProvider,
            'data' => ModelData::getData()
        ]);
    }
}
