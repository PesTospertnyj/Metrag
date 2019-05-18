<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CommercialSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="commercial-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'type_object_id') ?>

    <?= $form->field($model, 'count_room') ?>

    <?= $form->field($model, 'ownership_id') ?>

    <?= $form->field($model, 'floor') ?>

    <?php // echo $form->field($model, 'floor_all') ?>

    <?php // echo $form->field($model, 'city_or_region') ?>

    <?php // echo $form->field($model, 'region_kharkiv_admin_id') ?>

    <?php // echo $form->field($model, 'locality_id') ?>

    <?php // echo $form->field($model, 'course_id') ?>

    <?php // echo $form->field($model, 'region_id') ?>

    <?php // echo $form->field($model, 'region_kharkiv_id') ?>

    <?php // echo $form->field($model, 'street_id') ?>

    <?php // echo $form->field($model, 'number_office') ?>

    <?php // echo $form->field($model, 'corps') ?>

    <?php // echo $form->field($model, 'exchange') ?>

    <?php // echo $form->field($model, 'exchange_formula') ?>

    <?php // echo $form->field($model, 'landmark') ?>

    <?php // echo $form->field($model, 'condit_id') ?>

    <?php // echo $form->field($model, 'source_info_id') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'price_square_meter') ?>

    <?php // echo $form->field($model, 'mediator_id') ?>

    <?php // echo $form->field($model, 'metro_id') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'total_area_house') ?>

    <?php // echo $form->field($model, 'total_area') ?>

    <?php // echo $form->field($model, 'communication_id') ?>

    <?php // echo $form->field($model, 'exclusive_user_id') ?>

    <?php // echo $form->field($model, 'housing') ?>

    <?php // echo $form->field($model, 'detached_building') ?>

    <?php // echo $form->field($model, 'documents') ?>

    <?php // echo $form->field($model, 'rent') ?>

    <?php // echo $form->field($model, 'topicality') ?>

    <?php // echo $form->field($model, 'avtorampa') ?>

    <?php // echo $form->field($model, 'red_line') ?>

    <?php // echo $form->field($model, 'infinite_period') ?>

    <?php // echo $form->field($model, 'separate_entrance') ?>

    <?php // echo $form->field($model, 'delivered') ?>

    <?php // echo $form->field($model, 'phone_line') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'notesite') ?>

    <?php // echo $form->field($model, 'date_added') ?>

    <?php // echo $form->field($model, 'date_modified') ?>

    <?php // echo $form->field($model, 'date_modified_photo') ?>

    <?php // echo $form->field($model, 'author_id') ?>

    <?php // echo $form->field($model, 'update_author_id') ?>

    <?php // echo $form->field($model, 'update_photo_user_id') ?>

    <?php // echo $form->field($model, 'enabled') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
