<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Condit */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Condits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="condit-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->condit_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->condit_id], [
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
            'condit_id',
            'name',
            [   'attribute' => 'display_only_building',
                'format' => 'html',
                'value'=>  function($data) { return $data->display_only_building ? 'Да': 'Нет'; },
                'contentOptions'=>['style'=>'max-width: 10px; max-height: 10px'],
            ],
        ],
    ]) ?>

</div>
