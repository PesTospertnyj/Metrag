<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\WallMaterial */

$this->title = Yii::t('app', 'Create Wall Material');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wall Materials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wall-material-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
