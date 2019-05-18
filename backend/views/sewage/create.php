<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Sewage */

$this->title = Yii::t('app', 'Create Sewage');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sewages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sewage-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
