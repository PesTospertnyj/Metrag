<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Photo */

$this->title = Yii::t('app', 'Create Photo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Photos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
