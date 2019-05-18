<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Communication */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Communication',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Communications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->communication_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="communication-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
