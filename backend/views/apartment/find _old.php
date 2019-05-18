<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;

use app\models\Apartment;
use app\models\ApartmentFind;
use app\models\RegionKharkivAdmin;
use app\models\TypeObject;
use app\models\Locality;
use app\models\RegionKharkiv;
use app\models\Region;
use app\models\Street;
use app\models\Course;
use app\models\WallMaterial;
use app\models\Condit;
use app\models\Wc;
use app\models\Users;
use app\models\UserType;

?>
<?
$this->title = Yii::t('app', 'Apartment Search');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="main-content">

    <?php $form = ActiveForm::begin([
              'method' => 'get',
              'action' => ['apartment/searchresult'],
              'layout' => 'horizontal'
          ]); ?>
    <div class="main-content-header">
        <div class="pull-left">
                <?= Yii::t('app', 'Apartments') ?>
        </div>
        <div class="pull-right">
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

      	<div class="container">
      	     <div class="col-xs-12 col-sm-12 col-md-12 ">
                
            
    		<div class="col-xs-6 col-sm-1 col-md-1 label-padding">
            <label for="">ID</label>    
            <?= $form->field($model['ApartmentFind'],'idFrom',['labelOptions' => ['class' => 'label-padding']])->textInput()->label(\Yii::t('yii','from')); ?>
            <?= $form->field($model['ApartmentFind'],'idTo')->textInput()->label(\Yii::t('yii','to')); ?>                
    		</div>
    		<div class="col-xs-6 col-sm-1 col-md-1 ">
    		<label for="">Комнат</label>	
    		<?= $form->field($model['ApartmentFind'],'count_roomFrom')->textInput()->label(\Yii::t('yii','from')); ?>
    		<?= $form->field($model['ApartmentFind'],'count_roomTo')->textInput()->label(\Yii::t('yii','to')); ?>
    		</div>
    		<div class="col-xs-6 col-sm-1 col-md-1 ">
    		<label for="">Цена</label>	
    		<?= $form->field($model['ApartmentFind'],'priceFrom')->textInput()->label(\Yii::t('yii','from')); ?>
    		<?= $form->field($model['ApartmentFind'],'priceTo')->textInput()->label(\Yii::t('yii','to')); ?>
    		</div>
    		<div class="col-xs-6 col-sm-1 col-md-1 ">
    		<label for="">Этаж</label>	
    		<?= $form->field($model['ApartmentFind'],'floorFrom')->textInput()->label(\Yii::t('yii','from')); ?>
    		<?= $form->field($model['ApartmentFind'],'floorTo')->textInput()->label(\Yii::t('yii','to')); ?>
    		</div>
    		<div class="col-xs-6 col-sm-1 col-md-1 ">
    		<label for="">Этажность</label>	
    		<?= $form->field($model['ApartmentFind'],'floor_allFrom')->textInput()->label(\Yii::t('yii','from')); ?>
    		<?= $form->field($model['ApartmentFind'],'floor_allTo')->textInput()->label(\Yii::t('yii','to')); ?>
    		</div>
    		<div class="col-xs-6 col-sm-1 col-md-1 ">
    		<label for="">Пл общ</label>	
    		<?= $form->field($model['ApartmentFind'],'total_areaFrom')->textInput()->label(\Yii::t('yii','from')); ?>
    		<?= $form->field($model['ApartmentFind'],'total_areaTo')->textInput()->label(\Yii::t('yii','to')); ?>
    		</div>
    		<div class="col-xs-6 col-sm-1 col-md-1 ">
    		<label for="">Пл жил</label>	
    		<?= $form->field($model['ApartmentFind'],'floor_areaFrom')->textInput()->label(\Yii::t('yii','from')); ?>
    		<?= $form->field($model['ApartmentFind'],'floor_areaTo')->textInput()->label(\Yii::t('yii','to')); ?>
    		</div>
    		<div class="col-xs-6 col-sm-1 col-md-1 ">
    		<label for="">Пл кухни</label>	
    		<?= $form->field($model['ApartmentFind'],'kitchen_areaFrom')->textInput()->label(\Yii::t('yii','from')); ?>
    		<?= $form->field($model['ApartmentFind'],'kitchen_areaTo')->textInput()->label(\Yii::t('yii','to')); ?>
    		</div>
    		<div class="col-xs-6 col-sm-1 col-md-1 ">
    		<label for="">Дата доб</label>
    		<?= $form->field($model['ApartmentFind'], 'date_addedFrom')->widget(DatePicker::className(),['dateFormat'=>'php:Y-m-d'])->label(\Yii::t('yii','from')); ?>	
    		<?= $form->field($model['ApartmentFind'], 'date_addedTo')->widget(DatePicker::className(),['dateFormat'=>'php:Y-m-d'])->label(\Yii::t('yii','to')); ?>	
    		</div>
    	</div>
	</div>

