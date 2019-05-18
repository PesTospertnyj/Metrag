<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Metro */

$this->title = Yii::t('app', 'Create Metro');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Metros'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metro-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
