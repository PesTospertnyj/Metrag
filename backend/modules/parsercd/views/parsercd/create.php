<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Parsercd */

$this->title = Yii::t('app', 'Create Parsercd');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parsercds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parsercd-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
