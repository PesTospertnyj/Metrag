<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Xml */

$this->title = Yii::t('app', 'Create Xml');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Xmls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="xml-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
