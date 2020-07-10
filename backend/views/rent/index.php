<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use backend\models\RegionKharkivAdmin;
use backend\models\TypeObject;
use backend\models\User;
use backend\models\RegionKharkiv;
use backend\models\Street;
use backend\models\Condit;
use backend\models\Comfort;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
\yii\helpers\Url::remember();

$this->title = Yii::t('app', 'Rents');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rent-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="main-content">
        <?php
        $gridColumns = [
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
                    $str = str_replace(' ', ' <br>', $region);
                    return $str;
                },
                'contentOptions' => ['style' => 'max-width: 70px; overflow: hidden' ],
            ],
            [
                'format' => 'html',
                'attribute' => 'street',
                'value' =>  function ($dataProvider) {
                    return $dataProvider->street;
                },
                'contentOptions' => ['style' => 'min-width: 150px; overflow: hidden' ],
            ],
            'number_building',
            'count_room',
            [
                'attribute' => 'count_room_rent',
                'value' =>  function ($dataProvider) {
                    return $dataProvider->count_room_rent;
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
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
                'attribute' => 'price_note',
                //'label' => 'Сост.',
                'value' =>  function ($dataProvider) {
                    return $dataProvider->price_note;
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'attribute' => 'comfort_id',
                'value' => function($dataProvider){
                    return Comfort::findOne(['comfort_id' => $dataProvider->comfort_id])->name;
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'attribute' => 'tv',
                'value' => function($dataProvider){
                    return $dataProvider->tv == '1' ? '+' : '-';
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'attribute' => 'refrigerator',
                'value' => function($dataProvider){
                    return $dataProvider->refrigerator == '1' ? '+' : '-';
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'attribute' => 'entry',
                'value' => function($dataProvider){
                    return $dataProvider->entry == '1' ? '+' : '-';
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'attribute' => 'washer',
                'value' => function($dataProvider){
                    return $dataProvider->washer == '1' ? '+' : '-';
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'attribute' => 'furniture',
                'value' => function($dataProvider){
                    return $dataProvider->furniture == '1' ? '+' : '-';
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'attribute' => 'conditioner',
                'value' => function($dataProvider){
                    return $dataProvider->conditioner == '1' ? '+' : '-';
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'attribute' => 'garage',
                'value' => function($dataProvider){
                    return $dataProvider->garage == '1' ? '+' : '-';
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'attribute' => 'phone_line',
                'value' => function($dataProvider){
                    return $dataProvider->phone_line == '1' ? '+' : '-';
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'format' => 'html',
                'attribute' => 'date_added',
                //'label' => 'Дата добавлeybz',
                'value' =>  function ($dataProvider) {
                    $str = str_replace(' ', ' <br>', $dataProvider->date_added);
                    return $str;
                },
                'contentOptions' => ['style' => 'max-width: 40px; overflow: hidden' ],
            ],
            [
                'format' => 'html',
                'attribute' => 'date_modified',
                'value' =>  function ($dataProvider) {
                    $str = str_replace(' ', ' <br>', $dataProvider->date_modified);
                    return $str;
                },
                'contentOptions' => ['style' => 'max-width: 40px; overflow: hidden' ],
            ],
            [
                'attribute' => 'author_id',
                'value' =>  function ($dataProvider) {
                    return User::findOne($dataProvider->author_id)->username;
                }
            ],
            [
                'format' => 'html',
                'attribute' => 'phone',
                'value' =>  function ($dataProvider) {
                    $str = str_replace(',', ',<br>', $dataProvider->phone);
                    return $str;
                }
            ],
            [
                'format' => 'html',
                'attribute' => 'phone_site',
                'value' =>  function ($dataProvider) {
                    $str = str_replace(',', ',<br>', $dataProvider->phone_site);
                    return $str;
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
                }
            ],
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

        ];
        ?>
        <div class="export">
            <?php
            echo $exportMenu = ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                //'target' => ExportMenu::TARGET_SELF,
                'target' => ExportMenu::TARGET_BLANK,
                'stream' => false,
                'streamAfterSave' => true,
                'noExportColumns' => ['Action Column'],
                //'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => Yii::t('app', 'Export'),
                    'class' => 'btn btn-default',
                ],
                'exportConfig' => [
                    ExportMenu::FORMAT_HTML => false,
                    ExportMenu::FORMAT_CSV => false,
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_PDF => false,
                    //ExportMenu::FORMAT_EXCEL or 'Excel5'
                    //ExportMenu::FORMAT_EXCEL_X or 'Excel2007'
                ]
            ]);
            ?>
        </div>

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
            'columns' => $gridColumns,
            'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>

