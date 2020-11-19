<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Покупатели');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Создать Покупателя'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function ($model)
        {
            if($model->is_enabled == false) {
                return ['style' => 'background-color:#DDA0DD;'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => 'ФИО',
                'value' => 'full_name',
            ],

            [
                'label' => 'Телефон(ы)',
                'value' => function($model){
                    $phones = array_map(function($phoneItem){
                        return $phoneItem->phone;
                    },$model->customerPhones);
                    return implode(', ',$phones);
                },
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
                    $modelClass = get_class($model);
                    return $modelClass::AVAILABLE_TYPES_LABELS[$model->type];
                    //  return get_class($model)::AVAILABLE_TYPES_LABELS[$model->type];
                }
            ],
            // 'total_area_from',
            // 'total_area_to',
            // 'info:ntext',
            // 'is_public',
            [
                'label' => 'Старые/Новые',
                'format' => 'raw',
                'value' => function($model) {
                        $viewedAds = Html::a(
                            $model->viewedCount,
                            Url::to(['/customer-realties/old-adverts', 'id' => $model->id]),
                            [
                                'title' => 'Перейти на недвижимость покупателя',
                                'target' => '_blank',
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
            [
                'label' => 'Дата добавления',
                'value' => 'created_at',
            ],
            [
                'label' => 'Дата изменения',
                'value' => 'updated_at',
            ],
            [
                'label' => 'Автор',
                'value' => function ($model) {
                    $user = $model->author;
                    return $user->username;
                    //  return get_class($model)::AVAILABLE_TYPES_LABELS[$model->type];
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
