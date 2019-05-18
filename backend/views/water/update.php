<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Water */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Water',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Waters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->water_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="water-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
