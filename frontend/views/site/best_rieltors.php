 <?
 	use yii\helpers\Url;
 ?>
 <? $this->title = Yii::t('app', 'Best rieltors'); ?>
 <div class="product">
   <div class="content">
    <div class="line"><span><h1><?= Yii::t('app', 'Best rieltors')?></h1> <img src="<?= Url::base(true);?>/images/category-home.png" alt=""></span></div>

    <div id="gallery">
  	    <?
          if($best_rieltors)
          {
    	    	foreach ($best_rieltors as $key) {
    	    		echo nl2br($key);
    	    		echo "<br>";
    	    		echo "*****************************************************************";
    	    		echo "<br>";
    	    	}
          }
  	    ?>

    </div>
   </div>
  </div>