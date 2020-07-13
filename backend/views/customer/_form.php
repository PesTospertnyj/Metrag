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
          <? if($model->id == null) $model->city_or_region = 0; ?>
          <?= $form->field($model,'city_or_region',['template' => '{input}'])->radiolist(['0' => Yii::t('app', 'Kharkiv'), '1' => Yii::t('app', 'Region')])->label(false); ?>

          <?= $form->field($model, 'region_kharkiv_admin_id')->dropdownList(RegionKharkivAdmin::find()->select(['name', 'region_kharkiv_admin_id'])->orderby('name')->indexBy('region_kharkiv_admin_id')->column(),['prompt'=>'Выберите район...'])->label('РайонАдмин/Харьков', ['class' => 'required']); ?>
          <?= $form->field($model, 'region_kharkiv_id')->dropdownList(
              RegionKharkiv::find()->select(['name', 'region_kharkiv_id'])->orderby('name')->indexBy('region_kharkiv_id')->column(),['prompt'=>'Выберите район...'])->label('Район/Харьков', ['class' => 'required']); ?>
          <?= $form->field($model, 'metro_id')->dropdownList(
              Metro::find()->select(['name', 'metro_id'])->orderby('name')->indexBy('metro_id')->column(),['prompt'=>'Выберите станцию метро...'])->label('Метро'); ?>

          <?= $form->field($model, 'locality_id')->dropdownList(
              Locality::find()->select(['name', 'locality_id'])->orderby('name')->indexBy('locality_id')->column(),['prompt'=>'Выберите населенный пункт...'])->label('Населенный пункт', ['class' => 'required']); ?>
          <?= $form->field($model, 'course_id')->dropdownList(
              Course::find()->select(['name', 'course_id'])->orderby('name')->indexBy('course_id')->column(),['prompt'=>'Выберите направление...'])->label('Направление', ['class' => 'required']); ?>
          <?= $form->field($model, 'region_id')->dropdownList(Region::find()->select(['name', 'region_id'])->orderby('name')->indexBy('region_id')->column(),['prompt'=>'Выберите район...'])->label('Район/Область', ['class' => 'required']); ?>


          <?php /* echo $form->field($model, 'street_id')->dropdownList(
            Street::find()->select(['name', 'street_id'])->orderby('name')->indexBy('street_id')->column(),['prompt'=>'Выберите улицу...'])->label('Улица');  */ ?>
          <?= $form->field($model,'number_building')->textInput()->label('Номер дома'); ?>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-4">
        <?= $form->field($model, 'regions', [
            'options' => [
                'class' => 'required',
            ],
        ])->label('Регионы')->widget(\kartik\select2\Select2::className(), [
            'data' => \backend\models\Region::prepareForSelect(),
            'options' => [
                'multiple' => true,
                'required' => true,
            ],
        ]) ?>

        <?= $form->field($model, 'condits', [
            'options' => [
                'class' => 'required',
            ],
        ])->label('Состояния')->widget(\kartik\select2\Select2::className(), [
            'data' => \backend\models\Condit::prepareForSelect(),
            'options' => [
                'multiple' => true,
            ]
        ]) ?>

        <? if ($model->isNewRecord) { ?>
            <?= $form->field($model, 'types', [
                'options' => [
                    'class' => 'required',
                ],
            ])->label('Типы')->widget(\kartik\select2\Select2::className(), [
                'data' => \backend\models\Customer::AVAILABLE_TYPES_LABELS,
                'options' => [
                    'multiple' => true,
                ]
            ]) ?>
        <? } else { ?>
            <?= $form->field($model, 'type')->label('Тип')->widget(\kartik\select2\Select2::className(), [
                'data' => \backend\models\Customer::AVAILABLE_TYPES_LABELS,
                'options' => [
                    'disabled' => true,
                    'name' => $model->type,
                ]
            ]) ?>
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
