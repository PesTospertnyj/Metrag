<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RegionKharkivAdmin */

$this->title = Yii::t('app', 'Update:') . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Region Kharkiv Admins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->region_kharkiv_admin_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="region-kharkiv-admin-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
