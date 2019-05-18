<?
    use yii\helpers\Url;
?>
<? $this->title = Yii::t('app', 'Metrag'); ?>
    <div id="wrapper">
     <div class="flex-container">
        <div class="flexslider">
            <ul class="slides">
                <li>
                    <div class="block-slide"><img src="<?= Url::base(true);?>/images/slide1.png"  class="imgslide" /></div>
                    <div class="content">

                        <img class="hot" src="<?= Url::base(true);?>/images/slide1-content.png" alt="">
                        <span class="hot-h1">Горячее предложение</span>
                        <p class="hot-desc">Однокомнатная квартира в центре города. Мебелированная,<br /> есть технка для дома.</p>
                        <span class="hot-price"><span>5 000</span> в месяц</span>
                    </div>
                </li>
                <li>
                    <div class="block-slide"><img src="<?= Url::base(true);?>/images/slide1.png"  class="imgslide" /></div>
                   <div class="content"></div>
                </li>
                <li>
                    <div class="block-slide"><img src="<?= Url::base(true);?>/images/slide1.png"  class="imgslide" /></div>
                    <div class="content"></div>

                </li>
            </ul>
        </div>
    </div>
        <div class="category">
            <div class="content">
                <div class="line">

                    <span>
                        <h1>категории</h1>
                        <img src="<?= Url::base(true);?>/images/category-home.png" alt="">
                    </span>

                </div>
                <div class="item-cat">
                    <div class="item-cat-img">
                    <img src="<?= Url::base(true);?>/images/1.png" alt="">
                        <div class="caption">
                            <div class="blur"></div>
                            <a href="site/rent?view=grid">    <div class="caption-text">
                                <img src="<?= Url::base(true);?>/images/house.png"  alt="">
                            </div></a>
                        </div>
                    </div>
                    <div class="item-cat-text">
                        <span class="number">01</span>
                        <span class="name">Аренда</span>
                    </div>
                </div>
                <div class="item-cat">
                    <div class="item-cat-img">
                        <img src="<?= Url::base(true);?>/images/2.png" alt="">
                        <div class="caption">
                            <div class="blur"></div>
                            <a href="site/apartment?view=grid">   <div class="caption-text">
                                <img src="<?= Url::base(true);?>/images/house.png"  alt="">
                            </div></a>
                        </div>
                    </div>
                    <div class="item-cat-text">
                        <span class="number">02</span>
                        <span class="name">квартиры</span>
                    </div>
                </div>
                <div class="item-cat">
                    <div class="item-cat-img">
                        <img src="<?= Url::base(true);?>/images/3.png" alt="">
                        <div class="caption">
                            <div class="blur"></div>
                            <a href="site/building?view=grid">    <div class="caption-text">
                                <img src="<?= Url::base(true);?>/images/house.png"  alt="">
                            </div></a>
                        </div>
                    </div>
                    <div class="item-cat-text">
                        <span class="number">03</span>
                        <span class="name">новостройки</span>
                    </div>
                </div>
                <div class="item-cat">
                    <div class="item-cat-img">
                        <img src="<?= Url::base(true);?>/images/4.png" alt="">
                        <div class="caption">
                            <div class="blur"></div>
                            <a href="site/house?view=grid">   <div class="caption-text">
                                <img src="<?= Url::base(true);?>/images/house.png"  alt="">
                            </div></a>
                        </div>
                    </div>
                    <div class="item-cat-text">
                        <span class="number">04</span>
                        <span class="name" >дома</span>
                    </div>
                </div>
                <div class="item-cat">
                    <div class="item-cat-img">
                        <img src="<?= Url::base(true);?>/images/5.png" alt="">
                        <div class="caption">
                            <div class="blur"></div>
                            <a href="site/area?view=grid">    <div class="caption-text">
                                <img src="<?= Url::base(true);?>/images/house.png"  alt="">
                            </div></a>
                        </div>
                    </div>
                    <div class="item-cat-text">
                        <span class="number">05</span>
                        <span class="name">участки</span>
                    </div>
                </div>
                <div class="item-cat">
                    <div class="item-cat-img">
                        <img src="<?= Url::base(true);?>/images/6.png" alt="">
                        <div class="caption">
                            <div class="blur"></div>
                            <a href="site/commercial?view=grid">  <div class="caption-text">
                                <img src="<?= Url::base(true);?>/images/house.png"  alt="">
                            </div></a>
                        </div>
                    </div>
                    <div class="item-cat-text">
                        <span class="number">06</span>
                        <span class="name">коммерция</span>
                    </div>
                </div>
            </div>
        </div>



     <?
    $this->registerJs('
    $(document).ready(function() {
        $(\'.flexslider\').flexslider({
            animation: \'fade\',
            controlsContainer: \'.flexslider\'
        });
    });
    ')
    ?>