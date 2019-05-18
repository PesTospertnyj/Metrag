<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Communication */

$this->title = Yii::t('app', 'Create Communication');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Communications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="communication-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
