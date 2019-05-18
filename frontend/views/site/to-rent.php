<?php
use yii\helpers\Url;
?>
<div class="padding ">
    <div class="product">
    <div class="content">
    <div class="line">
        <span>
            <h1><?= Yii::t('app', 'RENT PROPERTY')?></h1>
            <img src="<?= Url::base(true);?>/images/category-home.png" alt="">
        </span>
    </div>

</div>
</div>
<div class="row">
    <div class="col-md-9 col-xs-9">
        <div id="node-161" class="node">
            <span class="submitted"></span>

            <div class="content clear-block">
                <div id="block_container">
                    <div class="main-block row">
                        <div class="col-md-3  property  first">
                            <div class="text-center flats">
                                <span class="prop h2">
                                         <?= Yii::t('app', 'APARTMENTS')?>
                                     </span>
                                <a href="/site/rent?view=grid&RentSearch%5Btype_object_id%5D=6" class="btn-index-flat house"><?= Yii::t('app', 'LOOK')?></a>
                            </div>
                        </div>
                        <div class="col-md-3  property  ">
                            <div class="text-center hous">
                                <span class="prop h2">
                                         <?= Yii::t('app', 'HOUSE')?>
                                     </span>
                                <a href="/site/rent?view=grid&RentSearch%5Btype_object_id%5D=5" class="btn-index-flat house"><?= Yii::t('app', 'LOOK')?></a>
                            </div>
                        </div>

                    </div>

                    <div class="promo_links  row row-eq-height">
                        <div class="promo-links col-xs-6 col-md-3  ">

                            <p class="h3"><?= Yii::t('app', 'Apartments for rent')?></p>
                            <ul class="">
                                <li><a href="/site/rent?view=grid&RentSearch%5Btype_object_id%5D=6&RentSearch%5Blocation%5D=0">
                                        <?php echo 'квартиры в Харькове'; ?>
                                    </a></li>
                                <li><a href="/site/rent?view=grid&RentSearch%5Btype_object_id%5D=6&RentSearch%5Blocation%5D=1">
                                        <?php echo 'квартиры под Харьковом'; ?>
                                    </a></li>
                                <li><a href="/site/rent?view=grid&RentSearch%5Btype_object_id%5D=6&RentSearch%5Bcount_roomFrom%5D=1&RentSearch%5Bcount_roomTo%5D=1">
                                        <?php echo '1 комнатные квартиры'; ?>
                                    </a></li>
                                <li><a href="/site/rent?view=grid&RentSearch%5Btype_object_id%5D=6&RentSearch%5Bcount_roomFrom%5D=2&RentSearch%5Bcount_roomTo%5D=2">
                                        <?php echo '2 комнатные квартиры'; ?>
                                    </a></li>
                                <li><a href="/site/rent?view=grid&RentSearch%5Btype_object_id%5D=6&RentSearch%5Bcount_roomFrom%5D=3&RentSearch%5Bcount_roomTo%5D=3">
                                        <?php echo '3 комнатные квартиры'; ?>
                                    </a></li>
                                <li><a href="/site/rent?view=grid&RentSearch%5Btype_object_id%5D=6&RentSearch%5Bcount_roomFrom%5D=4&RentSearch%5Bcount_roomTo%5D=4">
                                        <?php echo '4 комнатные квартиры'; ?>
                                    </a></li>
                            </ul></div>
                        <div class="promo-links col-xs-6 col-md-3  ">
                            <p class="h3"><?= Yii::t('app', 'Houses for rent'); ?></p>
                            <ul class="">
                                <li><a href="/site/rent?view=grid&RentSearch%5Btype_object_id%5D=5&RentSearch%5Blocation%5D=0">
                                        <?php echo 'дома в Харькове'; ?>
                                    </a></li>
                                <li><a href="/site/rent?view=grid&RentSearch%5Btype_object_id%5D=5&RentSearch%5Blocation%5D=1">
                                        <?php echo 'дома под Харьковом'; ?>
                                    </a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="h3 promo_obj_title clearfix">
                        <?php echo 'Промо-объекты'; ?>
                    </div>
                    <div class="promo_objects row">
                        <div class="col-md-3 ">
                            <div class="promo_obj">
                                <?php foreach ($rents as $rent){?>
                                    <div class="div_h">
                                        <a href="/site/rent-detail?id=<?php echo $rent->id; ?>" class="link">
                                            <div class="promo_image_container">
                                                <img class="img_h" src="<? $image = $rent->getImage();
                                                if($image){
                                                    echo $image->getPathToOrigin();
                                                }
                                                else
                                                    echo Url::base(true)."/images/2.png"; ?>
                                                                        " alt="<?php echo Url::base(true)."/images/2.png"; ?>" width=150>
                                            </div>
                                            <?php
                                            if($rent->city_or_region == 0)
                                            {
                                                $district = $rent->getRegionKharkiv()->name;
                                                $street = $rent->getStreet()->name;
                                                $textview = Yii::t('app', 'Kharkiv') . ', ' . $district . ", " . $street;
                                            }
                                            elseif($rent->city_or_region == 1)
                                            {
                                                $district = $rent->getLocality()->name;
                                                $street = $rent->getStreet()->name;
                                                $textview= $district . ", " . $street;
                                            }
                                            echo $textview;
                                            ?>
                                            <br></a>
                                        <span class="size"><?php echo $rent->count_room; ?>ком.,</span><br><b><?php echo $rent->price?>$</b>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php  echo $this->render('/layouts/_rightblock'); ?>
        </div>
    </div>
