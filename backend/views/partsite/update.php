<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Partsite */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Partsite',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Partsites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->partsite_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="partsite-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
