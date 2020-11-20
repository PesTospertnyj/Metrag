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
            <div class="phones-container">
                <?php
                    $customerPhones = $model->customerPhones
                ?>
            <? if(count($customerPhones) > 0) : ?>
                <div class="form-group field-customer-phone required">
                    <label class="control-label" >Телефон</label>
                    <div style="display: flex;justify-content: space-between">
                        <input type="text"  class="form-control customer-phone"
                               value="<?=$customerPhones[0]->phone?>"
                               name="<?=$model->getClassName()?>[phones][]"
                               maxlength="255" autocomplete="needToDisableAutoComplete" aria-required="true">
                        <span class="add_phone_icon">+</span>
                    </div>

                    <div class="help-block"></div>
                </div>
                <? unset($customerPhones[0]);?>
                <?foreach ($customerPhones as $phoneModel):?>
                    <div class="form-group additional-customer-phone">
                        <div style="display: flex;justify-content: space-between">
                            <input type="text" style="margin-left: 20px"  class="form-control customer-phone"
                                   name="<?=$model->getClassName()?>[phones][]"
                                   value="<?=$phoneModel->phone?>"
                                   maxlength="255" autocomplete="needToDisableAutoComplete" aria-required="true">
                            <span class="remove_phone_icon">-</span>
                        </div>
                    </div>
                <?endforeach?>

            <? else : ?>
                <div class="form-group field-customer-phone required">
                    <label class="control-label" >Телефон</label>
                    <div style="display: flex;justify-content: space-between">
                        <input type="text"  class="form-control customer-phone"
                               value="<?=$customerPhones[0]->phone?>"
                               name="<?=$model->getClassName()?>[phones][]"
                               maxlength="255" autocomplete="needToDisableAutoComplete" aria-required="true">
                        <span class="add_phone_icon">+</span>
                    </div>

                    <div class="help-block"></div>
                </div>



            <? endif ?>
            </div>
            <div class="form-group additional-customer-phone hidden">
                <div style="display: flex;justify-content: space-between">
                    <input type="text" style="margin-left: 20px"  class="form-control customer-phone"
                           maxlength="255" autocomplete="needToDisableAutoComplete" aria-required="true">
                    <span class="remove_phone_icon">-</span>
                </div>
            </div>

            <? if ($model->isNewRecord) { ?>
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

            <div class="select-for-flats" style="display: none">
                <?= $form->field($model, 'regionsKharkiv')
                    ->widget(\kartik\select2\Select2::className(), [
                        'data' => RegionKharkiv::prepareForSelect(),
                        'showToggleAll' => false,
                        'options' => ['placeholder' => 'Выберите район...', 'multiple' => true],
                    ])->label('Район/Харьков'); ?>
            </div>
            <div class="select-for-houses" style="display: none">
                <? if ($model->id == null) $model->city_or_region = 0; ?>
                <?= $form->field($model, 'city_or_region', ['template' => '{input}'])->radiolist(['0' => Yii::t('app', 'Kharkiv'), '1' => Yii::t('app', 'Region')])->label(false); ?>

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
            <?php
            !$model->isNewRecord ?: $model->is_enabled = 1;
            echo $form->field($model, 'is_enabled')->checkbox([
                'label' => 'Активный',
            ]) ?>
            <?php
            echo $form->field($model, 'archive_reason',[ 'options' => ['class' =>  $model->is_enabled ? 'hidden' : '']])
            ->textarea([
                'rows' => 6,
                'class' => 'archive_reason_field form-control',
                'style' => 'resize:none;',

            ])->label('Причина') ?>
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
<style>
    .add_phone_icon,.remove_phone_icon{
        cursor: pointer;
        font-weight: bold;
        font-size: 20px;
        line-height: 33px;
        padding-left: 10px;
    }
</style>
