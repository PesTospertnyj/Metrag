<?php

use backend\models\Course;
use backend\models\Locality;
use backend\models\Metro;
use backend\models\Region;
use backend\models\RegionKharkiv;
use backend\models\RegionKharkivAdmin;
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

        <?= $form->field($model, 'phone')
            ->textInput(['maxlength' => true,'autocomplete'=>'needToDisableAutoComplete'])
            ->label('Телефон') ?>

        <? if ($model->isNewRecord ) { ?>
            <?= $form->field($model, 'type', [
                'options' => [
                    'class' => 'required',
                ],

            ])->label('Тип')->widget(\kartik\select2\Select2::className(), [
                'data' => \backend\models\Customer::AVAILABLE_TYPES_LABELS,
                'options' => ['placeholder' => 'Выберите тип ...'],
            ]) ?>
        <? } else { ?>
            <?= $form->field($model, 'type')->label('Тип')->widget(\kartik\select2\Select2::className(), [
                'data' => \backend\models\Customer::AVAILABLE_TYPES_LABELS,
                'options' => [
                    'name' => $model->type,
                ]
            ]) ?>
        <? } ?>

      <div class="select-for-flats" style="display: none" >
          <?= $form->field($model, 'regionsKharkiv')
              ->widget(\kartik\select2\Select2::className(), [
                  'data' => RegionKharkiv::prepareForSelect(),
                  'showToggleAll' => false,
                  'options' => ['placeholder' => 'Выберите район...', 'multiple' => true],
              ])->label('Район/Харьков'); ?>
      </div>
      <div class="select-for-houses" style="display: none" >
          <? if($model->id == null) $model->city_or_region = 0; ?>
          <?= $form->field($model,'city_or_region',['template' => '{input}'])->radiolist(['0' => Yii::t('app', 'Kharkiv'), '1' => Yii::t('app', 'Region')])->label(false); ?>

          <?= $form->field($model, 'regionsKharkivCopy')->widget(
              \kartik\select2\Select2::className(), [
                  'data' => RegionKharkiv::prepareForSelect(),
                  'showToggleAll' => false,
                  'options' => ['placeholder' => 'Выберите район...', 'multiple' => true],
              ]
          )->label('Район/Харьков'); ?>

          <?= $form->field($model, 'localities')->widget(
              \kartik\select2\Select2::className(), [
                  'data' => Locality::prepareForSelect(),
                  'showToggleAll' => false,
                  'options' => ['placeholder' => 'Выберите населенный пункт...', 'multiple' => true]
              ]
          )->label('Населенный пункт', ['class' => 'required']); ?>
      </div>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-4">
        <?= $form->field($model, 'price_from')->textInput()->label('Цена от') ?>

        <?= $form->field($model, 'price_to')->textInput()->label('Цена до') ?>

        <?= $form->field($model, 'total_area_from')->textInput()->label('Общая площадь от') ?>

        <?= $form->field($model, 'total_area_to')->textInput()->label('Общая площадь до') ?>
    </div>


    <div class="col-xs-12 col-sm-4 col-md-4">
        <?= $form->field($model, 'condits')->label('Состояния')->widget(\kartik\select2\Select2::className(), [
            'data' => \backend\models\Condit::prepareForSelect(),
            'options' => [
                'multiple' => true,
            ]
        ]) ?>

        <?= $form->field($model, 'is_public')->checkbox([
            'label' => 'Публичный?'
        ]) ?>
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
