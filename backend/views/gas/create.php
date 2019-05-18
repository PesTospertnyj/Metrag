<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Gas */

$this->title = Yii::t('app', 'Create Gas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
