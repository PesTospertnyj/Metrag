<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
use backend\models\TypeObject;
use backend\models\RegionKharkiv;
use backend\models\Region;
?>
    <div id="wrapper">
        <div class="breadcrumbs">
            <div class="content">

                <p><span><a href="/" title="">Главная</a></span> / <?php echo Yii::t('app', 'Houses');?></p>
            </div>
        </div>
        <div class="filter">
            <div class="content">
                <div class="item-filtr">
                    <?php $form = ActiveForm::begin([
                        'method' => 'get',
                    ]); ?>
                    <?= $form->field($model,'location',['inline' => true, 'template' => '{input}'])->radiolist(
                        ['2' => Yii::t('app', 'All'), '0' => Yii::t('app', 'Kharkiv'), '1' => Yii::t('app', 'Region')])->label(false); ?>
                    <!--Тип квартиры-->
                    <div class="item-filtr-select">
                        <?= $form->field($model, 'type_object_id')->dropdownList(
                            TypeObject::find()->select(['name', 'type_object_id'])->where(['type_realty_id'=>'4'])
                                ->indexBy('type_object_id')->column(), ['prompt'=>'Тип...'])->label('Тип объекта'); ?>
                    </div>
                    <!--Район-->
                    <div class="item-filtr-select" id="region_kharkiv" style='display: none;'>
                        <?= $form->field($model, 'region_kharkiv_id')->dropdownList(
                            RegionKharkiv::find()->select(['name', 'region_kharkiv_id'])->orderby('name')
                                ->indexBy('region_kharkiv_id')->column(),['prompt'=>'Выберите район...'])->label('Район/Харьков'); ?>
                    </div>
                    <div class="item-filtr-select" id="region" style='display: none;'>
                        <?= $form->field($model, 'region_id')->dropdownList(Region::find()->select(['name', 'region_id'])
                            ->orderby('name')->indexBy('region_id')->column(),['prompt'=>'Выберите район...'])->label('Район/Область'); ?>
                    </div>
                    <?php $template = "<tr><td>{label}</td><td>{input}</td></tr>"; ?>
                    <!--Цена-->
                    <div class="item-filtr-select">
                        <table><tbody>
                            <tr>
                                <td colspan="2">Цена</td>
                            </tr>
                            <?= $form->field($model,'priceFrom', [
                                'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
                            <?= $form->field($model,'priceTo', [
                                'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
                            </tbody></table>
                    </div>
                    <!--площадь-->
                    <div class="item-filtr-select">
                        <table><tbody>
                            <tr>
                                <td colspan="2">Площадь общая</td>
                            </tr>
                            <?= $form->field($model,'total_areaFrom', [
                                'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
                            <?= $form->field($model,'total_areaTo', [
                                'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
                            </tbody></table>
                    </div>
                    <!--площадь участка-->
                    <div class="item-filtr-select">
                        <table><tbody>
                            <tr>
                                <td colspan="2">Площадь участка</td>
                            </tr>
                            <?= $form->field($model,'total_area_houseFrom', [
                                'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','from')); ?>
                            <?= $form->field($model,'total_area_houseTo', [
                                'template' => $template, 'labelOptions' => ['class' => '']])->textInput()->label(\Yii::t('yii','to')); ?>
                            </tbody></table>
                    </div>
                    <div class="item-filtr-select">
                        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']);?>
                        <a href="house?view=grid">Сбросить</a>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>

<? $this->registerJs('
    $(document).ready(function () {
        show_region();
        }); 
        function show_region(){
            var selectVal = $("input[name=\'HouseSearch[location]\']:checked").val();
            if (selectVal == \'2\') {
                $("#region_kharkiv").css("display", "none");
                $("#region").css("display", "none");
                }
            if (selectVal == \'1\') { 
                $("#region_kharkiv").css("display", "none");
                $("#region").css("display", "");
                }
            if (selectVal == \'0\') { 
                $("#region_kharkiv").css("display", "");
                $("#region").css("display", "none");
                }
        }

        $(\'#housesearch-location\').change(show_region);
        ');

?>