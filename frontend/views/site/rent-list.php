<?
    use yii\helpers\Url;
?>
<div class="catalog list">
	<div class="content">
        <? foreach ($rents as $rent) { ?>
        <div class="row">
        	<div class="item-catalog-list">
        		<div class="item-catalog-text">
        		    <p><?= $rent['id']; ?></p>
				</div>
				<div class="item-catalog-img">
					<img src="<? if($rent) $image = $rent->getImage();
                        if($image){
                            echo $image->getPathToOrigin();
                        }
                        else
                            echo Url::base(true)."/images/2.png"; ?>" alt="">
					<div class="caption">
					   	<div class="blur"></div>
					   	<a href="rent-detail?id=<?= $rent['id']; ?>">
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
			            </span><?= $rent['count_room']; ?> ком.
			        </span>
					<span class="price">$<?= $rent['price']; ?></span>
				</div>
			</div>
			<div class="desc-catalog-list">
				<span class="price-list">$ <span><?= $rent['price']; ?></span></span>
				<span class="square-list">ID - <?= $rent['id']; ?></span>
				<span class="name-catalog-list">Тип : <?= $rent::getTypeObject($rent); ?></span>
  				<span class="name-catalog-list">Район : <?= $rent::getRegionKharkiv($rent); ?></span>
  				<span class="name-catalog-list">Комнат : <?= $rent['count_room'];?></span>
  				<span class="name-catalog-list">Этаж : <?= $rent['floor']; ?></span>
  				<span class="name-catalog-list">Этажность : <?= $rent['floor_all']; ?></span>
				<p class="text-catalog-list"><?//= $rent['notesite']; ?></p>
				<a href="rent-detail?id=<?= $rent['id']; ?>" class="link-catalog-list"><?= Yii::t('app', 'More...'); ?></a>
			</div>
		</div>
        <? } ?>
	</div>
</div>