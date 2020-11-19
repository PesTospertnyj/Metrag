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
$this->title = Yii::t('app', 'Поиск покупателей');
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="main-content">

        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'action' => ['customer/searchresult'],
            'layout' => 'horizontal'
        ]); ?>

        <div class="main-content-header">
            <div class="pull-left">
                <?= Yii::t('app', 'Покупатели') ?>
            </div>
            <div class="pull-right">
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
                <?//= Html::resetButton('Сбросить', ['class' => 'btn btn-default']) ?>
                <a href="<?= Url::base(true);?>/customer/search" class="btn btn-default">Сбросить</a>
            </div>
            <div class="pull-right">
                <?= $form->field($model,'phone', [ 'labelOptions' => ['class' => 'header-search']])->textInput()->label(\Yii::t('yii','Phone')); ?>
            </div>
            <div class="pull-right">
                <?= $form->field($model, 'id', [ 'labelOptions' => ['class' => 'header-search']])->textInput()->label('ID'); ?>
            </div>

            <div class="pull-right">
                <?= $form->field($model, 'full_name', [ 'labelOptions' => ['class' => 'header-search']])->textInput()->label('ФИО'); ?>
            </div>
        </div>

        <div class="container-fluid">
            <?$template = "<div class=\"wrap-find\"><div class=\"col-lg-2 padding-null\">{label}</div>\n<div class=\"col-lg-10 find-input\">{input}</div>\n</div>" ?>

            <div class="col-xs-12 col-sm-12 col-md-12 ">
                <div class="col-xs-6 col-sm-2 col-md-1">
                    <label for="" class="from-to-label">ID</label>
                    <?= $form->field($model,'id_from', [
                        'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
                    <?= $form->field($model,'id_to', [
                        'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
                </div>
                <div class="col-xs-6 col-sm-2 col-md-1 ">
                    <label for="" class="from-to-label">Цена</label>
                    <?= $form->field($model,'price_from', [
                        'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
                    <?= $form->field($model,'price_to', [
                        'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
                </div>
                <div class="col-xs-6 col-sm-2 col-md-1 ">
                    <label for="" class="from-to-label">Площадь</label>
                    <?= $form->field($model,'total_area_from', [
                        'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
                    <?= $form->field($model,'total_area_to', [
                        'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1">
                    <?
                    echo $form->field($model, 'is_enabled', ['template' => "{label}<br>{input}", 'labelOptions' => ['class' => 'radio-btn-gp-label']])->radioList(['1' => \Yii::t('yii', 'Yes'), '2' => \Yii::t('yii', 'No'), '0' => \Yii::t('yii', 'All')])->label(\Yii::t('yii', 'Archive'));
                    ?>
                </div>

                <? $template_date = "<div class=\"wrap-find\"><div class=\"col-lg-1 padding-null\">{label}</div>\n<div class=\"col-lg-11 find-input\">{input}</div>\n</div>"?>
            </div>

            <? $scrollbox_template = "{label}\n<div class=\"scrollbox\">{input}</div>" ?>


            <div class="col-xs-6 col-sm-2 col-md-2">
                <?
                echo $form->field($model, 'types',[
                    'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])
                    ->checkboxList(\backend\models\Customer::AVAILABLE_TYPES_LABELS)->label('Тип недвижимости');
                ?>
            </div>

          <div class="col-xs-6 col-sm-2 col-md-2">
              <?
              echo $form->field($model, 'regions',[
                  'template' => $scrollbox_template, 'labelOptions' => ['class' => '']])
                  ->checkboxList(\backend\models\Region::prepareForSelect())->label('Районы');
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
                if($(this).text().toLowerCase().trim().indexOf(search_string) !== -1) {
                    $(this).css("display", "block");
                }
            });
        }
    });	
');
?>
<?php
include '/' . $_SERVER['DOCUMENT_ROOT']. '/backend/views/new_site/_google_maps.php';
?>
