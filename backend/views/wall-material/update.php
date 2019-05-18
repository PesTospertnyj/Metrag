<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WallMaterial */

$this->title = Yii::t('app', 'Update:') . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wall Materials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->wall_material_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="wall-material-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
