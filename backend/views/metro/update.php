<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Metro */

$this->title = Yii::t('app', 'Update:') . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Metros'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->metro_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="metro-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
