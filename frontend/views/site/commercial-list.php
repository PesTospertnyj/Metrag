<?
    use yii\helpers\Url;
?>
<div class="catalog list">
	<div class="content">
        <? foreach ($commercials as $commercial) { ?>
        <div class="row">
        	<div class="item-catalog-list">
        		<div class="item-catalog-text">
        		    <p><?= $commercial['id']; ?></p>
				</div>
				<div class="item-catalog-img">
					<img src="<? $image = $commercial->getImage();
                        if($image){
                            echo $image->getPathToOrigin();
                        }
                        else
                            echo Url::base(true)."/images/2.png"; ?>" alt="">
					<div class="caption">
					   	<div class="blur"></div>
					   	<a href="commercial-detail?id=<?= $commercial['id']; ?>">
						    <div class="caption-text">
								<img src="<?= Url::base(true); ?>/images/house.png" alt="">
		                    </div>
		                </a>
					</div>
				</div>
		        <div class="item-catalog-text">
		            <span class="square">
		            	<span>
			            	<img src="<?= Url::base(true); ?>/images/square.png" alt="">
			            </span><?= $commercial['count_room']; ?> ком., <?= $commercial['total_area']; ?> м<sup>2</sup>
			        </span>
					<span class="price">$<?= $commercial['price']; ?></span>
				</div>
			</div>
			<div class="desc-catalog-list">
				<span class="price-list">$ <span><?= $commercial['price']; ?></span></span>
				<span class="square-list">ID - <?= $commercial['id']; ?></span>
				<span class="name-catalog-list">Тип квартиры : <?= $commercial::getTypeObject($commercial); ?></span>
  				<span class="name-catalog-list">Район : <?= $commercial::getRegionKharkiv($commercial); ?></span>
  				<span class="name-catalog-list">Комнат : <?= $commercial['count_room']; ?></span>
  				<span class="name-catalog-list">Этаж : <?= $commercial['floor']; ?></span>
  				<span class="name-catalog-list">Этажность : <?= $commercial['floor_all']; ?></span>
				<p class="text-catalog-list"><?//= $commercial['notesite']; ?></p>
				<a href="commercial-detail?id=<?= $commercial['id']; ?>" class="link-catalog-list"><?= Yii::t('app', 'More...'); ?></a>
			</div>
		</div>
        <? } ?>
	</div>
</div>