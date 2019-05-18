<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Rent */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Rent',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="rent-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
