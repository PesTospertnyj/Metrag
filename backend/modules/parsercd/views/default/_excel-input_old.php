<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<div style="width: 90%; margin: auto;">
    <div class="colLeft">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'excelFile')->fileInput() ?>

            <button class="btn btn-success"><?php echo Yii::t('app', 'Parsing file')?></button>

        <?php ActiveForm::end() ?>
    </div>

    <div class="colRight" style="height: 100px;">
        <a href="<?= Url::to(['/parsercd/compare/index']); ?> " class="btn btn-success">
            <span class="showTable">Отсеять объявления</span>
        </a>
    </div>
</div>