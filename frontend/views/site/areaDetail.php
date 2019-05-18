<?
    use common\models\Addsite;
    use common\models\User;

    use yii\helpers\Url;
    use yii\bootstrap\Carousel;
?>
<? $this->title = Yii::t('app', 'Area'); ?>
<?
    $img = [];
    $images = $area->getImages();
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
                    <td><?= $area['price']; ?></td>
                </tr>
                <tr>
                    <td class="options">ID:</td>
                    <td><?= $area['id']; ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Phone'); ?>:</td>
                    <td><?= User::findOne(Addsite::findOne(['idbase' => $area['id']])->user)->phone; ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Region Kharkiv'); ?>:</td>
                    <td><?= $area->getRegionKharkiv()->name; ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Street'); ?>:</td>
                    <td><?= $area->getStreet()->name;?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Total Area'); ?>:</td>
                    <td><?= $area['total_area']; ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Presence of a house for demolition'); ?>:</td>
                    <td><?= $area->house_demolition == 1 ? Yii::t('app', 'Yes') : Yii::t('app', 'No'); ?></td>
                </tr>
                <tr>
                    <td class="options"><?= Yii::t('app', 'Presence of state act'); ?>:</td>
                    <td><?= $area->state_act == 1 ? Yii::t('app', 'Yes') : Yii::t('app', 'No'); ?></td>
                </tr>
                </tbody>
            </table>
            <span><?= Yii::t('app', 'Description'); ?>:</span>
            <p><?= $area['notesite']; ?></p>
        </div>
    </div>
</div>