<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ApartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use backend\models\RegionKharkivAdmin;
use backend\models\RegionKharkiv;
use backend\models\Layout;
use backend\models\TypeObject;
use backend\models\Users;
use backend\models\Street;
use backend\models\Condit;
use backend\models\WallMaterial;
use backend\models\Mediator;


$this->title = Yii::t('app', 'Apartments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apartment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('yii', 'Create Apartment'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="main-content">

        <?php Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions' => function ($model, $key, $index, $grid)
            {
                if($model->is_active() == false) {
                    return ['style' => 'background-color:#DDA0DD;'];
                }
            },
            'tableOptions' => [
                'class' => 'table table-striped table-bordered',
                'style' => 'font-size: 13px;'
            ],
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],
                ['class' => 'yii\grid\ActionColumn'],
                'id',
                [
                    'attribute' => 'type_object_id',
                    'label' => 'Тип объе-кта',
                    'value' =>  function ($dataProvider) {
                        return TypeObject::findOne($dataProvider->type_object_id)->name;
                    },
                    'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
                ],
                [
                    'format' => 'html',
                    'attribute' => 'region_kharkiv_id',
                    'value' =>  function ($dataProvider) {
                        $region = RegionKharkiv::findOne($dataProvider->region_kharkiv_id)->name;
                        $str = str_replace(' ', '<br>', $region);
                        return $str;
                    },
                    'contentOptions' => ['style' => 'max-width: 70px; overflow: hidden' ],
                ],
                [
                    'format' => 'html',
                    'attribute' => 'street_id',
                    'value' =>  function ($dataProvider) {
                        $street = Street::findOne($dataProvider->street_id)->name;
                        $str = str_replace(' ', '<br>', $street);
                        return $str;
                    },
                    'contentOptions' => ['style' => 'max-width: 70px; overflow: hidden' ],
                ],
                'number_building',
                'count_room',
                [
                    'attribute' => 'floor',
                    'value' =>  function ($dataProvider) {
                        return $dataProvider->floor;
                    },
                    'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
                ],
                [
                    'format' => 'html',
                    'attribute' => 'floor_all',
                    'label' => 'Этаж-ть',
                    'value' =>  function ($dataProvider) {
                        return $dataProvider->floor_all;
                    },
                    'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
                ],
                //'floor',
                //'floor_all',
                [
                    'attribute' => 'total_area',
                    'label' => 'Общая пл',
                    'value' =>  function ($dataProvider) {
                        return $dataProvider->total_area;
                    },
                    'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
                ],
                [
                    'attribute' => 'floor_area',
                    'label' => 'Жилая пл',
                    'value' =>  function ($dataProvider) {
                        return $dataProvider->floor_area;
                    },
                    'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
                ],
                [
                    'attribute' => 'kitchen_area',
                    'label' => 'Кухни пл',
                    'value' =>  function ($dataProvider) {
                        return $dataProvider->kitchen_area;
                    },
                    'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
                ],
                //'total_area',
                //'floor_area',
                //'kitchen_area',
                [
                    'attribute' => 'condit_id',
                    'label' => 'Сост.',
                    'value' =>  function ($dataProvider) {
                        return Condit::findOne($dataProvider->condit_id)->name;
                    },
                    'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
                ],
                'price',
                [
                    'format' => 'html',
                    'attribute' => 'phone',
                    'value' =>  function ($dataProvider) {
                        $str = str_replace(',', '<br>', $dataProvider->phone);
                        return $str;
                    }
                ],
                [
                    'attribute' => 'layout_id',
                    'label' => 'Плани-ровка',
                    'value' =>  function ($dataProvider) {
                        return Layout::findOne($dataProvider->layout_id)->name;
                    },
                    'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
                ],
                [
                    'attribute' => 'wall_material_id',
                    'label' => 'Матер. стен',
                    'value' =>  function ($dataProvider) {
                        return WallMaterial::findOne($dataProvider->wall_material_id)->name;
                    },
                    'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
                ],
                [
                    'attribute' => 'count_balcony',
                    'label' => 'Кол-во балк-в',
                    'value' =>  function ($dataProvider) {
                        return $dataProvider->count_balcony;
                    },
                    'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
                ],
                [
                    'attribute' => 'count_balcony_glazed',
                    'label' => 'Кол-во застекл. балк-в',
                    'value' =>  function ($dataProvider) {
                        return $dataProvider->count_balcony_glazed;
                    },
                    'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
                ],
                //'count_balcony',
                //'count_balcony_glazed',
                [
                    'attribute' => 'mediator_id',
                    'label' => 'Посред-ник',
                    'value' =>  function ($dataProvider) {
                        return Mediator::findOne($dataProvider->mediator_id)->name;
                    },
                    'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
                ],
                [
                    'attribute' => 'author_id',
                    'value' =>  function ($dataProvider) {
                        return Users::findOne($dataProvider->author_id)->name;
                    }
                ],
                [
                    'attribute' => 'exclusive_user_id',
                    'label' => 'Эксклю-зив',
                    'value' =>  function ($dataProvider) {
                        return Users::findOne($dataProvider->exclusive_user_id)->name;
                    }
                ],
                [
                    'label' => 'Фото',
                    'value' =>  function ($dataProvider) {
                        if((bool) array_filter($dataProvider->getImages())){
                            return '+';
                        }else{
                            return '-';
                        }
                        //return var_dump($dataProvider->getImages());
                    }
                ],

                [
                    'format' => 'html',
                    'attribute' => 'date_added',
                    //'label' => 'Дата добавлeybz',
                    'value' =>  function ($dataProvider) {
                        $str = str_replace(' ', '<br>', $dataProvider->date_added);
                        return $str;
                    },
                    'contentOptions' => ['style' => 'max-width: 40px; overflow: hidden' ],
                ],
                //'date_added',
                [
                    'attribute' => 'enabled',
                    'value' => function($model) {
                        return $model->enabled == 0 ? Yii::t('app', 'Archive') : Yii::t('app', 'Active');
                    },
                    'filter' => [
                        0 => Yii::t('app', 'Archive'),
                        1 => Yii::t('app', 'Active')
                    ]
                ],

            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
