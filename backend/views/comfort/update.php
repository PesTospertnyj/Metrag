<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Comfort */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Comfort',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comforts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->comfort_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="comfort-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
