<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TypeObject */

$this->title = Yii::t('app', 'Create Type Object');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Type Objects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-object-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
