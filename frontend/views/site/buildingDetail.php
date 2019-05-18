<?
use common\models\Street;
use common\models\RegionKharkiv;
use common\models\Metro;
use common\models\WallMaterial;
use common\models\Addsite;
use common\models\User;

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Carousel;

?>
<? $this->title = Yii::t('app', 'Building'); ?>
<?
$img = [];
$images = $building->getImages();
foreach ($images as $image){
    if($image){
        $img[] = '<img src="'. $image->getPathToOrigin(). '" alt="">';
    }
}
if(empty($img)){
    $img[] = '<img src="'. Url::base(true)."/images/no_image.png". '" alt="">';
}
?>
<div class="content" style="" >
    <?= Carousel::widget(['items'=>$img]); ?>
</div>


<div class="product">
    <div class="content">


        <div class="prod-desc">
            <span><?= Yii::t('app', 'Characteristics') ?>:</span>
            <table>
                <tbody>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Price') ?>:</td>
                    <td><?= $building['price'] ?></td>
                </tr>
                <tr>
                    <td class="options">ID:</td>
                    <td><?= $building['id'] ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Phone') ?>:</td>
                    <td><?= User::findOne(Addsite::findOne(['idbase' => $building['id']])->user)->phone ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Region Kharkiv') ?>:</td>
                    <td><?= $building->getRegionKharkiv()->name; ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Street') ?>:</td>
                    <td><?= $building->getStreet()->name;?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Metro') ?>:</td>
                    <td><?= $building->getMetro()->name; ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Count Room') ?>:</td>
                    <td><?= $building['count_room'] ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Floor') ?> / <?= Yii::t('app', 'Floor All') ?>:</td>
                    <td><?= $building['floor'] ?> / <?= $building['floor_all'] ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Area (total/floor/kitchen)') ?>:</td>
                    <td><?= $building['total_area'] ?> / <?= $building['floor_area'] ?> / <?= $building['kitchen_area'] ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Wall Material') ?>:</td>
                    <td><?= $building->getWallMaterial()->name; ?></td>
                </tr>
                </tbody>
            </table>
            <span><?= Yii::t('app', 'Description') ?>:</span>
            <p><?= $building['notesite'] ?></p>
        </div>
    </div>
</div>


