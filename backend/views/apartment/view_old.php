<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Apartment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Apartments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apartment-view">

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
            'type_object_id',
            'count_room',
            'layout_id',
            'floor',
            'floor_all',
            'city_or_region',
            'region_kharkiv_admin_id',
            'locality_id',
            'course_id',
            'region_id',
            'region_kharkiv_id',
            'street_id',
            'number_building',
            'corps',
            'number_apartment',
            'exchange',
            'exchange_formula',
            'landmark',
            'condit_id',
            'source_info_id',
            'price',
            'mediator_id',
            'metro_id',
            'phone',
            'total_area',
            'floor_area',
            'kitchen_area',
            'wc_id',
            'wall_material_id',
            'count_balcony',
            'count_balcony_glazed',
            'exclusive_user_id',
            'phone_line',
            'bath',
            'comment:ntext',
            'note:ntext',
            'notesite:ntext',
            'date_added',
            'date_modified',
            'date_modified_photo',
            'author_id',
            'update_author_id',
            'update_photo_user_id',
            'enabled',
        ],
    ]) ?>

</div>
