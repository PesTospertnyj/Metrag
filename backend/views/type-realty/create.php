<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TypeRealty */

$this->title = Yii::t('app', 'Create Type Realty');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Type Realties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-realty-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
