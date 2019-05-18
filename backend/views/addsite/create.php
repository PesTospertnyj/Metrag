<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Addsite */

$this->title = Yii::t('app', 'Create Addsite');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Addsites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="addsite-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
