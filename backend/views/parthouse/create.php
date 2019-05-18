<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Parthouse */

$this->title = Yii::t('app', 'Create Parthouse');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parthouses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parthouse-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
