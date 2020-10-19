<?
use yii\helpers\Url;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use kartik\export\ExportMenu;
//use kartik\grid\GridView;
use yii\grid\GridView;

use backend\models\RegionKharkivAdmin;
use backend\models\Layout;
use backend\models\TypeObject;
use backend\models\User;
use backend\models\RegionKharkiv;
use backend\models\Street;
use backend\models\Condit;
use backend\models\WallMaterial;
use backend\models\Mediator;
use backend\models\Parthouse;
use backend\models\Partsite;
use backend\models\Comfort;
use backend\models\Gas;
use backend\models\Water;
use backend\models\Sewage;
?>
<?php
$url = explode('/admin/customer/searchresult', Url::current());
$get = $url[1];
$currentParams = Yii::$app->getRequest()->getQueryParams();

$statuses = [
        0 => '',
        1 => 'Топ',
        2 => 'Премиум',
        3 => 'Проданно',
];
?>

<div class="main-content">
    <?php
    $gridColumns = [
        //['class' => 'yii\grid\SerialColumn'],
        'id',
        [
            'label' => 'ФИО',
            'value' => 'full_name',
        ],

        [
            'label' => 'Телефон',
            'value' => 'phone',
        ],

        [
            'label' => 'Цена От',
            'value' => 'price_from',
        ],

        [
            'label' => 'Цена До',
            'value' => 'price_to',
        ],
        [
            'label' => 'Тип',
            'value' => function ($model) {
                return \backend\models\Customer::AVAILABLE_TYPES_LABELS[$model->type];
            }
        ],
        [
            'label' => 'Старые/Новые',
            'format' => 'raw',
            'value' => function($model) {
                $viewedAds = Html::a(
                    $model->viewedCount,
                    Url::to(['/customer-realties/OldAdverts', 'id' => $model->id]),
                    [
                        'title' => 'Перейти на недвижимость покупателя',
                        'target' => '_blank',
                        'style' => 'color:red;'
                    ]
                );
                $notViewed = Html::a(
                    $model->notViewedCount,
                    Url::to(['/customer-realties', 'id' => $model->id]),
                    [
                        'title' => 'Перейти на недвижимость покупателя',
                        'target' => '_blank',
                        'style' => 'color:red;'
                    ]
                );
                return $viewedAds.'/'.$notViewed;
            }
        ],
        // 'total_area_from',
        // 'total_area_to',
        // 'info:ntext',
        // 'is_public',

        ['class' => 'yii\grid\ActionColumn'],
    ];
    ?>


        <a href="<?= Url::base(true);?>/customer/search<?= $get;?>" class="btn btn-default">Вернуться к поиску</a>

    </div>

    <?php echo \nterms\pagesize\PageSize::widget(['defaultPageSize' => '10', 'label' => 'Количество результатов на страницу']); ?>
    <?php

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterSelector' => 'select[name="per-page"]',
        //'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid)
        {
        },
        'tableOptions' => [
            'class' => 'table table-striped table-bordered',
            'style' => 'font-size: 13px;'
        ],
        'columns' => $gridColumns,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],

    ]);
    ?>

    <?php \yii\helpers\Url::remember(); ?>
</div>



