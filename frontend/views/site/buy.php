<?php
use yii\helpers\Url;
?>
<div class="padding ">
    <div class="product">
        <div class="content">
            <div class="line">
            <span>
                <h1><?= Yii::t('app', 'BUY PROPERTY')?></h1>
                <img src="<?= Url::base(true);?>/images/category-home.png" alt="">
            </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9 col-xs-9">
            <div id="node-161" class="node">
                <div class="clear-block">
                    <div id="block_container">
                        <div class="main-block row">
                            <div class="col-md-3 property first">
                                <div class="text-center flats">
                                     <span class="prop h2">
                                         <?= Yii::t('app', 'APARTMENTS')?>
                                     </span>
                                    <a href="/site/apartment?view=grid" class="btn-index-flat house"><?= Yii::t('app', 'LOOK')?></a>
                                </div>
                            </div>
                            <div class="col-md-3 property">
                                <div class="text-center hous">
                                     <span class="prop h2">
                                         <?= Yii::t('app', 'HOUSE')?>
                                     </span>
                                    <a href="/site/house?view=grid" class="btn-index-flat house"><?= Yii::t('app', 'LOOK')?></a>
                                </div>
                            </div>
                            <div class="col-md-3 property">
                                <div class="text-center districts">
                     <span class="prop h2">
                         <?= Yii::t('app', 'LAND')?>
                     </span>
                                    <a href="/site/area?view=grid" class="btn-index-flat house"><?= Yii::t('app', 'LOOK')?></a>
                                </div>
                            </div>
                            <div class="col-md-3 property noborder">
                                <div class="text-center comercials">
                     <span class="prop h2">
                         <?= Yii::t('app', 'COMMERCIAL')?>
                     </span>
                                    <a href="/site/commercial?view=grid" class="btn-index-flat house"><?= Yii::t('app', 'LOOK')?></a>
                                </div>
                            </div>
                        </div>

                        <div class="promo_links row row-eq-height">
                            <div class="promo-links col-xs-6 col-md-3  ">

                                <p class="h3"><?= Yii::t('app', 'Apartments for sale')?></p>
                                <ul class="">
                                    <li><a href="/site/apartment?view=grid&ApartmentSearch%5Blocation%5D=0">
                                            <?php echo 'квартиры в Харькове'; ?>
                                        </a></li>
                                    <li><a href="/site/apartment?view=grid&ApartmentSearch%5Blocation%5D=1">
                                            <?php echo 'квартиры под Харьковом'; ?>
                                        </a></li>
                                    <li><a href="/site/apartment?view=grid&ApartmentSearch%5Bcount_roomFrom%5D=1&ApartmentSearch%5Bcount_roomTo%5D=1">
                                            <?php echo '1 комнатные квартиры'; ?>
                                        </a></li>
                                    <li><a href="/site/apartment?view=grid&ApartmentSearch%5Bcount_roomFrom%5D=2&ApartmentSearch%5Bcount_roomTo%5D=2">
                                            <?php echo '2 комнатные квартиры'; ?>
                                        </a></li>
                                    <li><a href="/site/apartment?view=grid&ApartmentSearch%5Bcount_roomFrom%5D=3&ApartmentSearch%5Bcount_roomTo%5D=3">
                                            <?php echo '3 комнатные квартиры'; ?>
                                        </a></li>
                                    <li><a href="/site/apartment?view=grid&ApartmentSearch%5Bcount_roomFrom%5D=4&ApartmentSearch%5Bcount_roomTo%5D=4">
                                            <?php echo '4 комнатные квартиры'; ?>
                                        </a></li>
                                    <li><a href="/site/building?view=grid">
                                            <?php echo 'квартиры в новостройках'; ?>
                                        </a></li>

                                </ul>
                            </div>
                            <div class="promo-links col-xs-6 col-md-3  ">
                                <p class="h3"><?= Yii::t('app', 'Houses for sale'); ?></p>
                                <ul class="">
                                    <li><a href="/site/house?view=grid&HouseSearch%5Blocation%5D=0">
                                            <?php echo 'дома в Харькове'; ?>
                                        </a></li>
                                    <li><a href="/site/house?view=grid&HouseSearch%5Blocation%5D=1">
                                            <?php echo 'дома под Харьковом'; ?>
                                        </a></li>
                                </ul>
                            </div>
                            <div class="promo-links col-xs-6 col-md-3">
                                <p class="h3"><?= Yii::t('app', 'Areas for sale'); ?></p>
                                <ul class="">
                                    <li><a href="/site/area?view=grid&AreaSearch%5Blocation%5D=0">
                                            <?php echo 'участки в Харькове'; ?>
                                        </a></li>
                                    <li><a href="/site/area?view=grid&AreaSearch%5Blocation%5D=1">
                                            <?php echo 'участки под Харьковом'; ?>
                                        </a></li>
                                </ul></div>
                            <div class="promo-links col-xs-6 col-md-3">
                                <p class="h3"><?= Yii::t('app', 'Commercials for sale'); ?></p>
                                <ul class="">
                                    <li><a href="/site/commercial?view=grid&CommercialSearch%5Btype_object_id%5D=11">
                                            <?php echo 'офисы'; ?>
                                        </a></li>
                                    <li><a href="/site/commercial?view=grid&CommercialSearch%5Btype_object_id%5D=10">
                                            <?php echo 'гаражи'; ?>
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
                                    <?php foreach ($apartments as $apartment){?>
                                    <div class="div_h">
                                        <a href="/site/apartment-detail?id=<?php echo $apartment->id; ?>" class="link">
                                            <div class="promo_image_container">
                                                <img class="img_h" src="<? $image = $apartment->getImage();
                                                if($image){
                                                    echo $image->getPathToOrigin();
                                                }
                                                else
                                                    echo Url::base(true)."/images/2.png"; ?>
                                                                        " alt="<?php echo Url::base(true)."/images/2.png"; ?>" width=150>
                                                    </div>
                                            <?php
                                                if($apartment->city_or_region == 0)
                                                {
                                                    $district = $apartment->getRegionKharkiv()->name;
                                                    $street = $apartment->getStreet()->name;
                                                    $textview = Yii::t('app', 'Kharkiv') . ', ' . $district . ", " . $street;
                                                }
                                                elseif($apartment->city_or_region == 1)
                                                {
                                                    $district = $apartment->getLocality()->name;
                                                    $street = $apartment->getStreet()->name;
                                                    $textview= $district . ", " . $street;
                                                }
                                                echo $textview;
                                                ?>
                                                <br></a>
                                                <span class="size"><?php echo $apartment->count_room; ?>ком.,<?php echo $apartment->total_area; ?>кв.м.</span><br><b><?php echo $apartment->price?>$</b>
                                                </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="col-md-3 ">
                                <div class="promo_obj">
                                    <?php foreach ($houses as $house){?>
                                        <div class="div_h">
                                            <a href="/site/house-detail?id=<?php echo $house->id; ?>" class="link">
                                                <div class="promo_image_container">
                                                    <img class="img_h" src="<? $image = $house->getImage();
                                                    if($image){
                                                        echo $image->getPathToOrigin();
                                                    }
                                                    else
                                                        echo Url::base(true)."/images/4.png"; ?>
                                                                        " alt="<?php echo Url::base(true)."/images/4.png"; ?>" width=150>
                                                </div>
                                                <?php
                                                if($house->city_or_region == 0)
                                                {
                                                    $district = $house->getRegionKharkiv()->name;
                                                    $street = $house->getStreet()->name;
                                                    $textview = Yii::t('app', 'Kharkiv') . ', ' . $district . ", " . $street;
                                                }
                                                elseif($house->city_or_region == 1)
                                                {
                                                    $district = $house->getLocality()->name;
                                                    $street = $house->getStreet()->name;
                                                    $textview= $district . ", " . $street;
                                                }
                                                echo $textview;
                                                ?>
                                                <br></a>
                                            <span class="size"><?php echo $house->total_area; ?>кв.м.</span><br><b><?php echo $house->price?>$</b>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="col-md-3 ">
                                <div class="promo_obj">
                                    <?php foreach ($areas as $area){?>
                                        <div class="div_h">
                                            <a href="/site/house-detail?id=<?php echo $area->id; ?>" class="link">
                                                <div class="promo_image_container">
                                                    <img class="img_h" src="<? $image = $area->getImage();
                                                    if($image){
                                                        echo $image->getPathToOrigin();
                                                    }
                                                    else
                                                        echo Url::base(true)."/images/5.png"; ?>
                                                                        " alt="<?php echo Url::base(true)."/images/5.png"; ?>" width=150>
                                                </div>
                                                <?php
                                                if($area->city_or_region == 0)
                                                {
                                                    $district = $area->getRegionKharkiv()->name;
                                                    $street = $area->getStreet()->name;
                                                    $textview = Yii::t('app', 'Kharkiv') . ', ' . $district . ", " . $street;
                                                }
                                                elseif($area->city_or_region == 1)
                                                {
                                                    $district = $area->getLocality()->name;
                                                    $street = $area->getStreet()->name;
                                                    $textview= $district . ", " . $street;
                                                }
                                                echo $textview;
                                                ?>
                                                <br></a>
                                            <span class="size"><?php echo $area->total_area; ?>кв.м.</span><br><b><?php echo $area->price?>$</b>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="col-md-3 noborder">
                                <div class="promo_obj">
                                    <?php foreach ($commercials as $commercial){?>
                                        <div class="div_h">
                                            <a href="/site/house-detail?id=<?php echo $commercial->id; ?>" class="link">
                                                <div class="promo_image_container">
                                                    <img class="img_h" src="<? $image = $commercial->getImage();
                                                    if($image){
                                                        echo $image->getPathToOrigin();
                                                    }
                                                    else
                                                        echo Url::base(true)."/images/6.png"; ?>
                                                                        " alt="<?php echo Url::base(true)."/images/6.png"; ?>" width=150>
                                                </div>
                                                <?php
                                                if($commercial->city_or_region == 0)
                                                {
                                                    $district = $commercial->getRegionKharkiv()->name;
                                                    $street = $commercial->getStreet()->name;
                                                    $textview = Yii::t('app', 'Kharkiv') . ', ' . $district . ", " . $street;
                                                }
                                                elseif($commercial->city_or_region == 1)
                                                {
                                                    $district = $commercial->getLocality()->name;
                                                    $street = $commercial->getStreet()->name;
                                                    $textview= $district . ", " . $street;
                                                }
                                                echo $textview;
                                                ?>
                                                <br></a>
                                            <span class="size"><?php echo $commercial->total_area; ?>кв.м.</span><br><b><?php echo $commercial->price?>$</b>
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









