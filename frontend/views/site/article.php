<?php
 use frontend\controllers\SiteController;
 use yii\widgets\LinkPager;
 use yii\helpers\Url;
?>
<? $this->title = Yii::t('app', 'Article'); ?>
   <div class=product>
    <div class=content>
     <div class=line>
        <span>
          <h1><?= Yii::t('app', 'Article')?></h1> 
          <img src="<?= Url::base(true);?>/images/category-home.png" alt="">
        </span>
      </div>

      <div id=gallery>
        <?
          foreach ($article as $item) {
            echo date('d.m.Y', strtotime($item['date']));
            echo "  -  <b>".$item['title']."</b><br><br>";
            echo nl2br($item['text']);
          }
        ?>
     	</div>
     
   </div>
  </div>

  <? echo LinkPager::widget([
    'pagination' => $pages,
  ]);?>