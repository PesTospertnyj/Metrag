<?
	use common\models\Street;
	use common\models\RegionKharkiv;
	use common\models\Metro;
	use common\models\WallMaterial;
    use common\models\Addsite;
    use common\models\User;

    use yii\helpers\Url;
    use yii\bootstrap\Carousel;
?>
<? $this->title = Yii::t('app', 'Apartment'); ?>
	 	<?
    	$img = [];
    	$images = $apartment->getImages();
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
			  			<td><?= $apartment['price']; ?></td>
			 		</tr>
			 		<tr>
			  			<td class="options">ID:</td>
			  			<td><?= $apartment['id']; ?></td>
			 		</tr>
             		<tr>
			  			<td class="options"><?= Yii::t('app', 'Phone'); ?>:</td>
			  			<td><?= User::findOne(Addsite::findOne(['idbase' => $apartment['id']])->user)->phone; ?></td>
			 		</tr>
	 				<tr>
				  		<td class="options"><?= Yii::t('app', 'Region Kharkiv') ?>:</td>
				  		<td><?= $apartment->getRegionKharkiv()->name; ?></td>
				 	</tr>
				 	<tr>
				  		<td class="options"><?= Yii::t('app', 'Street'); ?>:</td>
				  		<td><?= $apartment->getStreet()->name; ?></td>
				 	</tr>
				  	<tr>
	 			  		<td class="options"><?= Yii::t('app', 'Metro'); ?>:</td>
	    		  		<td><?= $apartment->getMetro()->name; ?></td>
	    		  	</tr>
	    		  	<tr>
				  		<td class="options"><?= Yii::t('app', 'Count Room'); ?>:</td>
				  		<td><?= $apartment['count_room']; ?></td>
				 	</tr>
	             	<tr>
				  		<td class="options"><?= Yii::t('app', 'Floor'); ?> / <?= Yii::t('app', 'Floor All'); ?>:</td>
				  		<td><?= $apartment['floor']; ?> / <?= $apartment['floor_all']; ?></td>
				 	</tr>
	             	<tr>
				  		<td class="options"><?= Yii::t('app', 'Area (total/floor/kitchen)'); ?>:</td>
				  		<td><?= $apartment['total_area']; ?> / <?= $apartment['floor_area']; ?> / <?= $apartment['kitchen_area']; ?></td>
				 	</tr>
					<tr>
				  		<td class="options"><?= Yii::t('app', 'Wall Material'); ?>:</td>
				  	  	<td><?= $apartment->getWallMaterial()->name; ?></td>
                    </tr>
					<tr>
				  		<td class="options"><?= Yii::t('app', 'Count Balcony'); ?>:</td>
				  		<td><?= $apartment['count_balcony']; ?></td>
				 	</tr>
				</tbody>
          	</table>
        	<span><?= Yii::t('app', 'Description'); ?>:</span>
        	<p><?= $apartment['notesite']; ?></p>
		</div>
	</div>
</div>