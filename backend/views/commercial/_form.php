<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Commercial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="commercial-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type_object_id')->textInput() ?>

    <?= $form->field($model, 'count_room')->textInput() ?>

    <?= $form->field($model, 'ownership_id')->textInput() ?>

    <?= $form->field($model, 'floor')->textInput() ?>

    <?= $form->field($model, 'floor_all')->textInput() ?>

    <?= $form->field($model, 'city_or_region')->textInput() ?>

    <?= $form->field($model, 'region_kharkiv_admin_id')->textInput() ?>

    <?= $form->field($model, 'locality_id')->textInput() ?>

    <?= $form->field($model, 'course_id')->textInput() ?>

    <?= $form->field($model, 'region_id')->textInput() ?>

    <?= $form->field($model, 'region_kharkiv_id')->textInput() ?>

    <?= $form->field($model, 'street_id')->textInput() ?>

    <?= $form->field($model, 'number_office')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'corps')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'exchange')->textInput() ?>

    <?= $form->field($model, 'exchange_formula')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'landmark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'condit_id')->textInput() ?>

    <?= $form->field($model, 'source_info_id')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_square_meter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mediator_id')->textInput() ?>

    <?= $form->field($model, 'metro_id')->textInput() ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_area_house')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_area')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'communication_id')->textInput() ?>

    <?= $form->field($model, 'exclusive_user_id')->textInput() ?>

    <?= $form->field($model, 'housing')->textInput() ?>

    <?= $form->field($model, 'detached_building')->textInput() ?>

    <?= $form->field($model, 'documents')->textInput() ?>

    <?= $form->field($model, 'rent')->textInput() ?>

    <?= $form->field($model, 'topicality')->textInput() ?>

    <?= $form->field($model, 'avtorampa')->textInput() ?>

    <?= $form->field($model, 'red_line')->textInput() ?>

    <?= $form->field($model, 'infinite_period')->textInput() ?>

    <?= $form->field($model, 'separate_entrance')->textInput() ?>

    <?= $form->field($model, 'delivered')->textInput() ?>

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
