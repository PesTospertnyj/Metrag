<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Condit */

$this->title = Yii::t('app', 'Create Condit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Condits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="condit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
