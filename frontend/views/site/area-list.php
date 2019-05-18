<?
use yii\helpers\Url;
?>
<div class="catalog list">
	<div class="content">
        <? foreach ($areas as $area) { ?>
        <div class="row">
        	<div class="item-catalog-list">
        		<div class="item-catalog-text">
        		    <p><?= $area['id']; ?></p>
				</div>
				<div class="item-catalog-img">
					<img src="<? $image = $area->getImage();
                            if($image){
                                echo $image->getPathToOrigin();
                            }
                            else
                                echo Url::base(true)."images/2.png"; ?>" alt="">
					<div class="caption">
					   	<div class="blur"></div>
					   	<a href="area-detail?id=<?= $area['id']; ?>">
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
			            </span><?= $area['total_area']; ?> м<sup>2</sup>
			        </span>
					<span class="price">$<?= $area['price']; ?></span>
				</div>
			</div>
			<div class="desc-catalog-list">
				<span class="price-list">$ <span><?= $area['price']; ?></span></span>
				<span class="square-list">ID - <?= $area['id']; ?></span>
				<span class="name-catalog-list">Район : <?= $area::getRegionKharkiv($area); ?></span>
  				<p class="text-catalog-list"><?//= $area['notesite']; ?></p>
				<a href="area-detail?id=<?= $area['id']; ?>" class="link-catalog-list"><?= Yii::t('app', 'More...'); ?></a>
			</div>
		</div>
        <?}?>
	</div>
</div>