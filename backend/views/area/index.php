<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\RegionKharkiv;
use backend\models\Partsite;
use backend\models\TypeObject;
use backend\models\User;
use kartik\export\ExportMenu;
use backend\models\Street;
use backend\models\Purpose;
use backend\models\Mediator;
use backend\models\Gas;
use backend\models\Sewage;
use backend\models\Water;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AreaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\yii\helpers\Url::remember();

$this->title = Yii::t('app', 'Areas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-content">
    <?php
    $gridColumns = [
        //['class' => 'yii\grid\SerialColumn'],
        [
            'class' => 'yii\grid\ActionColumn',
            'controller' => 'area',
            'buttons' => [
                'update' => function ($url,$model) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-pencil"></span>',
                        $url,
                        [
                            'title' => Yii::t('app', 'Edit'),

                        ]);
                },

            ],
        ],
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
                return /*$str*/$region;
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
        [
            'attribute' => 'partsite_id',
            'value' =>  function ($dataProvider) {
                return Partsite::findOne(['partsite_id' => $dataProvider->partsite_id])->name; ;
            },
            'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
        ],
        [
            'attribute' => 'total_area',
            'label' => 'Общая пл',
            'value' =>  function ($dataProvider) {
                return (int)$dataProvider->total_area;
            },
            'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
        ],
        'price',
        [
            'format' => 'html',
            'attribute' => 'phone',
            'value' =>  function ($dataProvider) {
                //$str = str_replace(',', ',<br>', $dataProvider->phone);
                $str = strpos($dataProvider->phone, ",") === false ? $dataProvider->phone :
                    substr($dataProvider->phone,0,strpos($dataProvider->phone, ","));

                //$str = (($pos=strpos($dataProvider->phone, ",")==false)?strlen($dataProvider->phone):$pos);
                return $str/*$dataProvider->phone*/;
            }
        ],
        [
            'attribute' => 'gas_id',
            'value' =>  function ($dataProvider) {
                return Gas::findOne($dataProvider->gas_id)->name;
            },
            'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
        ],
        [
            'attribute' => 'water_id',
            'value' =>  function ($dataProvider) {
                return Water::findOne($dataProvider->water_id)->name;
            },
            'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
        ],
        [
            'attribute' => 'phone_line',
            'value' =>  function ($dataProvider) {
                if($dataProvider->phone_line == '1') return '+';
                else return '-';
            },
            'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
        ],
        [
            'attribute' => 'gas_id',
            'value' =>  function ($dataProvider) {
                return Gas::findOne(['gas_id' => $dataProvider->gas_id])->name;
            },
            'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
        ],
        [
            'attribute' => 'water_id',
            'value' =>  function ($dataProvider) {
                return Water::findOne(['water_id' => $dataProvider->water_id])->name;
            },
            'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
        ],
        [
            'attribute' => 'sewage_id',
            'value' =>  function ($dataProvider) {
                return Sewage::findOne(['sewage_id' => $dataProvider->sewage_id])->name;
            },
            'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
        ],
        [
            'attribute' => 'state_act',
            'value' =>  function ($dataProvider) {
                if($dataProvider->state_act == '1') return '+';
                else return '-';
            },
            'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
        ],
        [
            'attribute' => 'house_demolition',
            'value' =>  function ($dataProvider) {
                if($dataProvider->house_demolition == '1') return '+';
                else return '-';
            },
            'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
        ],
        [
            'attribute' => 'electric',
            'value' =>  function ($dataProvider) {
                if($dataProvider->electric == '1') return '+';
                else return '-';
            },
            'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
        ],
        [
            'attribute' => 'purpose_id',
            'label' => 'Посред-ник',
            'value' =>  function ($dataProvider) {
                return Purpose::findOne($dataProvider->purpose_id)->name;
            },
            'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
        ],
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
                return User::findOne($dataProvider->author_id)->username;
            }
        ],
        [
            'attribute' => 'exclusive_user_id',
            'label' => 'Эксклю-зив',
            'value' =>  function ($dataProvider) {
                return User::findOne($dataProvider->exclusive_user_id)->username;
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
                //$str = str_replace(' ', ' <br>', $dataProvider->date_added);
                //return /*$str*/$dataProvider->date_added;
                if($dataProvider->date_added=="0000-00-00 00:00:00")
                    return "";
                return Yii::$app->formatter->asDateTime($dataProvider->date_added, 'dd.MM.yyyy');
            },
            'contentOptions' => ['style' => 'max-width: 40px; overflow: hidden' ],
        ],
        [
            'format' => 'html',
            'attribute' => 'date_modified',
            'value' =>  function ($dataProvider) {
                //$str = str_replace(' ', ' <br>', $dataProvider->date_modified);
                //return /*$str*/$dataProvider->date_modified;
                if($dataProvider->date_modified=="0000-00-00 00:00:00")
                    return "";
                //echo $dataProvider->date_modified."<br>";
                return Yii::$app->formatter->asDateTime($dataProvider->date_modified, 'dd.MM.yyyy');
            },
            'contentOptions' => ['style' => 'max-width: 40px; overflow: hidden' ],
        ],
        //'date_added',
        /*[
            'attribute' => 'enabled',
            'value' => function($model) {
                return $model->enabled == 0 ? Yii::t('app', 'Archive') : Yii::t('app', 'Active');
            },
            'filter' => [
                0 => Yii::t('app', 'Archive'),
                1 => Yii::t('app', 'Active')
            ]
        ],*/
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
