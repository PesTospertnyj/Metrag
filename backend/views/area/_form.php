<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="area-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type_object_id')->textInput() ?>

    <?= $form->field($model, 'partsite_id')->textInput() ?>

    <?= $form->field($model, 'city_or_region')->textInput() ?>

    <?= $form->field($model, 'region_kharkiv_admin_id')->textInput() ?>

    <?= $form->field($model, 'locality_id')->textInput() ?>

    <?= $form->field($model, 'course_id')->textInput() ?>

    <?= $form->field($model, 'region_id')->textInput() ?>

    <?= $form->field($model, 'region_kharkiv_id')->textInput() ?>

    <?= $form->field($model, 'street_id')->textInput() ?>

    <?= $form->field($model, 'number_building')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'exchange')->textInput() ?>

    <?= $form->field($model, 'exchange_formula')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'landmark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'source_info_id')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mediator_id')->textInput() ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'water_id')->textInput() ?>

    <?= $form->field($model, 'total_area')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sewage_id')->textInput() ?>

    <?= $form->field($model, 'purpose_id')->textInput() ?>

    <?= $form->field($model, 'gas_id')->textInput() ?>

    <?= $form->field($model, 'house_demolition')->textInput() ?>

    <?= $form->field($model, 'exclusive_user_id')->textInput() ?>

    <?= $form->field($model, 'phone_line')->textInput() ?>

    <?= $form->field($model, 'state_act')->textInput() ?>

    <?= $form->field($model, 'electric')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'notesite')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date_added')->textInput() ?>

    <?= $form->field($model, 'date_modified')->textInput() ?>

    <?= $form->field($model, 'date_modified_photo')->textInput() ?>

    <?= $form->field($model, 'author_id')->textInput() ?>

    <?= $form->field($model, 'update_author_id')->textInput() ?>

    <?= $form->field($model, 'update_photo_user_id')->textInput() ?>

    <?= $form->field($model, 'enabled')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
