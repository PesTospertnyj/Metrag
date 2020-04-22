<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Layout */

$this->title = Yii::t('app', 'Create Layout');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Layouts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="layout-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
