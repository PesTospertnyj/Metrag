<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ExpertChild */

$this->title = Yii::t('app', 'Create Expert Child');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Expert Children'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expert-child-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
