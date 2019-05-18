<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Ownership */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Ownership',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ownerships'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->ownership_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="ownership-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
