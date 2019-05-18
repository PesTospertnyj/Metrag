<?
    use yii\helpers\Url;
?>
<div class="catalog grid">
    <div class="content">
        <? foreach ($houses as $house) { ?>
        <div class="item-catalog">
            <div class="item-catalog-text">
                <?=  $house::getLocalitystring($house); ?>
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
                	<span><img src="<?= Url::base(true);?>/images/square.png" alt=""></span>
                    <?= $house['count_room']; ?> ком., <?= $house['total_area']; ?> м<sup>2</sup>
                </span>
                <span class="price"> $<?= $house['price']; ?></span>
            </div>
        </div>
    <? } ?>
    </div>
</div>
