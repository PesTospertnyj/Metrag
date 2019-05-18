<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Parsercd */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parsercds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parsercd-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'region_kharkiv_id',
            'street_id',
            'metro_id',
            'link1:ntext',
            'link2:ntext',
            'date',
            'type_object_id',
            'count_room',
            'floor',
            'floor_all',
            'total_area',
            'floor_area',
            'kitchen_area',
            'price',
            'phone:ntext',
            'status:ntext',
            'note:ntext',
            'kolfoto',
            'image:ntext',
            'view',
        ],
    ]) ?>

</div>
