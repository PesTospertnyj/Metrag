<?php
    use yii\helpers\Url;
?>
<div class="catalog grid">
    <div class="content">
        <? foreach ($apartments as $apartment) { ?>
            <div class="item-catalog">
                <div class="item-catalog-text">
                    <?=  $apartment::getLocalitystring($apartment); ?>
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
                	<span><img src="<?= Url::base(true);?>/images/square.png" alt=""></span>
                    <?= $apartment['count_room']; ?> ком., <?= $apartment['total_area']; ?> м<sup>2</sup>
                </span>
                    <span class="price"> $<?= $apartment['price']; ?></span>
                </div>
            </div>
        <? } ?>
    </div>
</div>