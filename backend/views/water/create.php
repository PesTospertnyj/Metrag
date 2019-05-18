<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Water */

$this->title = Yii::t('app', 'Create Water');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Waters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="water-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
