<?
use yii\helpers\Url;
?>
<div class="catalog list">
	<div class="content">
        <? foreach ($buildings as $building) { ?>
        <div class="row">
        	<div class="item-catalog-list">
        		<div class="item-catalog-text">
        		    <p><?= $building['id']; ?></p>
				</div>
				<div class="item-catalog-img">
					<img src="<? $image = $building->getImage();
                        if($image){
                            echo $image->getPathToOrigin();
                        }
                        else
                            echo Url::base(true)."/images/2.png"; ?>" alt="">
					<div class="caption">
					   	<div class="blur"></div>
					   	<a href="building-detail?id=<?= $building['id']; ?>">
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
			            </span><?= $building['count_room']; ?> ком., <?= $building['total_area']; ?> м<sup>2</sup>
			        </span>
					<span class="price">$<?= $building['price']; ?></span>
				</div>
			</div>
			<div class="desc-catalog-list">
				<span class="price-list">$ <span><?= $building['price']; ?></span></span>
				<span class="square-list">ID - <?= $building['id']; ?></span>
				<span class="name-catalog-list">Тип квартиры : <?= $building::getTypeObject($building); ?></span>
  				<span class="name-catalog-list">Район : <?= $building::getRegionKharkiv($building); ?></span>
  				<span class="name-catalog-list">Комнат : <?= $building['count_room']; ?></span>
  				<span class="name-catalog-list">Этаж : <?= $building['floor']; ?></span>
  				<span class="name-catalog-list">Этажность : <?= $building['floor_all']; ?></span>
				<p class="text-catalog-list"><?//= $building['notesite'];  ?></p>
				<a href="building-detail?id=<?= $building['id']; ?>" class="link-catalog-list"><?= Yii::t('app', 'More...'); ?></a>
			</div>
		</div>
        <? } ?>
	</div>
</div>
