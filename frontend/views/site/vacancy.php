 <?
 	use yii\helpers\Url;
 ?>
 <? $this->title = Yii::t('app', 'Vacancy'); ?>
 <div class="product">
   <div class="content">
    <div class="line"><span><h1><?= Yii::t('app', 'Vacancy')?></h1> <img src="<?= Url::base(true);?>/images/category-home.png" alt=""></span></div>

    <div id="gallery">
  	    <?
  	    	foreach ($vacancy as $key) {
  	    		echo nl2br($key);
            echo "<br>*****************************************************************<br>";
  	    	}
  	    ?>
    </div>
   </div>
  </div>