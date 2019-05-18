<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Area */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Areas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-view">

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
            [
            'label' => \Yii::t('yii','Type object'),
            'value' => $model->typeObject->name,
            ],
            [
            'label' => \Yii::t('yii','Partsite'),
            'value' => $model->partsite->name,
            ],
            [
            'label' => \Yii::t('yii','City Or Region'),
            'value' => $model->cityOrRegion,
            ],
            [
                'label' => \Yii::t('yii','Locality'),
                'value' => $model->locality->name,
            ],
            [
                'label' => \Yii::t('yii','Course'),
                'value' => $model->course->name,
            ],
            [
                'label' => \Yii::t('yii','Region'),
                'value' => $model->region->name,
            ],
            [
                'label' => \Yii::t('yii','Region Kharkiv'),
                'value' => $model->regionKharkiv->name,
            ],
            [
                'label' => \Yii::t('yii','Region Kharkiv Admin'),
                'value' => $model->regionKharkivAdmin->name,
            ],
            [
                'label' => \Yii::t('yii','Street'),
                'value' => $model->street->name,
            ],
            'number_building',
            'exchange',
            'exchange_formula',
            'landmark',
            [
                'label' => \Yii::t('yii','Source Info'),
                'value' => $model->sourceInfo->name,
            ],
            'price',
            [
            'label' => \Yii::t('yii','Mediator'),
            'value' => $model->mediator->name,
            ],
            'phone',
            [
            'label' => \Yii::t('yii','Water'),
            'value' => $model->water->name,
            ],
            'total_area',
            [
                'label' => \Yii::t('yii','Sewage'),
                'value' => $model->sewage->name,
            ],
            [
                'label' => \Yii::t('yii','Purpose'),
                'value' => $model->purpose->name,
            ],
            [
            'label' => \Yii::t('yii','Gas'),
            'value' => $model->gas->name,
            ],
            'exclusive_user_id',
            [
                'label' => \Yii::t('yii','Phone Line'),
                'value' => $model->phoneLineValue,
            ],
            [
                'label' => \Yii::t('yii','State Act'),
                'value' => $model->stateActValue,
            ],
            [
                'label' => \Yii::t('yii','House Demolition'),
                'value' => $model->houseDemolitionValue,
            ],
            [
                'label' => \Yii::t('yii','Electric'),
                'value' => $model->electricValue,
            ],
            'comment:ntext',
            'note:ntext',
            'notesite:ntext',
            'date_added',
            'date_modified',
            'date_modified_photo',
            [
            'label' => \Yii::t('yii','Author'),
            'value' => $model->author->name,
            ],
            [
                'label' => \Yii::t('yii','Update Author'),
                'value' => $model->updateAuthor->name,
            ],
            [
                'label' => \Yii::t('yii','Update Photo User'),
                'value' => $model->updatePhotoUser->name,
            ],
            [
                'label' => \Yii::t('yii','Enabled'),
                'value' => $model->enabledValue,
            ],
        ],
    ]) ?>

</div>
