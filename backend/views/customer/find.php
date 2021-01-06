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
            <div class="row">
                <?$template = "<div class=\"wrap-find\"><div class=\"col-lg-2 padding-null\">{label}</div>\n<div class=\"col-lg-10 find-input\">{input}</div>\n</div>" ?>

                <div class="col-xs-12 col-sm-12 col-md-6 ">
                    <div class="row">
                        <div class="col-xs-6 col-sm-2 col-md-3">
                            <label for="" class="from-to-label">ID</label>
                            <?= $form->field($model,'id_from', [
                                'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
                            <?= $form->field($model,'id_to', [
                                'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
                        </div>
                        <div class="col-xs-6 col-sm-2 col-md-3 ">
                            <label for="" class="from-to-label">Цена</label>
                            <?= $form->field($model,'price_from', [
                                'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
                            <?= $form->field($model,'price_to', [
                                'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
                        </div>
                        <div class="col-xs-6 col-sm-2 col-md-3 ">
                            <label for="" class="from-to-label">Площадь</label>
                            <?= $form->field($model,'total_area_from', [
                                'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
                            <?= $form->field($model,'total_area_to', [
                                'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
                        </div>
                        <div class="col-xs-1 col-sm-1 col-md-3">
                            <?
                            $model->is_enabled = '2';
                            echo $form->field($model, 'is_enabled', ['template' => "{label}<br>{input}", 'labelOptions' => ['class' => 'radio-btn-gp-label']])->radioList(['1' => \Yii::t('yii', 'Yes'), '2' => \Yii::t('yii', 'No'), '0' => \Yii::t('yii', 'All')])->label(\Yii::t('yii', 'Archive'));
                            ?>
                        </div>
                    </div>
                    <? $template_date = "<div class=\"wrap-find\"><div class=\"col-lg-1 padding-null\">{label}</div>\n<div class=\"col-lg-11 find-input\">{input}</div>\n</div>"?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3">
                    <?= $form->field($model, 'type', [
                        'options' => [
                            'class' => 'required d-flex',
                        ],

                    ])->label('Тип')->widget(\kartik\select2\Select2::className(), [
                        'data' => \backend\models\Customer::AVAILABLE_TYPES_LABELS,
                        'options' => ['placeholder' => 'Выберите тип ...'],
                    ]) ?>

                    <div class="select-for-flats " style="display: none">
                        <?= $form->field($model, 'regionsKharkiv')
                            ->widget(\kartik\select2\Select2::className(), [
                                'data' => RegionKharkiv::prepareForSelect(),
                                'showToggleAll' => false,
                                'options' => ['placeholder' => 'Выберите район...', 'multiple' => true],
                            ])->label('Район/Харьков'); ?>
                    </div>
                    <div class="select-for-houses " style="display: none">
                        <? if ($model->id == null) $model->city_or_region = 0; ?>
                        <?= $form->field($model, 'city_or_region', ['template' => '{input}'])
                            ->radiolist(['0' => Yii::t('app', 'Kharkiv'), '1' => Yii::t('app', 'Region')])
                            ->label(false); ?>

                        <div class="row">
                            <?= $form->field($model, 'regionsKharkivCopy')->widget(
                                \kartik\select2\Select2::className(), [
                                    'data' => RegionKharkiv::prepareForSelect(),
                                    'showToggleAll' => false,
                                    'options' => ['placeholder' => 'Выберите район...', 'multiple' => true,'class' => 'w-100'],
                                ]
                            )->label('Район/Харьков', ['class' => 'required col-md-4']); ?>

                        </div>

                        <div class="row">
                            <?= $form->field($model, 'localities')->widget(
                                \kartik\select2\Select2::className(), [
                                    'data' => Locality::prepareForSelect(),
                                    'showToggleAll' => false,
                                    'options' => ['placeholder' => 'Выберите населенный пункт...', 'multiple' => true]
                                ]
                            )->label('Населенный пункт', ['class' => 'required col-md-4']); ?>
                        </div>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3">
                    <?
                    $model->onlyMyCustomers = '0';
                    echo $form->field($model, 'onlyMyCustomers', ['template' => "{label}<br>{input}", 'labelOptions' => ['class' => 'radio-btn-gp-label']])->radioList(['1' => \Yii::t('yii', 'Только мои'), '0' => \Yii::t('yii', 'Все')])->label(\Yii::t('yii', 'Покупатели'));
                    ?>
                </div>
                <? $scrollbox_template = "{label}\n<div class=\"scrollbox\">{input}</div>" ?>
            </div>
            <div class="row">


            </div>

        </div>


    </div>
<?php ActiveForm::end(); ?>
<style>
    .d-flex{
        display: flex !important;
    }
    .select2-search.select2-search--inline,.select2-search__field{
        width: 100% !important;
    }
</style>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {

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

        $('#customerfind-type').change(function () {
            debugger
            if ($('#customerfind-type option:selected').length > 0) {

                switch ($('#customerfind-type option:selected').val()){
                    case 'flats':
                        $('.select-for-flats').css('display', 'block')
                        $('.select-for-houses').css('display', 'none')
                        break;
                    case 'new_buildings':
                        $('.select-for-flats').css('display', 'block')
                        $('.select-for-houses').css('display', 'none')
                        break;
                    case 'flats-new_buildings':
                        $('.select-for-flats').css('display', 'block')
                        $('.select-for-houses').css('display', 'none')
                        break;
                    case 'houses':
                        $('.select-for-flats').css('display', 'none')
                        $('.select-for-houses').css('display', 'block')
                        $('.field-customerfind-localities').css('display', 'none')
                        break;
                    case 'land_plot':
                        $('.select-for-flats').css('display', 'none')
                        $('.select-for-houses').css('display', 'block')
                        $('.field-customerfind-localities').css('display', 'none')
                        break;
                    case 'rent_house':
                        $('.select-for-flats').css('display', 'none')
                        $('.select-for-houses').css('display', 'block')
                        $('.field-customerfind-localities').css('display', 'none')
                        break;
                    case 'commercial':
                        $('.select-for-flats').css('display', 'block')
                        $('.select-for-houses').css('display', 'none')
                        break;
                    case 'rent_flat':
                        $('.select-for-flats').css('display', 'block')
                        $('.select-for-houses').css('display', 'none')
                        break;
                    case 'rent_commercial':
                        $('.select-for-flats').css('display', 'block')
                        $('.select-for-houses').css('display', 'none')
                        break;
                    default:break;
                }
            }
            else{
                $('.select-for-flats').css('display', 'none')
                $('.select-for-houses').css('display', 'none')
            }
        })

        $('#customerfind-city_or_region input').change(function(){
            if($('#customerfind-city_or_region input:checked').val() == 1){
                $('.field-customerfind-regionskharkivcopy').css('display','none')
                $('.field-customerfind-localities').css('display','block')
            }
            else{
                $('.field-customerfind-localities').css('display','none')
                $('.field-customerfind-regionskharkivcopy').css('display','block')
            }
        })

        $('#w0').submit(function(){
            if ($('#customerfind-type option:selected').val() === 'flats' || $('#customerfind-type option:selected').val() === 'new_buildings') {
                $('.select-for-houses').remove()
            }
            else{
                $('.select-for-flats').remove()
            }
        })
    })
</script>

<?php
include '/' . $_SERVER['DOCUMENT_ROOT']. '/backend/views/new_site/_google_maps.php';
?>
