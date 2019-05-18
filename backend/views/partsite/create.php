<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Partsite */

$this->title = Yii::t('app', 'Create Partsite');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Partsites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partsite-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
