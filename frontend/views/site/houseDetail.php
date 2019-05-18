<?
use common\models\Addsite;
use common\models\User;

use yii\helpers\Url;
use yii\bootstrap\Carousel;
?>
<? $this->title = Yii::t('app', 'House'); ?>
<?
$img = [];
$images = $house->getImages();
foreach ($images as $image){
    if($image){
        $img[] = '<img src="'. $image->getPathToOrigin(). '" alt="">';
    }
}
if(empty($img)){
    $img[] = '<img src="'. Url::base(true)."/images/no_image.png". '" alt="">';
}
?>
<div class="content">
    <?= Carousel::widget(['items'=>$img]); ?>
</div>
<div class="product">
    <div class="content">
        <div class="prod-desc">
            <span><?= Yii::t('app', 'Characteristics'); ?>:</span>
            <table>
                <tbody>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Price'); ?>:</td>
                    <td><?= $house['price']; ?></td>
                </tr>
                <tr>
                    <td class="options">ID:</td>
                    <td><?= $house['id']; ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Phone'); ?>:</td>
                    <td><?= User::findOne(Addsite::findOne(['idbase' => $house['id']])->user)->phone; ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Region Kharkiv'); ?>:</td>
                    <td><?= $house->getRegionKharkiv()->name; ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Street'); ?>:</td>
                    <td><?= $house->getStreet()->name;?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Count Room'); ?>:</td>
                    <td><?= $house['count_room']; ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Floor All'); ?>:</td>
                    <td><?= $house['floor_all']; ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Area House'); ?>:</td>
                    <td><?= $house['total_area_house']; ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Total Area') ?>:</td>
                    <td><?= $house['total_area'] ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Building Year'); ?>:</td>
                    <td><?= $house->building_year; ?></td>
                </tr>
                </tbody>
            </table>
            <span><?= Yii::t('app', 'Description'); ?>:</span>
            <p><?= $house['notesite']; ?></p>
        </div>
    </div>
</div>