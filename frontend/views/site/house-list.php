<?
use yii\helpers\Url;
?>
<div class="catalog list">
	<div class="content">
        <? foreach ($houses as $house) { ?>
        <div class="row">
        	<div class="item-catalog-list">
        		<div class="item-catalog-text">
        		    <p><?= $house['id']; ?></p>
				</div>
				<div class="item-catalog-img">
					<img src="<? $image = $house->getImage();
                            if($image){
                                echo $image->getPathToOrigin();
                            }
                            else
                                echo Url::base(true)."/images/2.png"; ?>" alt="">
					<div class="caption">
					   	<div class="blur"></div>
					   	<a href="house-detail?id=<?= $house['id']; ?>">
						    <div class="caption-text">
								<img src="<?= Url::base(true);?>/images/house.png" alt="">
		                    </div>
		                </a>
					</div>
				</div>
		        <div class="item-catalog-text">
		            <span class="square">
		            	<span>
			            	<img src="<?= Url::base(true);?>/images/square.png" alt="">
			            </span><?= $house['count_room']; ?> ком., <?= $house['total_area']; ?> м<sup>2</sup>
			        </span>
					<span class="price">$<?= $house['price']; ?></span>
				</div>
			</div>
			<div class="desc-catalog-list">
				<span class="price-list">$ <span><?= $house['price']; ?></span></span>
				<span class="square-list">ID - <?= $house['id']; ?></span>
				<span class="name-catalog-list">Тип квартиры : <?= $house::getTypeObject($house); ?></span>
  				<span class="name-catalog-list">Район : <?= $house::getRegionKharkiv($house); ?></span>
  				<span class="name-catalog-list">Комнат : <?= $house['count_room']; ?></span>
  				<span class="name-catalog-list">Этажность : <?= $house['floor_all']; ?></span>
				<p class="text-catalog-list"><?//= $house['notesite']; ?></p>
				<a href="house-detail?id=<?= $house['id']; ?>" class="link-catalog-list"><?= Yii::t('app', 'More...'); ?></a>
			</div>
		</div>
        <? } ?>
    </div>
</div>

