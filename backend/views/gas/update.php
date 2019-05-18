<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Gas */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Gas',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->gas_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="gas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
