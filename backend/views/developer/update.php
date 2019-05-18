<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Developer */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Developer',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Developers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->developer_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="developer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
