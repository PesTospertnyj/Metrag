<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Mediator */

$this->title = Yii::t('app', 'Create Mediator');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mediators'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mediator-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
