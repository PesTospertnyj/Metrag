<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SourceInfo */

$this->title = Yii::t('app', 'Create Source Info');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Source Infos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="source-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
