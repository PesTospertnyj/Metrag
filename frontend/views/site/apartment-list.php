<?php
use yii\helpers\Url;
?>
<div class="catalog list">
    <div class="content">
        <? foreach ($apartments as $apartment) { ?>
        <div class="row">
            <div class="item-catalog-list">
                <div class="item-catalog-text">
                    <p><?= $apartment['id']; ?></p>
                </div>
                <div class="item-catalog-img">
                    <img src="<? $image = $apartment->getImage();
                    if($image){
                        echo $image->getPathToOrigin();
                    }
                    else
                        echo Url::base(true)."/images/2.png"; ?>" alt="">
                    <div class="caption">
                        <div class="blur"></div>
                        <a href="apartment-detail?id=<?= $apartment['id'];?>">
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
			            </span><?= $apartment['count_room']; ?> ком., <?= $apartment['total_area']; ?> м<sup>2</sup>
			        </span>
                    <span class="price">$<?= $apartment['price']; ?></span>
                </div>
            </div>
            <div class="desc-catalog-list">
                <span class="price-list">$ <span><?= $apartment['price']; ?></span></span>
                <span class="square-list">ID - <?= $apartment['id']; ?></span>
                <span class="name-catalog-list">Тип квартиры : <?= $apartment::getTypeObject($apartment); ?></span>
                <span class="name-catalog-list">Район : <?= $apartment::getRegionKharkiv($apartment); ?></span>
                <span class="name-catalog-list">Комнат : <?= $apartment['count_room']; ?></span>
                <span class="name-catalog-list">Этаж : <?= $apartment['floor']; ?></span>
                <span class="name-catalog-list">Этажность : <?= $apartment['floor_all']; ?></span>
                <p class="text-catalog-list"><?//= $apartment['notesite']; ?></p>
                <a href="apartment-detail?id=<?= $apartment['id']; ?>" class="link-catalog-list"><?= Yii::t('app', 'More...');?></a>
            </div>
        </div>
        <? } ?>
    </div>
</div>