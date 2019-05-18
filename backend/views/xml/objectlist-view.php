<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\XmlSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Xmls');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="xml-index">

    <h1><?= Yii::t('app', $resource); ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th><?= Yii::t('app', 'Action'); ?></th>
                <th>ID</th>
                <th><?= Yii::t('app', 'Type Object'); ?></th>
                <th><?= Yii::t('app', 'Region Kharkiv Admin'); ?></th>
                <th><?= Yii::t('app', 'Street'); ?></th>
                <th><?= Yii::t('app', 'Price'); ?></th>
                <th><?= Yii::t('app', 'Phone'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($model as $key => $value)
        { if($value){
        ?>
        <tr>
            <td><a href="<?= $key; ?>" target="_blank"><?= Yii::t('app', 'Edit'); ?></a></td>
            <td><?= $value->id; ?></td>
            <td><?= $value->getTypeObject()->name; ?></td>
            <td><?= $value->getRegionKharkivAdmin()->name; ?></td>
            <td><?= $value->getStreet()->name; ?></td>
            <td><?= $value->price; ?></td>
            <td><?= $value->phone; ?></td>
        </tr>
        <?  }}
        ?>
        </tbody>
    </table>

    </div>

<? echo LinkPager::widget([
    'pagination' => $pages,
]);?>