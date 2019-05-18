<?
    use yii\helpers\Url;
?>
<div class="catalog grid">
    <div class="content">
        <? foreach ($buildings as $building) { ?>
        <div class="item-catalog">
            <div class="item-catalog-text">
                <?=  $building::getLocalitystring($building); ?>
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
                	<span><img src="<?= Url::base(true);?>/images/square.png" alt=""></span>
                    <?= $building['count_room']; ?> ком., <?= $building['total_area']; ?> м<sup>2</sup>
                </span>
                <span class="price"> $<?= $building['price']; ?></span>
            </div>
        </div>
        <?}?>
    </div>
</div>