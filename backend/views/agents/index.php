<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Агенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    a[title=Просмотр],
    .help-block {
        display: none;
    }
    .form-control {
         border-color: unset !important;
    }
</style>

<div class="course-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            [
                'attribute'=>'numbers',
                'header' => false,
                'filter' => false
            ],
            [
                'attribute'=>'description',
                'header' => false,
                'filter' => false
            ],
            [
                'attribute' => 'user',
                'header' => false,
                //'filter' => false,
                'value' =>  function ($dataProvider) {
                    return User::findOne($dataProvider->user_id)->username;
                }
            ],
            [
                'attribute'=>'is_publish',
                'header' => false,
                'filter' => false,
                'value' =>  function ($dataProvider) {
                    return $dataProvider->is_publish ? 'Да' : 'Нет';
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
