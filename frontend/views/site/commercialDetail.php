<?
use common\models\Addsite;
use common\models\User;

use yii\helpers\Url;
use yii\bootstrap\Carousel;
?>
<? $this->title = Yii::t('app', 'Commercial'); ?>
<?
$img = [];
$images = $commercial->getImages();
foreach ($images as $image){
    if($image){
        $img[] = '<img src="'. $image->getPathToOrigin(). '" alt="">';
    }
}
if(empty($img)){
    $img[] = '<img src="'. Url::base(true)."/images/no_image.png". '" alt="">';
}
?>
<div class="content" >
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
                    <td><?= $commercial['price']; ?></td>
                </tr>
                <tr>
                    <td class="options">ID:</td>
                    <td><?= $commercial['id']; ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Phone'); ?>:</td>
                    <td><?= User::findOne(Addsite::findOne(['idbase' => $commercial['id']])->user)->phone; ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Region Kharkiv'); ?>:</td>
                    <td><?= $commercial->getRegionKharkiv()->name; ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Street'); ?>:</td>
                    <td><?= $commercial->getStreet()->name; ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Metro'); ?>:</td>
                    <td><?= $commercial->getMetro()->name; ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Count Room'); ?>:</td>
                    <td><?= $commercial['count_room']; ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Floor'); ?> / <?= Yii::t('app', 'Floor All'); ?>:</td>
                    <td><?= $commercial['floor']; ?> / <?= $commercial['floor_all']; ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Total Area'); ?>:</td>
                    <td><?= $commercial['total_area']; ?></td>
                </tr>
            </tbody>
            </table>
            <span><?= Yii::t('app', 'Description'); ?>:</span>
            <p><?= $commercial['notesite']; ?></p>
        </div>
    </div>
</div>


