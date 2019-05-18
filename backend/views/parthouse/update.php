<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Parthouse */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Parthouse',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parthouses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->parthouse_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="parthouse-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
