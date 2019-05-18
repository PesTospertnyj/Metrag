<div class="row">
    <div class="col-md-6">
        <form action="" method="post">
<?php

/** @var \app\modules\olxparser\models\ParserOlxParams $model */
foreach($model as $param) { ?>
    <label for="<?= $param->name ?>"><?= $param->label ?></label>
            <div class="form-group">
    <?php if($param->textfield) { ?>
        <textarea name="Params[<?= $param->name ?>]" id="<?= $param->name ?>" class="form-control" rows="2"><?= $param->value ?></textarea>
    <?php } else { ?>
        <input name="Params[<?= $param->name ?>]" id="<?= $param->name ?>" type="text" class="form-control" value="<?= \yii\helpers\Html::encode($param->value) ?>" />
    <?php } ?>
            </div>
<?php }
?>
        <button class="btn btn-submit">Сохранить</button>
    </form>
    </div>
</div>
