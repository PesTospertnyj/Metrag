<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Wc */

$this->title = Yii::t('app', 'Create Wc');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wcs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
