<?php
use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
//use yii\jui\DatePicker;
use kartik\date\DatePicker;

use backend\models\RegionKharkivAdmin;
use backend\models\TypeObject;
use backend\models\Locality;
use backend\models\RegionKharkiv;
use backend\models\Region;
use backend\models\Street;
use backend\models\Course;
use backend\models\WallMaterial;
use backend\models\Condit;
use backend\models\Wc;
use backend\models\User;
use backend\models\Partsite;
use backend\models\Parthouse;
use backend\models\Water;
use backend\models\Sewage;
use backend\models\Gas;
?>
<?php \yii\helpers\Url::remember(); ?>
<?
$this->title = Yii::t('app', 'House Search');
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="main-content">

        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'action' => ['house/searchresult'],
            'layout' => 'horizontal'
        ]); ?>

        <div class="main-content-header">
            <div class="pull-left">
                <?= Yii::t('app', 'Houses') ?>
            </div>
            <div class="pull-right">
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
                <?//= Html::resetButton('Сбросить', ['class' => 'btn btn-default']) ?>
                <a href="<?= Url::base(true);?>/house/search" class="btn btn-default">Сбросить</a>
            </div>
            <div class="pull-right">
                <?= $form->field($model,'phone', [ 'labelOptions' => ['class' => 'header-search']])->textInput()->label(\Yii::t('yii','Phone')); ?>
            </div>
            <div class="pull-right">
                <?= $form->field($model, 'id', [ 'labelOptions' => ['class' => 'header-search']])->textInput()->label('ID'); ?>
            </div>


        </div>

        <div class="container-fluid">
            <?$template = "<div class=\"wrap-find\"><div class=\"col-lg-2 padding-null\">{label}</div>\n<div class=\"col-lg-10 find-input\">{input}</div>\n</div>" ?>

            <div class="col-xs-12 col-sm-12 col-md-12 ">
                <div class="col-xs-6 col-sm-2 col-md-1">
                    <label for="" class="from-to-label">ID</label>
                    <?= $form->field($model,'idFrom', [
                        'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
                    <?= $form->field($model,'idTo', [
                        'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
                </div>
                <div class="col-xs-6 col-sm-2 col-md-1 ">
                    <label for="" class="from-to-label">Комнат</label>
                    <?= $form->field($model,'count_roomFrom', [
                        'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
                    <?= $form->field($model,'count_roomTo', [
                        'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
                </div>
                <div class="col-xs-6 col-sm-2 col-md-1 ">
                    <label for="" class="from-to-label">Цена</label>
                    <?= $form->field($model,'priceFrom', [
                        'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
                    <?= $form->field($model,'priceTo', [
                        'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
                </div>
                <div class="col-xs-6 col-sm-2 col-md-1 ">
                    <label for="" class="from-to-label">Этажность</label>
                    <?= $form->field($model,'floor_allFrom', [
                        'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
                    <?= $form->field($model,'floor_allTo', [
                        'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
                </div>
                <div class="col-xs-6 col-sm-2 col-md-1 ">
                    <label for="" class="from-to-label">Пл общ</label>
                    <?= $form->field($model,'total_areaFrom', [
                        'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
                    <?= $form->field($model,'total_areaTo', [
                        'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
                </div>
                <div class="col-xs-6 col-sm-2 col-md-1 ">
                    <label for="" class="from-to-label">Пл уч</label>
                    <?= $form->field($model,'total_area_houseFrom', [
                        'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
                    <?= $form->field($model,'total_area_houseTo', [
                        'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
                </div>

                <? $template_date = "<div class=\"wrap-find\"><div class=\"col-lg-1 padding-null\">{label}</div>\n<div class=\"col-lg-11 find-input\">{input}</div>\n</div>"?>

                <div class="col-xs-6 col-sm-3 col-md-2 ">
                    <label for="" class="from-to-label">Дата доб</label>
                    <?= $form->field($model, 'date_addedFrom', [
                        'template' => $template_date, 'labelOptions' => ['class' => '']])->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => \Yii::t('yii','Enter date ...')],
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'pickerButton' => false,
                        'pluginOptions' => [
                            'autoclose'=>true,
                            //'format' => 'yyyy-mm-dd',
                            'format' => 'dd.mm.yyyy',
                            'todayHighlight' => true,
                        ]
                    ])->label(\Yii::t('yii','from')); ?>
                    <?= $form->field($model, 'date_addedTo', [
                        'template' => $template_date, 'labelOptions' => ['class' => '']])->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => \Yii::t('yii','Enter date ...')],
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'pickerButton' => false,
                        'pluginOptions' => [
                            'autoclose'=>true,
                            //'format' => 'yyyy-mm-dd',
                            'format' => 'dd.mm.yyyy',
                            'todayHighlight' => true,
                        ]
                    ])->label(\Yii::t('yii','to')); ?>
                </div>

                <div class="col-xs-6 col-sm-3 col-md-2 ">
                    <label for="" class="from-to-label">Дата ДПИ</label>
                    <?= $form->field($model, 'date_modifiedFrom', [
                        'template' => $template_date, 'labelOptions' => ['class' => '']])->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => \Yii::t('yii','Enter date ...')],
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'pickerButton' => false,
                        'pluginOptions' => [
                            'autoclose'=>true,
                            //'format' => 'yyyy-mm-dd',
                            'format' => 'dd.mm.yyyy',
                            'todayHighlight' => true,
                        ]
                    ])->label(\Yii::t('yii','from')); ?>
                    <?= $form->field($model, 'date_modifiedTo', [
                        'template' => $template_date, 'labelOptions' => ['class' => '']])->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => \Yii::t('yii','Enter date ...')],
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'pickerButton' => false,
                        'pluginOptions' => [
                            'autoclose'=>true,
                            //'format' => 'yyyy-mm-dd',
                            'format' => 'dd.mm.yyyy',
                            'todayHighlight' => true,
                        ]
                    ])->label(\Yii::t('yii','to')); ?>
                </div>

            </div>

            <? $scrollbox_template = "{label}\n<div class=\"scrollbox\">{input}</div>" ?>

            <div class="col-xs-6 col-sm-2 col-md-2">
                <?
                echo $form->field($model, 'type_object_id',[
                    'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
                    TypeObject::find()->select(['name', 'type_object_id'])->where(['type_realty_id'=>'2'])->indexBy('type_object_id')->column(),
                    ['prompt'=>'Select type'])->label('Тип объекта');
                ?>

            </div>
            <div class="col-xs-6 col-sm-2 col-md-2">
                <?
                echo $form->field($model, 'region_kharkiv_admin_id',[
                    'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
                    RegionKharkivAdmin::find()->select(['name', 'region_kharkiv_admin_id'])->orderby('name')->indexBy('region_kharkiv_admin_id')->column(),
                    ['prompt'=>'Select region'])->label('РайонАдмин/Харьков');
                ?>
            </div>

            <div class="col-xs-6 col-sm-2 col-md-2">
                <?
                echo $form->field($model, 'region_kharkiv_id',[
                    'template' => "{label}\n <input id=\"region_kharkiv_search\" class=\"fast-search-input\"><div class=\"scrollbox\" style=\"height:174px;\">{input}</div>", 'labelOptions' => ['class' => '']])->checkboxList(
                    RegionKharkiv::find()->select(['name', 'region_kharkiv_id'])->orderby('name')->indexBy('region_kharkiv_id')->column(),
                    ['prompt'=>'Select region'])->label('Район/Харьков');
                ?>
            </div>
            <div class="col-xs-6 col-sm-2 col-md-2" style="height: 200px;">
                <?
                echo $form->field($model, 'region_id',[
                    'template' => "{label}\n <input id=\"region_search\" class=\"fast-search-input\"><div class=\"scrollbox\" style=\"height:174px;\">{input}</div>", 'labelOptions' => ['class' => '']])->checkboxList(
                    Region::find()->select(['name', 'region_id'])->orderby('name')->indexBy('region_id')->column(),
                    ['prompt'=>'Select region','unselect' => null, ])->label('Район/Область');
                ?>
            </div>
            <div class="col-xs-6 col-sm-2 col-md-2">
                <?
                echo $form->field($model, 'locality_id',[
                    'template' => "{label}\n <input id=\"locality_search\" class=\"fast-search-input\"><div class=\"scrollbox\" style=\"height:174px;\">{input}</div>", 'labelOptions' => ['class' => '']])->checkboxList(
                    Locality::find()->select(['name', 'locality_id'])->orderby('name')->indexBy('locality_id')->column())->label('Населенный пункт');
                ?>
            </div>
            <div class="col-xs-6 col-sm-2 col-md-2">
                <?
                echo $form->field($model, 'course_id',[
                    'template' => "{label}\n <input id=\"course_search\" class=\"fast-search-input\"><div class=\"scrollbox\" style=\"height:174px;\">{input}</div>", 'labelOptions' => ['class' => '']])->checkboxList(
                    Course::find()->select(['name', 'course_id'])->orderby('name')->indexBy('course_id')->column())->label('Направление');
                ?>
            </div>
            <div class="col-xs-6 col-sm-2 col-md-2">
                <?
                echo $form->field($model, 'street_id',[
                    'template' => "{label} <br> <input id=\"street_search\" class=\"fast-search-input\"><div class=\"scrollbox\" style=\"height:174px;\">{input}</div>", 'labelOptions' => ['class' => '']])->checkboxList(
                    Street::find()->select(['name', 'street_id'])->orderby('name')->indexBy('street_id')->column())->label('Улица');
                ?>
            </div>
            <div class="col-xs-6 col-sm-2 col-md-2">
                <?
                echo $form->field($model, 'wall_material_id',[
                    'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
                    WallMaterial::find()->select(['name', 'wall_material_id'])->orderby('name')->indexBy('wall_material_id')->column())->label('Стены');
                ?>
            </div>
            <div class="col-xs-6 col-sm-2 col-md-2">
                <?
                echo $form->field($model, 'condit_id',[
                    'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
                    Condit::find()->select(['name', 'condit_id'])->orderby('name')->indexBy('condit_id')->column())->label('Состояние');
                ?>
            </div>
            <div class="col-xs-6 col-sm-2 col-md-2">
                <?
                echo $form->field($model, 'author_id',[
                    'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
                    User::find()->select(['username', 'id'])->orderby('username')->indexBy('id')->column())->label('Автор');
                ?>
            </div>
            <div class="col-xs-6 col-sm-2 col-md-2">
                <?
                echo $form->field($model, 'update_author_id',[
                    'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
                    User::find()->select(['username', 'id'])->orderby('username')->indexBy('id')->column())->label('Изменил дпи');
                ?>
            </div>
            <div class="col-xs-6 col-sm-2 col-md-2">
                <?
                echo $form->field($model, 'update_photo_user_id',[
                    'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
                    User::find()->select(['username', 'id'])->orderby('username')->indexBy('id')->column())->label(\Yii::t('yii', '(Кто обновил фото)'));
                ?>
            </div>
            <div class="col-xs-6 col-sm-2 col-md-2">
                <?
                echo $form->field($model, 'exclusive_user_id',[
                    'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
                    User::find()->select(['username', 'id'])->orderby('username')->indexBy('id')->column())->label('Экслюзив');
                ?>
            </div>
            <div class="col-xs-3 col-sm-1 col-md-1">
                <?
                echo $form->field($model, 'partsite_id',[
                    'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
                    Partsite::find()->select(['name', 'partsite_id'])->orderby('name')->indexBy('partsite_id')->column())->label('Ч/участка');
                ?>
            </div>
            <div class="col-xs-3 col-sm-1 col-md-1">
                <?
                echo $form->field($model, 'parthouse_id',[
                    'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
                    Parthouse::find()->select(['name', 'parthouse_id'])->orderby('name')->indexBy('parthouse_id')->column())->label('Ч/дома');
                ?>
            </div>
            <div class="col-xs-3 col-sm-1 col-md-1">
                <?
                echo $form->field($model, 'water_id',[
                    'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
                    Water::find()->select(['name', 'water_id'])->orderby('name')->indexBy('water_id')->column())->label('Вода');
                ?>
            </div>
            <div class="col-xs-3 col-sm-1 col-md-1">
                <?
                echo $form->field($model, 'sewage_id',[
                    'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
                    Sewage::find()->select(['name', 'sewage_id'])->orderby('name')->indexBy('sewage_id')->column())->label('Канализация');
                ?>
            </div>
            <div class="col-xs-3 col-sm-1 col-md-1">
                <?
                echo $form->field($model, 'gas_id',[
                    'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])->checkboxList(
                    Gas::find()->select(['name', 'gas_id'])->orderby('name')->indexBy('gas_id')->column())->label('Газ');
                ?>
            </div>


            <div class="col-xs-1 col-sm-1 col-md-1">
                <?
                echo $form->field($model, 'state_act', ['template' => "{label}<br>{input}", 'labelOptions' => ['class' => 'radio-btn-gp-label']])->radioList(['1' => \Yii::t('yii','Yes'), '2' => \Yii::t('yii','No'), '0' => \Yii::t('yii','All')])->label(\Yii::t('yii','State Act'));
                ?>
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1">
                <?
                echo $form->field($model, 'photo_exist', ['template' => "{label}<br>{input}", 'labelOptions' => ['class' => 'radio-btn-gp-label']])->radioList(['1' => \Yii::t('yii','Yes'), '2' => \Yii::t('yii','No'), '0' => \Yii::t('yii','All')])->label(\Yii::t('yii','Photo exists'));
                ?>
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1">
                <?
                echo $form->field($model, 'no_mediators', ['template' => "{label}<br>{input}", 'labelOptions' => ['class' => 'radio-btn-gp-label']])->radioList(['1' => \Yii::t('yii','Yes'), '2' => \Yii::t('yii','No'), '0' => \Yii::t('yii','All')])->label(\Yii::t('yii','No mediators'));
                ?>
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1">
                <?
                echo $form->field($model, 'exchange', ['template' => "{label}<br>{input}", 'labelOptions' => ['class' => 'radio-btn-gp-label']])->radioList(['1' => \Yii::t('yii','Yes'), '2' => \Yii::t('yii','No'), '0' => \Yii::t('yii','All')])->label(\Yii::t('yii','Exchange'));
                ?>
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1">
                <?
                echo $form->field($model, 'enabled', ['template' => "{label}<br>{input}", 'labelOptions' => ['class' => 'radio-btn-gp-label']])->radioList(['1' => \Yii::t('yii','Yes'), '2' => \Yii::t('yii','No'), '0' => \Yii::t('yii','All')])->label(\Yii::t('yii','Archive'));
                ?>
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1">
                <?
                echo $form->field($model, 'note', ['template' => "{label}<br>{input}", 'labelOptions' => ['class' => 'radio-btn-gp-label']])->radioList(['1' => \Yii::t('yii','Yes'), '2' => \Yii::t('yii','No'), '0' => \Yii::t('yii','All')])->label(\Yii::t('yii','Note'));
                ?>
            </div>


        </div>
    </div>
<?php ActiveForm::end(); ?>

<?
$this->registerJs('
	$("#street_search, #region_search, #region_kharkiv_search, #locality_search, #course_search").keyup(function(){
        var search_string = $(this).val().toLowerCase();
        var arr = $(this).parent().find("div.scrollbox > div > div");
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