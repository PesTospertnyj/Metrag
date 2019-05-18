<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ParsercdSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parsercd-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'region_kharkiv_id') ?>

    <?= $form->field($model, 'street_id') ?>

    <?= $form->field($model, 'metro_id') ?>

    <?= $form->field($model, 'link1') ?>

    <?php // echo $form->field($model, 'link2') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'type_object_id') ?>

    <?php // echo $form->field($model, 'count_room') ?>

    <?php // echo $form->field($model, 'floor') ?>

    <?php // echo $form->field($model, 'floor_all') ?>

    <?php // echo $form->field($model, 'total_area') ?>

    <?php // echo $form->field($model, 'floor_area') ?>

    <?php // echo $form->field($model, 'kitchen_area') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'kolfoto') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'view') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
