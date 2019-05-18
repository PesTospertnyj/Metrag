<?
	use yii\helpers\Url;
?>
<? $this->title = Yii::t('app', 'Company history'); ?>
<div class="product">
   <div class="content">
    <div class="line"><span><h1><?= Yii::t('app', 'Company history')?></h1> <img src="<?= Url::base(true);?>/images/category-home.png" alt=""></span></div>

    <div id="gallery">
  	    <?= nl2br($history)?>
    </div>
   </div>
  </div>