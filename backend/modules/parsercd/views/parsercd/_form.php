<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Parsercd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parsercd-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'region_kharkiv_id')->textInput() ?>

    <?= $form->field($model, 'street_id')->textInput() ?>

    <?= $form->field($model, 'metro_id')->textInput() ?>

    <?= $form->field($model, 'link1')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'link2')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'type_object_id')->textInput() ?>

    <?= $form->field($model, 'count_room')->textInput() ?>

    <?= $form->field($model, 'floor')->textInput() ?>

    <?= $form->field($model, 'floor_all')->textInput() ?>

    <?= $form->field($model, 'total_area')->textInput() ?>

    <?= $form->field($model, 'floor_area')->textInput() ?>

    <?= $form->field($model, 'kitchen_area')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'phone')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'kolfoto')->textInput() ?>

    <?= $form->field($model, 'image')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'view')->dropDownList([ 'neprov' => 'Neprov', 'no' => 'No', 'yes' => 'Yes', 'tel' => 'Tel', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
