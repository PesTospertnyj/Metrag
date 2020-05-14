<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

  <div class="row">
    <div class="col-xs-12 col-sm-4 col-md-4">
        <?= $form->field($model, 'full_name')->textInput(['maxlength' => true])->label('ФИО') ?>

        <?= $form->field($model, 'phone')->textInput(['maxlength' => true])->label('Телефон') ?>

        <?= $form->field($model, 'price_from')->textInput()->label('Цена от') ?>

        <?= $form->field($model, 'price_to')->textInput()->label('Цена до') ?>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-4">
        <?= $form->field($model, 'total_area_from')->textInput()->label('Общая площадь от') ?>

        <?= $form->field($model, 'total_area_to')->textInput()->label('Общая площадь до') ?>

        <?= $form->field($model, 'is_public')->checkbox([
            'label' => 'Публичный?'
        ]) ?>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-4">
        <?= $form->field($model, 'regions')->label('Регионы')->widget(\kartik\select2\Select2::className(), [
            'data' => \backend\models\Region::prepareForSelect(),
            'options' => [
                'multiple' => true,
            ]
        ]) ?>

        <?= $form->field($model, 'condits')->label('Состояния')->widget(\kartik\select2\Select2::className(), [
            'data' => \backend\models\Condit::prepareForSelect(),
            'options' => [
                'multiple' => true,
            ]
        ]) ?>

        <? if ($model->isNewRecord) { ?>
            <?= $form->field($model, 'types')->label('Типы')->widget(\kartik\select2\Select2::className(), [
                'data' => \backend\models\Customer::AVAILABLE_TYPES_LABELS,
                'options' => [
                    'multiple' => true,
                ]
            ]) ?>
        <? } else { ?>
            <?= $form->field($model, 'type')->textInput([
                'disabled' => true
            ])->label('Типы') ?>
        <? } ?>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 col-sm-4 col-md-4">
      <div class="form-group">
          <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
      </div>
    </div>
  </div>

    <?php ActiveForm::end(); ?>

</div>
