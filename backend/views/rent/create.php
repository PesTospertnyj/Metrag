<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Rent */

$this->title = Yii::t('app', 'Create Rent');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rent-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
