<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Locality */

$this->title = Yii::t('app', 'Create Locality');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Localities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="locality-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
