<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Rent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rent-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type_object_id')->textInput() ?>

    <?= $form->field($model, 'count_room')->textInput() ?>

    <?= $form->field($model, 'count_room_rent')->textInput() ?>

    <?= $form->field($model, 'floor')->textInput() ?>

    <?= $form->field($model, 'floor_all')->textInput() ?>

    <?= $form->field($model, 'city_or_region')->textInput() ?>

    <?= $form->field($model, 'region_kharkiv_admin_id')->textInput() ?>

    <?= $form->field($model, 'locality_id')->textInput() ?>

    <?= $form->field($model, 'course_id')->textInput() ?>

    <?= $form->field($model, 'region_id')->textInput() ?>

    <?= $form->field($model, 'region_kharkiv_id')->textInput() ?>

    <?= $form->field($model, 'street_id')->textInput() ?>

    <?= $form->field($model, 'number_building')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'corps')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number_apartment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'landmark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'condit_id')->textInput() ?>

    <?= $form->field($model, 'source_info_id')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_note')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comfort_id')->textInput() ?>

    <?= $form->field($model, 'metro_id')->textInput() ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone_site')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_site')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'exclusive_user_id')->textInput() ?>

    <?= $form->field($model, 'tv')->textInput() ?>

    <?= $form->field($model, 'refrigerator')->textInput() ?>

    <?= $form->field($model, 'entry')->textInput() ?>

    <?= $form->field($model, 'washer')->textInput() ?>

    <?= $form->field($model, 'furniture')->textInput() ?>

    <?= $form->field($model, 'conditioner')->textInput() ?>

    <?= $form->field($model, 'garage')->textInput() ?>

    <?= $form->field($model, 'phone_line')->textInput() ?>

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
