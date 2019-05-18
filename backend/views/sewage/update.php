<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Sewage */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Sewage',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sewages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->sewage_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sewage-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
