<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\olxparser\models\Proxy */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Proxy',
]) . $model->ip;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Proxies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ip, 'url' => ['view', 'id' => $model->ip]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="proxy-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
