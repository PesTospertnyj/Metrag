<style>
  .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      width: 70%;
      margin: auto;
  }
</style>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use rico\yii2images\controllers\ImagesController;
use rico\yii2images\models\Image;

use yii\bootstrap\Carousel;

/* @var $this yii\web\View */
/* @var $model app\models\Apartment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Apartments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apartment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <? echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
            'label' => \Yii::t('yii','Type object'),
            'value' => $model->typeObject->name,
        ],
        'count_room',
        [
            'label' => \Yii::t('yii','Layout'),
            'value' => $model->layout->name,
        ],
        'floor',
        'floor_all',
        [
            'label' => \Yii::t('yii','City Or Region'),
            'value' => $model->cityOrRegion,
        ],
        [
            'label' => \Yii::t('yii','Locality'),
            'value' => $model->locality->name,
        ],
        [
            'label' => \Yii::t('yii','Course'),
            'value' => $model->course->name,
        ],
        [
            'label' => \Yii::t('yii','Region'),
            'value' => $model->region->name,
        ],
        [
            'label' => \Yii::t('yii','Region Kharkiv'),
            'value' => $model->regionKharkiv->name,
        ],
        [
            'label' => \Yii::t('yii','Region Kharkiv Admin'),
            'value' => $model->regionKharkivAdmin->name,
        ],
        [
            'label' => \Yii::t('yii','Street'),
            'value' => $model->street->name,
        ],
        'number_building',
        'corps',
        'number_apartment',
        [
            'label' => \Yii::t('yii','Exchange'),
            'value' => $model->exchangeValue,
        ],
        'exchange_formula',
        'landmark',
        [
            'label' => \Yii::t('yii','Condit'),
            'value' => $model->condit->name,
        ],
        [
            'label' => \Yii::t('yii','Source Info'),
            'value' => $model->sourceInfo->name,
        ],
        'price',
        [
            'label' => \Yii::t('yii','Mediator'),
            'value' => $model->mediator->name,
        ],
        [
            'label' => \Yii::t('yii','Metro'),
            'value' => $model->metro->name,
        ],
        'phone',
        'total_area',
        'floor_area',
        'kitchen_area',
        [
            'label' => \Yii::t('yii','Wc'),
            'value' => $model->wc->name,
        ],
        [
            'label' => \Yii::t('yii','Wall Material'),
            'value' => $model->wallMaterial->name,
        ],
        'count_balcony',
        'count_balcony_glazed',
        [
            'label' => \Yii::t('yii','Exclusive User'),
            'value' => $model->exclusiveUser->name,
        ],
        [
            'label' => \Yii::t('yii','Phone Line'),
            'value' => $model->phoneLineValue,
        ],
        [
            'label' => \Yii::t('yii','Bath'),
            'value' => $model->bathValue,
        ],
        'comment',
        'note',
        'notesite',
        'date_added',
        'date_modified',
        'date_modified_photo',
        [
            'label' => \Yii::t('yii','Author'),
            'value' => $model->author->name,
        ],
        [
            'label' => \Yii::t('yii','Update Author'),
            'value' => $model->updateAuthor->name,
        ],
        [
            'label' => \Yii::t('yii','Update Photo User'),
            'value' => $model->updatePhotoUser->name,
        ],
        [
            'label' => \Yii::t('yii','Enabled'),
            'value' => $model->enabledValue,
        ],
            
    ],
]);
?>

<div class="container">
    <div class="col-xs-9 col-xm-9 col-xl-9">
    <? 
        $images = $model->getImages();
                $img = [];
        
                
                    foreach ($images as $image){
                        if($image){
                        $img[] = '<img src="'. $image->getUrl('600x'). '" alt="">';
                        }
                }
                
        echo Carousel::widget(['items'=>$img]);
     ?>     
    </div>
</div>

</div>
