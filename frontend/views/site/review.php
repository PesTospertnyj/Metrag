<?
	use yii\helpers\Url;
?>
<? $this->title = Yii::t('app', 'Client review'); ?>
<div class="product">
   <div class="content">
    <div class="line"><span><h1><?= Yii::t('app', 'Client review')?></h1> <img src="<?= Url::base(true);?>/images/category-home.png" alt=""></span></div>

    <div id="gallery">
  	    <?
  	    	foreach ($review as $item) {
  	    		echo $item->date;
  	    		echo "&nbsp";
  	    		echo $item->name;
  	    		echo "<br>";
  	    		echo nl2br($item->comment);
  	    		echo "<br><br><br>";
  	    	}
  	    ?>
    </div>
   </div>
  </div>