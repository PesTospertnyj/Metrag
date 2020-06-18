<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
                    return get_class($model)::AVAILABLE_TYPES_LABELS[$model->type];
                }
            ],
            // 'total_area_from',
            // 'total_area_to',
            // 'info:ntext',
            // 'is_public',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
