<?
    use yii\helpers\Url;
?>
<div class="catalog grid">
    <div class="content">
        <? foreach ($areas as $area) { ?>
        <div class="item-catalog">
            <div class="item-catalog-text">
                <?=  $area::getLocalitystring($area); ?>
            </div>
            <div class="item-catalog-img">
                <img src="<? $image = $area->getImage();
                if($image){
                    echo $image->getPathToOrigin();
                }
                else
                    echo Url::base(true)."/images/2.png"; ?>" alt="">
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
                	<span><img src="<?= Url::base(true);?>/images/square.png" alt=""></span>
                    <?= $area['total_area']; ?> м<sup>2</sup>
                </span>
                <span class="price"> $<?= $area['price']; ?></span>
            </div>
        </div>
        <?}?>
    </div>
</div>