<?php
use frontend\controllers\SiteController;
use yii\widgets\LinkPager;
use yii\helpers\Url;
?>
<? $this->title = Yii::t('app', 'Rent'); ?>
<?php  echo $this->render('_rent-search', ['model' => $searchModel]); ?>
<div class="filter-2">
    <div class="content">
        <div class="type-list">
            <ul>
                <li><span>Вид списка:</span></li>
                <li><a href="" title=""><img src="<?= Url::base(true);?>/images/grid.png" id="grid" alt=""></a></li>
                <li><a href="" title=""><img src="<?= Url::base(true);?>/images/list.png" id="list" alt=""></a></li>
            </ul>
        </div>
        <!--
                <div class="currency">
                    <span class="currency-text">Валюта:</span>
                        <form action="" >
                            <div id="radios">
                                <input id="option1" name="options" type="radio">
                                    <label for="option1">UAH </label>
                                    <input id="option2" name="options" type="radio">
                                    <label for="option2">USD</label>
                                    <input id="option3" name="options" type="radio" checked>
                                    <label for="option3">EUR</label>
                            </div>
                        </form>
                </div>
         -->
    </div>
</div>



<?php
if($_GET['view'] == 'grid')
    require('rent-grid.php');
if($_GET['view'] == 'list')
    require('rent-list.php');
?>
<? echo LinkPager::widget([
    'pagination' => $pages,

]);?>



<script>
    $(document).ready(function() {
        $('select').selecter();
    });

</script>
