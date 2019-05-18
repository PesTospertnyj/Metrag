<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Wc */

$this->title = Yii::t('app', 'Update:') . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wcs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->wc_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="wc-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