<!-- 
    <div class="col-xs-12 col-sm-12 col-md-12 divider-horizontal"></div>
    
    <?
        echo $form->field($model['TypeObject'], 'type_object_id',[
            'template' => "<div class=\"col-xs-6 col-sm-2 col-md-2 \">{label}\n<div class=\"scrollbox\">{input}</div></div>"])->checkboxList(
        TypeObject::find()->select(['name', 'type_object_id'])->where(['type_realty_id'=>'2'])->indexBy('type_object_id')->column(),
        ['prompt'=>'Select type'])->label('Тип объекта');
    ?>
        
    <?
        echo $form->field($model['RegionKharkivAdmin'], 'region_kharkiv_admin_id',[
            'template' => "<div class=\"col-xs-6 col-sm-2 col-md-2 \">{label}\n<div class=\"scrollbox\">{input}</div></div>"])->checkboxList(
        RegionKharkivAdmin::find()->select(['name', 'region_kharkiv_admin_id'])->orderby('name')->indexBy('region_kharkiv_admin_id')->column(),
        ['prompt'=>'Select region'])->label('РайонАдмин/Харьков');
    ?>
        
    <?
        echo $form->field($model['RegionKharkiv'], 'region_kharkiv_id',[
            'template' => "<div class=\"col-xs-6 col-sm-2 col-md-2 \">{label}\n <input id=\"region_kharkiv_search\"><div class=\"scrollbox\">{input}</div></div>"])->checkboxList(
        RegionKharkiv::find()->select(['name', 'region_kharkiv_id'])->orderby('name')->indexBy('region_kharkiv_id')->column(),
        ['prompt'=>'Select region'])->label('Район/Харьков');
    ?>
    
        
    <?
        echo $form->field($model['Region'], 'region_id',[
            'template' => "<div class=\"col-xs-6 col-sm-2 col-md-2 \">{label}\n <input id=\"region_search\"><div class=\"scrollbox\">{input}</div></div>"])->checkboxList(
        Region::find()->select(['name', 'region_id'])->orderby('name')->indexBy('region_id')->column(),
        ['prompt'=>'Select region','unselect' => null, ])->label('Район/Область');
    ?>
    
    
        
    <?
        echo $form->field($model['Locality'], 'locality_id',[
            'template' => "<div class=\"col-xs-6 col-sm-2 col-md-2 \">{label}\n <input id=\"locality_search\"><div class=\"scrollbox\">{input}</div></div>"])->checkboxList(
        Locality::find()->select(['name', 'locality_id'])->orderby('name')->indexBy('locality_id')->column())->label('Населенный пункт');
    ?>
        
    <?
        echo $form->field($model['Course'], 'course_id',[
            'template' => "<div class=\"col-xs-6 col-sm-2 col-md-2 \">{label}\n <input id=\"course_search\"><div class=\"scrollbox\">{input}</div></div>"])->checkboxList(
        Course::find()->select(['name', 'course_id'])->orderby('name')->indexBy('course_id')->column())->label('Направление');
    ?>
    
    <?
        echo $form->field($model['Street'], 'street_id',[
            'template' => "<div class=\"col-xs-6 col-sm-2 col-md-2 \">{label} <br> <input id=\"street_search\"><div class=\"scrollbox\">{input}</div></div>"])->checkboxList(
        Street::find()->select(['name', 'street_id'])->orderby('name')->indexBy('street_id')->column())->label('Улица');
    ?>
        
    <?
        echo $form->field($model['WallMaterial'], 'wall_material_id',[
            'template' => "<div class=\"col-xs-6 col-sm-2 col-md-2 \">{label}\n<div class=\"scrollbox\">{input}</div></div>"])->checkboxList(
        WallMaterial::find()->select(['name', 'wall_material_id'])->orderby('name')->indexBy('wall_material_id')->column())->label('Стены');
    ?>
        
    
    
    <?
        echo $form->field($model['Condit'], 'condit_id',[
            'template' => "<div class=\"col-xs-6 col-sm-2 col-md-2 \">{label}\n<div class=\"scrollbox\">{input}</div></div>"])->checkboxList(
        Condit::find()->select(['name', 'condit_id'])->orderby('name')->indexBy('condit_id')->column())->label('Состояние');
    ?>
    
    <?
        echo $form->field($model['Wc'], 'wc_id',[
            'template' => "<div class=\"col-xs-6 col-sm-2 col-md-2 \">{label}\n<div class=\"scrollbox\">{input}</div></div>"])->checkboxList(
        Wc::find()->select(['name', 'wc_id'])->orderby('name')->indexBy('wc_id')->column())->label('Сан. узел');
    ?>
        
    <?
        echo $form->field($model['UserType'], 'author_id',[
            'template' => "<div class=\"col-xs-6 col-sm-2 col-md-2 \">{label}\n<div class=\"scrollbox\">{input}</div></div>"])->checkboxList(
        Users::find()->select(['name', 'id'])->orderby('name')->indexBy('id')->column())->label('Автор');
    ?>
    
    <?
        echo $form->field($model['UserType'], 'update_author_id',[
            'template' => "<div class=\"col-xs-6 col-sm-2 col-md-2 \">{label}\n<div class=\"scrollbox\">{input}</div></div>"])->checkboxList(
        Users::find()->select(['name', 'id'])->orderby('name')->indexBy('id')->column())->label('Изменил дпи');
    ?>
    
    
        
    <?
        echo $form->field($model['UserType'], 'update_photo_user_id',[
            'template' => "<div class=\"col-xs-6 col-sm-2 col-md-2 \">{label}\n<div class=\"scrollbox\">{input}</div></div>"])->checkboxList(
        Users::find()->select(['name', 'id'])->orderby('name')->indexBy('id')->column())->label(\Yii::t('yii', '(Кто обновил фото)'));
    ?>
        
    <?
        echo $form->field($model['UserType'], 'exclusive_user_id',[
            'template' => "<div class=\"col-xs-6 col-sm-2 col-md-2 \">{label}\n<div class=\"scrollbox\">{input}</div></div>"])->checkboxList(
        Users::find()->select(['name', 'id'])->orderby('name')->indexBy('id')->column())->label('Экслюзив');
    ?>
    
    <?
        echo $form->field($model['ApartmentFind'], 'middle_floor',[
            'template' => "<div class=\"col-xs-1 col-sm-1 col-md-1 \">{label}\n{input}</div>"])->radioList(['1' => \Yii::t('yii','Yes'), '0' => \Yii::t('yii','No'), '2' => \Yii::t('yii','All')])->label(\Yii::t('yii','Middle floor'));
    ?>
    
    <?
        echo $form->field($model['ApartmentFind'], 'no_mediators',[
            'template' => "<div class=\"col-xs-1 col-sm-1 col-md-1 \">{label}\n{input}</div>"])->radioList(['1' => \Yii::t('yii','Yes'), '0' => \Yii::t('yii','No'), '2' => \Yii::t('yii','All')])->label(\Yii::t('yii','No mediators'));
    ?>
    
    <?
        echo $form->field($model['ApartmentFind'], 'exchange',[
            'template' => "<div class=\"col-xs-1 col-sm-1 col-md-1 \">{label}\n{input}</div>"])->radioList(['1' => \Yii::t('yii','Yes'), '0' => \Yii::t('yii','No'), '2' => \Yii::t('yii','All')])->label(\Yii::t('yii','Exchange'));
    ?>
    
    <?
        echo $form->field($model['ApartmentFind'], 'enabled',[
            'template' => "<div class=\"col-xs-1 col-sm-1 col-md-1 \">{label}\n{input}</div>"])->radioList(['0' => \Yii::t('yii','Yes'), '1' => \Yii::t('yii','No'), '2' => \Yii::t('yii','All')])->label(\Yii::t('yii','Archive'));
    ?>
    
    <?
        echo $form->field($model['ApartmentFind'], 'note',[
            'template' => "<div class=\"col-xs-1 col-sm-1 col-md-1 \">{label}\n{input}</div>"])->radioList(['1' => \Yii::t('yii','Yes'), '0' => \Yii::t('yii','No'), '2' => \Yii::t('yii','All')])->label(\Yii::t('yii','Note'));
    ?>
    
    <?= $form->field($model['ApartmentFind'],'phone',[
            'template' => "<div class=\"col-xs-3 col-sm-3 col-md-2 \">{label}\n{input}</div>"])->textInput()->label(\Yii::t('yii','Phone')); ?>
    
    <div class="col-xs-12 col-sm-12 col-md-12 divider-horizontal"></div> -->	

<?php ActiveForm::end(); ?>

</div>


<?
    $this->registerJs('
	$("#street_search, #region_search, #region_kharkiv_search, #locality_search, course_search").keyup(function(){
        var search_string = $(this).val().toLowerCase();
        var arr = $(this).parent().find("div.scrollbox > div > div > label");
	    if(search_string === "") {
            arr.css("display", "block");
        } else {
            arr.css("display", "none");
            arr.each(function(){
                if($(this).text().toLowerCase().trim().indexOf(search_string) === 0) {
                    $(this).css("display", "block");
                }
            });
        }
    });	
');
?>