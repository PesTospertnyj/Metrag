<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Purpose */

$this->title = Yii::t('app', 'Create Purpose');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purposes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purpose-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
