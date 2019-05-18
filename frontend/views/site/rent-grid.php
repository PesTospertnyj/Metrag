<?
    use yii\helpers\Url;
?>
<div class="catalog grid">
    <div class="content">
        <? foreach ($rents as $rent) { ?>
        <div class="item-catalog">
            <div class="item-catalog-text">
                <?=  $rent::getLocalitystring($rent); ?>
            </div>
            <div class="item-catalog-img">
                <img src="<?
                if($rent) $image = $rent->getImage();
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
                	<span><img src="<?= Url::base(true);?>/images/square.png" alt=""></span>
                    <?= $rent['count_room']; ?> ком.
                </span>
                <span class="price"> $<?= $rent['price']; ?></span>
            </div>
        </div>
        <? } ?>
    </div>
</div>
