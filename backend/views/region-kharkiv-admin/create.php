<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RegionKharkivAdmin */

$this->title = Yii::t('app', 'Create Region Kharkiv Admin');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Region Kharkiv Admins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-kharkiv-admin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
