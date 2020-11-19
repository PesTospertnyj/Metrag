<?php

namespace backend\controllers;

use backend\models\CustomerFind;
use backend\models\CustomerLocation;
use backend\models\HouseFind;
use backend\models\ModelData;
use backend\models\WallMaterial;
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
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
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
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        foreach ($dataProvider->models as $model) {
            $viewedAdsCount = $this->getCountCustomerAdverts($model);
            $allAdsCount = $this->getTotalCountCustomerAdverts($model);
            $notViewedAdsCount = $allAdsCount >= $viewedAdsCount ? $allAdsCount - $viewedAdsCount : $allAdsCount;
            $model->viewedCount = $viewedAdsCount;
            $model->notViewedCount = $notViewedAdsCount;
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $user = Yii::$app->getUser();
        $model = new Customer();
        $model->user_id = $user->id;
        if ($model->load(Yii::$app->request->post(), null, true)) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            if ($model->localities) {
                switch ($model->type) {
                    case 'flats':
                        $model->city_or_region = 0;
                        break;
                    case 'new_buildings':
                        $model->city_or_region = 0;
                        break;
                    case 'flats-new_buildings':
                        $model->city_or_region = 0;
                        break;
                    case 'houses':
                        $model->city_or_region = 1;
                        break;
                    case 'land_plot':
                        $model->city_or_region = 1;
                        break;
                    case 'rent_house':
                        $model->city_or_region = 1;
                        break;
                    case 'commercial':
                        $model->city_or_region = 0;
                        break;
                    case 'rent_flat':
                        $model->city_or_region = 0;
                        break;
                    case 'rent_commercial':
                        $model->city_or_region = 0;
                        break;
                }
            }
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSearch()
    {
        // fill with previous values
        $values = Yii::$app->request->get('HouseFind');
        $model = new CustomerFind();
        $model->attributes = $values;
        return $this->render('find', ['model' => $model]);
    }

    public function actionSearchresult()
    {
        $model = new CustomerFind();
        $query = $model->search(Yii::$app->request->get('CustomerFind'));
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);
        foreach ($dataProvider->models as $model) {
            $viewedAdsCount = $this->getCountCustomerAdverts($model);
            $allAdsCount = $this->getTotalCountCustomerAdverts($model);
            $notViewedAdsCount = $allAdsCount >= $viewedAdsCount ? $allAdsCount - $viewedAdsCount : $allAdsCount;
            $model->viewedCount = $viewedAdsCount;
            $model->notViewedCount = $notViewedAdsCount;
        }
        return $this->render('find-result', [
            'dataProvider' => $dataProvider,
            'data' => ModelData::getData()
        ]);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function getCountCustomerAdverts($customer)
    {
        return count($customer->customerViewedAd);
    }

    private function getTotalCountCustomerAdverts($customer)
    {
        $conditions = array_map(function ($item) {
            return $item['condit_id'];
        }, $customer->condits);

        $regions = array_map(function ($item) {
            return $item['region_kharkiv_id'];
        }, $customer->regionsKharkiv);

        $localities = array_map(function ($item) {
            return $item['locality_id'];
        }, $customer->localities);

        switch ($customer->type) {
            case 'flats':
                $query = Apartment::find();
                $query->andFilterWhere(['>=', 'price', $customer->price_from]);
                $query->andFilterWhere(['<=', 'price', $customer->price_to]);
                $query->andFilterWhere(['>=', 'total_area', $customer->total_area_from]);
                $query->andFilterWhere(['<=', 'total_area', $customer->total_area_to]);
                $query->andFilterWhere(['in', 'condit_id', $conditions]);
                if (count($regions) > 0) {
                    $query->andFilterWhere(['in', 'region_kharkiv_id', $regions]);
                } else {
                    $query->andFilterWhere(['in', 'locality_id', $localities]);
                }
                break;
            case 'new_buildings':
                $query = Building::find();
                $query->andFilterWhere(['>=', 'price', $customer->price_from]);
                $query->andFilterWhere(['<=', 'price', $customer->price_to]);
                $query->andFilterWhere(['>=', 'total_area', $customer->total_area_from]);
                $query->andFilterWhere(['<=', 'total_area', $customer->total_area_to]);
                $query->andFilterWhere(['in', 'condit_id', $conditions]);
                if (count($regions) > 0) {
                    $query->andFilterWhere(['in', 'region_kharkiv_id', $regions]);
                } else {
                    $query->andFilterWhere(['in', 'locality_id', $localities]);
                }
                break;
            case 'houses':
                $query = House::find();
                $query->andFilterWhere(['>=', 'price', $customer->price_from]);
                $query->andFilterWhere(['<=', 'price', $customer->price_to]);
                $query->andFilterWhere(['>=', 'total_area', $customer->total_area_from]);
                $query->andFilterWhere(['<=', 'total_area', $customer->total_area_to]);
                $query->andFilterWhere(['in', 'condit_id', $conditions]);
                if (count($regions) > 0) {
                    $query->andFilterWhere(['in', 'region_kharkiv_id', $regions]);
                } else {
                    $query->andFilterWhere(['in', 'locality_id', $localities]);
                }
                break;
            case 'flats-new_buildings':
                $query = Apartment::find();

                $query->from('apartment');
                $query->select([
                    'id',
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
                    'layout_id',
                    'enabled'
                ]);
                $query->andFilterWhere(['>=', 'price', $customer->price_from]);
                $query->andFilterWhere(['<=', 'price', $customer->price_to]);
                $query->andFilterWhere(['>=', 'total_area', $customer->total_area_from]);
                $query->andFilterWhere(['<=', 'total_area', $customer->total_area_to]);
                $query->andFilterWhere(['in', 'condit_id', $conditions]);
                $query->andFilterWhere(['=', 'enabled', 1]);
                if (count($regions) > 0) {
                    $query->andFilterWhere(['in', 'region_kharkiv_id', $regions]);
                } else {
                    $query->andFilterWhere(['in', 'locality_id', $localities]);
                }

                $query2 = Building::find();
                $query2->select([
                    'id',
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
                    'layout_id',
                    'enabled'
                ]);
                $query2->from('building');
                $query2->andFilterWhere(['>=', 'price', $customer->price_from]);
                $query2->andFilterWhere(['<=', 'price', $customer->price_to]);
                $query2->andFilterWhere(['>=', 'total_area', $customer->total_area_from]);
                $query2->andFilterWhere(['<=', 'total_area', $customer->total_area_to]);
                $query2->andFilterWhere(['in', 'condit_id', $conditions]);
                $query2->andFilterWhere(['=', 'enabled', 1]);
                if (count($regions) > 0) {
                    $query2->andFilterWhere(['in', 'region_kharkiv_id', $regions]);
                } else {
                    $query2->andFilterWhere(['in', 'locality_id', $localities]);
                }
                $query->union($query2);
                break;
            case 'land_plot':
                $query = Area::find();
                $query->andFilterWhere(['>=', 'price', $customer->price_from]);
                $query->andFilterWhere(['<=', 'price', $customer->price_to]);
                $query->andFilterWhere(['>=', 'total_area', $customer->total_area_from]);
                $query->andFilterWhere(['<=', 'total_area', $customer->total_area_to]);
                if (count($regions) > 0) {
                    $query->andFilterWhere(['in', 'region_kharkiv_id', $regions]);
                } else {
                    $query->andFilterWhere(['in', 'locality_id', $localities]);
                }
                break;
            case 'commercial':
                $query = Commercial::find();
                $query->andFilterWhere(['>=', 'price', $customer->price_from]);
                $query->andFilterWhere(['<=', 'price', $customer->price_to]);
                $query->andFilterWhere(['>=', 'total_area', $customer->total_area_from]);
                $query->andFilterWhere(['<=', 'total_area', $customer->total_area_to]);
                $query->andFilterWhere(['in', 'realty_state_id', $conditions]);
                if (count($regions) > 0) {
                    $query->andFilterWhere(['in', 'region_kharkiv_id', $regions]);
                } else {
                    $query->andFilterWhere(['in', 'locality_id', $localities]);
                }
                break;
            case 'rent_house':
                $query = Rent::find();
                $query->andFilterWhere(['in', 'type_object_id', [5, 7]]);
                $query->andFilterWhere(['>=', 'price', $customer->price_from]);
                $query->andFilterWhere(['<=', 'price', $customer->price_to]);
                $query->andFilterWhere(['in', 'condit_id', $conditions]);
                if (count($regions) > 0) {
                    $query->andFilterWhere(['in', 'region_kharkiv_id', $regions]);
                } else {
                    $query->andFilterWhere(['in', 'locality_id', $localities]);
                }
                break;
            case 'rent_flat':
                $query = Rent::find();
                $query->andFilterWhere(['in', 'type_object_id', [4, 6]]);
                $query->andFilterWhere(['>=', 'price', $customer->price_from]);
                $query->andFilterWhere(['<=', 'price', $customer->price_to]);
                $query->andFilterWhere(['in', 'condit_id', $conditions]);
                if (count($regions) > 0) {
                    $query->andFilterWhere(['in', 'region_kharkiv_id', $regions]);
                } else {
                    $query->andFilterWhere(['in', 'locality_id', $localities]);
                }
                break;
            case 'rent_commercial':
                $query = Rent::find();
                $query->andFilterWhere(['in', 'type_object_id', [11]]);
                $query->andFilterWhere(['>=', 'price', $customer->price_from]);
                $query->andFilterWhere(['<=', 'price', $customer->price_to]);
                $query->andFilterWhere(['in', 'condit_id', $conditions]);
                if (count($regions) > 0) {
                    $query->andFilterWhere(['in', 'region_kharkiv_id', $regions]);
                } else {
                    $query->andFilterWhere(['in', 'locality_id', $localities]);
                }
                break;
        }
        $query->andFilterWhere(['=', 'enabled', 1]);

        return $query->count();
    }
}
