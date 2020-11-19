<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Покупатели'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Обновить'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Вы уверены, что хотите удалить этого покупателя?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => function($data){
                    return \backend\models\Customer::AVAILABLE_TYPES_LABELS[$data->type];
                }
            ],
            [
                'attribute' => 'localities',
                'format' => 'raw',
                'value' => function($data){
                    $result = [];
                    if(count($data->localities) > 0){
                        $result = $data->localities;
                    }
                    if(count($data->regions) > 0){
                        $result = $data->regions;
                    }
                    $resultMapped = array_map(function($item){
                        return $item['name'];
                    },$result);

                    if(count($resultMapped) === 0) return '-';
                    return implode(', ',$resultMapped);
                }
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
            'price_from',
            'price_to',
            'total_area_from',
            'total_area_to',
            'info:ntext',
            'is_public',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
