<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
//use yii\jui\DatePicker;
use kartik\date\DatePicker;

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

    <div class="container-fluid">
    <?$template = "<div class=\"wrap-find\"><div class=\"col-lg-3 padding-null\">{label}</div>\n<div class=\"col-lg-9 find-input\">{input}</div>\n</div>" ?>
        
    <div class="col-xs-12 col-sm-12 col-md-12 ">
            <div class="col-xs-6 col-sm-2 col-md-1">
            <label for="" class="from-to-label">ID</label>    
            <?= $form->field($model['ApartmentFind'],'idFrom', [
                    'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
                <?= $form->field($model['ApartmentFind'],'idTo', [
                    'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>                  
            </div>
            <div class="col-xs-6 col-sm-2 col-md-1 ">
            <label for="" class="from-to-label">Комнат</label>    
            <?= $form->field($model['ApartmentFind'],'count_roomFrom', [
                    'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
            <?= $form->field($model['ApartmentFind'],'count_roomTo', [
                    'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
            </div>
            <div class="col-xs-6 col-sm-2 col-md-1 ">
            <label for="" class="from-to-label">Цена</label>  
            <?= $form->field($model['ApartmentFind'],'priceFrom', [
                    'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
            <?= $form->field($model['ApartmentFind'],'priceTo', [
                    'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
            </div>
            <div class="col-xs-6 col-sm-2 col-md-1 ">
            <label for="" class="from-to-label">Этаж</label>  
            <?= $form->field($model['ApartmentFind'],'floorFrom', [
                    'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
            <?= $form->field($model['ApartmentFind'],'floorTo', [
                    'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
            </div>
            <div class="col-xs-6 col-sm-2 col-md-1 ">
            <label for="" class="from-to-label">Этажность</label> 
            <?= $form->field($model['ApartmentFind'],'floor_allFrom', [
                    'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
            <?= $form->field($model['ApartmentFind'],'floor_allTo', [
                    'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
            </div>
            <div class="col-xs-6 col-sm-2 col-md-1 ">
            <label for="" class="from-to-label">Пл общ</label>    
            <?= $form->field($model['ApartmentFind'],'total_areaFrom', [
                    'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
            <?= $form->field($model['ApartmentFind'],'total_areaTo', [
                    'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
            </div>
            <div class="col-xs-6 col-sm-2 col-md-1 ">
            <label for="" class="from-to-label">Пл жил</label>    
            <?= $form->field($model['ApartmentFind'],'floor_areaFrom', [
                    'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
            <?= $form->field($model['ApartmentFind'],'floor_areaTo', [
                    'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
            </div>
            <div class="col-xs-6 col-sm-2 col-md-1 ">
            <label for="" class="from-to-label">Пл кухни</label>  
            <?= $form->field($model['ApartmentFind'],'kitchen_areaFrom', [
                    'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
            <?= $form->field($model['ApartmentFind'],'kitchen_areaTo', [
                    'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
            </div>
            <? $template_date = "<div class=\"wrap-find\"><div class=\"col-lg-1 padding-null\">{label}</div>\n<div class=\"col-lg-11 find-input\">{input}</div>\n</div>"?>
            <div class="col-xs-6 col-sm-4 col-md-3 ">
           <label for="" class="from-to-label">Дата доб</label>
           <?= $form->field($model['ApartmentFind'], 'date_addedFrom', [
                   'template' => $template_date, 'labelOptions' => ['class' => '']])->widget(DatePicker::classname(), [
    'options' => ['placeholder' => \Yii::t('yii','Enter date ...')],
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ]
])->label(\Yii::t('yii','from')); ?>    
           <?= $form->field($model['ApartmentFind'], 'date_addedTo', [
                   'template' => $template_date, 'labelOptions' => ['class' => '']])->widget(DatePicker::classname(), [
    'options' => ['placeholder' => \Yii::t('yii','Enter date ...')],
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ]
])->label(\Yii::t('yii','to')); ?>  
           </div>
<?
    /*        echo DatePicker::widget([
    'name' => 'dp_3',
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'value' => '23-Feb-1982',
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'dd-M-yyyy'
    ]
]);*/
?>
        </div>

    <? $scrollbox_template = "{label}\n<div class=\"scrollbox\">{input}</div>" ?>

       <div class="col-xs-6 col-sm-2 col-md-2">
    <?
        echo $form->field($model['TypeObject'], 'type_object_id',[
            'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
        TypeObject::find()->select(['name', 'type_object_id'])->where(['type_realty_id'=>'2'])->indexBy('type_object_id')->column(),
        ['prompt'=>'Select type'])->label('Тип объекта');
    ?>
        </div>
        <div class="col-xs-6 col-sm-2 col-md-2">
    <?
        echo $form->field($model['RegionKharkivAdmin'], 'region_kharkiv_admin_id',[
            'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
        RegionKharkivAdmin::find()->select(['name', 'region_kharkiv_admin_id'])->orderby('name')->indexBy('region_kharkiv_admin_id')->column(),
        ['prompt'=>'Select region'])->label('РайонАдмин/Харьков');
    ?>
        </div>

        <div class="col-xs-6 col-sm-2 col-md-2">
    <?
        echo $form->field($model['RegionKharkiv'], 'region_kharkiv_id',[
            'template' => "{label}\n <input id=\"region_kharkiv_search\" class=\"fast-search-input\"><div class=\"scrollbox\" style=\"height:174px;\">{input}</div>", 'labelOptions' => ['class' => '']])->checkboxList(
        RegionKharkiv::find()->select(['name', 'region_kharkiv_id'])->orderby('name')->indexBy('region_kharkiv_id')->column(),
        ['prompt'=>'Select region'])->label('Район/Харьков');
    ?>
        </div>
        <div class="col-xs-6 col-sm-2 col-md-2" style="height: 200px;">
    <?
        echo $form->field($model['Region'], 'region_id',[
            'template' => "{label}\n <input id=\"region_search\" class=\"fast-search-input\"><div class=\"scrollbox\" style=\"height:174px;\">{input}</div>", 'labelOptions' => ['class' => '']])->checkboxList(
        Region::find()->select(['name', 'region_id'])->orderby('name')->indexBy('region_id')->column(),
        ['prompt'=>'Select region','unselect' => null, ])->label('Район/Область');
    ?>
        </div>
        <div class="col-xs-6 col-sm-2 col-md-2">
    <?
        echo $form->field($model['Locality'], 'locality_id',[
            'template' => "{label}\n <input id=\"locality_search\" class=\"fast-search-input\"><div class=\"scrollbox\" style=\"height:174px;\">{input}</div>", 'labelOptions' => ['class' => '']])->checkboxList(
        Locality::find()->select(['name', 'locality_id'])->orderby('name')->indexBy('locality_id')->column())->label('Населенный пункт');
    ?>
       </div>
        <div class="col-xs-6 col-sm-2 col-md-2"> 
    <?
        echo $form->field($model['Course'], 'course_id',[
            'template' => "{label}\n <input id=\"course_search\" class=\"fast-search-input\"><div class=\"scrollbox\" style=\"height:174px;\">{input}</div>", 'labelOptions' => ['class' => '']])->checkboxList(
        Course::find()->select(['name', 'course_id'])->orderby('name')->indexBy('course_id')->column())->label('Направление');
    ?>
        </div>
        <div class="col-xs-6 col-sm-2 col-md-2">
    <?
        echo $form->field($model['Street'], 'street_id',[
            'template' => "{label} <br> <input id=\"street_search\" class=\"fast-search-input\"><div class=\"scrollbox\" style=\"height:174px;\">{input}</div>", 'labelOptions' => ['class' => '']])->checkboxList(
        Street::find()->select(['name', 'street_id'])->orderby('name')->indexBy('street_id')->column())->label('Улица');
    ?>
        </div>
        <div class="col-xs-6 col-sm-2 col-md-2">
    <?
        echo $form->field($model['WallMaterial'], 'wall_material_id',[
            'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
        WallMaterial::find()->select(['name', 'wall_material_id'])->orderby('name')->indexBy('wall_material_id')->column())->label('Стены');
    ?>
        </div>
        <div class="col-xs-6 col-sm-2 col-md-2">
    <?
        echo $form->field($model['Condit'], 'condit_id',[
            'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
        Condit::find()->select(['name', 'condit_id'])->orderby('name')->indexBy('condit_id')->column())->label('Состояние');
    ?>
        </div>
        <div class="col-xs-6 col-sm-2 col-md-2">
    <?
        echo $form->field($model['Wc'], 'wc_id',[
            'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
        Wc::find()->select(['name', 'wc_id'])->orderby('name')->indexBy('wc_id')->column())->label('Сан. узел');
    ?>
        </div>
        <div class="col-xs-6 col-sm-2 col-md-2">
    <?
        echo $form->field($model['UserType'], 'author_id',[
            'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
        Users::find()->select(['name', 'id'])->orderby('name')->indexBy('id')->column())->label('Автор');
    ?>
        </div>
        <div class="col-xs-6 col-sm-2 col-md-2">
    <?
        echo $form->field($model['UserType'], 'update_author_id',[
            'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
        Users::find()->select(['name', 'id'])->orderby('name')->indexBy('id')->column())->label('Изменил дпи');
    ?>
        </div>
        <div class="col-xs-6 col-sm-2 col-md-2">
    <?
        echo $form->field($model['UserType'], 'update_photo_user_id',[
            'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
        Users::find()->select(['name', 'id'])->orderby('name')->indexBy('id')->column())->label(\Yii::t('yii', '(Кто обновил фото)'));
    ?>
        </div>
        <div class="col-xs-6 col-sm-2 col-md-2">    
    <?
        echo $form->field($model['UserType'], 'exclusive_user_id',[
            'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
        Users::find()->select(['name', 'id'])->orderby('name')->indexBy('id')->column())->label('Экслюзив');
    ?>
        </div>
    

    <div class="col-xs-1 col-sm-1 col-md-1">
    <?
        echo $form->field($model['ApartmentFind'], 'middle_floor', ['template' => "{label}<br>{input}", 'labelOptions' => ['class' => 'radio-btn-gp-label']])->radioList(['1' => \Yii::t('yii','Yes'), '0' => \Yii::t('yii','No'), '2' => \Yii::t('yii','All')])->label(\Yii::t('yii','Middle floor'));
    ?>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1">
    <?
        echo $form->field($model['ApartmentFind'], 'no_mediators', ['template' => "{label}<br>{input}", 'labelOptions' => ['class' => 'radio-btn-gp-label']])->radioList(['1' => \Yii::t('yii','Yes'), '0' => \Yii::t('yii','No'), '2' => \Yii::t('yii','All')])->label(\Yii::t('yii','No mediators'));
    ?>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1">
    <?
        echo $form->field($model['ApartmentFind'], 'exchange', ['template' => "{label}<br>{input}", 'labelOptions' => ['class' => 'radio-btn-gp-label']])->radioList(['1' => \Yii::t('yii','Yes'), '0' => \Yii::t('yii','No'), '2' => \Yii::t('yii','All')])->label(\Yii::t('yii','Exchange'));
    ?>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1">
    <?
        echo $form->field($model['ApartmentFind'], 'enabled', ['template' => "{label}<br>{input}", 'labelOptions' => ['class' => 'radio-btn-gp-label']])->radioList(['0' => \Yii::t('yii','Yes'), '1' => \Yii::t('yii','No'), '2' => \Yii::t('yii','All')])->label(\Yii::t('yii','Archive'));
    ?>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1">
    <?
        echo $form->field($model['ApartmentFind'], 'note', ['template' => "{label}<br>{input}", 'labelOptions' => ['class' => 'radio-btn-gp-label']])->radioList(['1' => \Yii::t('yii','Yes'), '0' => \Yii::t('yii','No'), '2' => \Yii::t('yii','All')])->label(\Yii::t('yii','Note'));
    ?>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-2">
    <?= $form->field($model['ApartmentFind'],'phone', ['template' => "{label}<br>{input}", 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','Phone')); ?>
        </div>	
        

    </div>
    </div>
<?php ActiveForm::end(); ?>

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