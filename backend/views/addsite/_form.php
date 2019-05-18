<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Addsite */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="addsite-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'base')->dropDownList([ 'apartment' => 'Apartment', 'area' => 'Area', 'building' => 'Building', 'commercial' => 'Commercial', 'house' => 'House', 'rent' => 'Rent', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'idbase')->textInput() ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
