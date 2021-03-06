<?php
//use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

use backend\models\Apartment;
use backend\models\RegionKharkivAdmin;
use backend\models\TypeObject;
use backend\models\Locality;
use backend\models\Layout;
use backend\models\RegionKharkiv;
use backend\models\Region;
use backend\models\Street;
use backend\models\Course;
use backend\models\WallMaterial;
use backend\models\Condit;
use backend\models\User;
use backend\models\Mediator;
use backend\models\Metro;
use backend\models\SourceInfo;
use backend\models\Addsite;
use backend\models\Partsite;
use backend\models\Parthouse;
use backend\models\Sewage;
use backend\models\Gas;
use backend\models\Water;
use backend\models\Comfort;


use kartik\file\FileInput;
use yii\helpers\Url;
?>

<?php $form = ActiveForm::begin([
          'method' => 'post',
          'action' => ['house/add'],
          //'options' => ['class' => 'form-inline'],
          'options' => ['enctype' => 'multipart/form-data'],
      ]); ?>


    <div class="col-xs-12 col-sm-3 col-md-3 ">

        <?= $form->field($model,'id')->textInput(['readonly' => 'true'])->label('ID'); ?>
        <?= $form->field($model, 'type_object_id')->dropdownList(
            TypeObject::find()->select(['name', 'type_object_id'])->where(['type_realty_id'=>'4'])->indexBy('type_object_id')->column())->label('Тип объекта'); ?>
        <?= $form->field($model,'count_room')->textInput()->label('Кол. комнат'); ?>
        <?= $form->field($model, 'partsite_id')->dropdownList(
            Partsite::find()->select(['name', 'partsite_id'])->orderby('name')->indexBy('partsite_id')->column(),['prompt'=>'Выберите часть...'])->label('Часть участка'); ?>
        <?= $form->field($model, 'parthouse_id')->dropdownList(
            Parthouse::find()->select(['name', 'parthouse_id'])->orderby('name')->indexBy('parthouse_id')->column(),['prompt'=>'Выберите часть...'])->label('Часть дома'); ?>
        <?= $form->field($model,'floor_all')->textInput()->label('Этажность'); ?>

        <? if($model->id == null) $model->city_or_region = 0; ?>
        <?= $form->field($model,'city_or_region',['inline' => true, 'template' => '{input}'])->radiolist(['0' => Yii::t('app', 'Kharkiv'), '1' => Yii::t('app', 'Region')])->label(false); ?>

        <?= $form->field($model, 'region_kharkiv_admin_id')->dropdownList(RegionKharkivAdmin::find()->select(['name', 'region_kharkiv_admin_id'])->orderby('name')->indexBy('region_kharkiv_admin_id')->column(),['prompt'=>'Выберите район...'])->label('РайонАдмин/Харьков', ['class' => 'required']); ?>
        <?= $form->field($model, 'region_kharkiv_id')->dropdownList(
            RegionKharkiv::find()->select(['name', 'region_kharkiv_id'])->orderby('name')->indexBy('region_kharkiv_id')->column(),['prompt'=>'Выберите район...'])->label('Район/Харьков', ['class' => 'required']); ?>
        <?= $form->field($model, 'metro_id')->dropdownList(
            Metro::find()->select(['name', 'metro_id'])->orderby('name')->indexBy('metro_id')->column(),['prompt'=>'Выберите станцию метро...'])->label('Метро'); ?>

        <?= $form->field($model, 'locality_id')->dropdownList(
            Locality::find()->select(['name', 'locality_id'])->orderby('name')->indexBy('locality_id')->column(),['prompt'=>'Выберите населенный пункт...'])->label('Населенный пункт', ['class' => 'required']); ?>
        <?= $form->field($model, 'course_id')->dropdownList(
            Course::find()->select(['name', 'course_id'])->orderby('name')->indexBy('course_id')->column(),['prompt'=>'Выберите направление...'])->label('Направление', ['class' => 'required']); ?>
        <?= $form->field($model, 'region_id')->dropdownList(Region::find()->select(['name', 'region_id'])->orderby('name')->indexBy('region_id')->column(),['prompt'=>'Выберите район...'])->label('Район/Область', ['class' => 'required']); ?>

        <label>Улица</label>
        <?= $form->field($model,'street')->textInput(['id' => 'autocomplete'])->label(''); ?>

        <?php /* echo $form->field($model, 'street_id')->dropdownList(
            Street::find()->select(['name', 'street_id'])->orderby('name')->indexBy('street_id')->column(),['prompt'=>'Выберите улицу...'])->label('Улица');  */ ?>
        <?= $form->field($model,'number_building')->textInput()->label('Номер дома'); ?>

    </div>
    <div class="col-xs-12 col-sm-3 col-md-3 ">
        <?= $form->field($model,'price')->textInput()->label('Цена'); ?>
        <?= $form->field($model, 'exclusive_user_id')->dropdownList(
            User::find()->select(['username', 'id'])->orderby('username')->indexBy('id')->column(),['prompt'=>'Выберите пользователя...'])->label('Экслюзив'); ?>
        <?= $form->field($model, 'mediator_id')->dropdownList(
            Mediator::find()->select(['name', 'mediator_id'])->orderby('name')->indexBy('mediator_id')->column(),['prompt'=>'Выберите посредника...'])->label('Посредник'); ?>
        <?= $form->field($model,'landmark')->textInput()->label('Ориентир'); ?>
        <?= $form->field($model,'comment')->textInput()->label('Причина удаления/восстановления'); ?>
        <?= $form->field($model,'exchange')->checkbox()->label('Обмен'); ?>
        <?= $form->field($model,'exchange_formula')->textInput()->label('Формула обмена'); ?>
        <?= $form->field($model, 'condit_id')->dropdownList(
            Condit::find()->select(['name', 'condit_id'])->orderby('name')->indexBy('condit_id')->column(),['prompt'=>'Выберите состояние...'])->label('Состояние'); ?>
        <?= $form->field($model, 'source_info_id')->dropdownList(
            SourceInfo::find()->select(['name', 'source_info_id'])->orderby('name')->indexBy('source_info_id')->column(),['prompt'=>'Выберите источник...'])->label('Источник информации'); ?>
        <?= $form->field($model, 'sewage_id')->dropdownList(
            Sewage::find()->select(['name', 'sewage_id'])->orderby('name')->indexBy('sewage_id')->column(),['prompt'=>'Выберите тип канализации...'])->label('Канализация'); ?>
        <?= $form->field($model, 'wall_material_id')->dropdownList(
            WallMaterial::find()->select(['name', 'wall_material_id'])->orderby('name')->indexBy('wall_material_id')->column(),['prompt'=>'Выберите материал стен...'])->label('Стены'); ?>
        <?= $form->field($model,'date_added')->textInput(['readonly' => 'true'])->label('Дата добавления'); ?>
        <?= $form->field($model,'date_modified')->textInput(['readonly' => 'true'])->label('Дата изменения'); ?>
    </div>
    <div class="col-xs-12 col-sm-3 col-md-3 ">
        <?= $form->field($model, 'water_id')->dropdownList(
            Water::find()->select(['name', 'water_id'])->orderby('name')->indexBy('water_id')->column(),['prompt'=>'Выберите...'])->label('Вода'); ?>
        <?= $form->field($model,'total_area_house')->textInput()->label('Площадь дома'); ?>
        <?= $form->field($model,'total_area')->textInput()->label('Площадь участка'); ?>
        <?= $form->field($model,'building_year')->textInput()->label('Год постройки'); ?>
        <?= $form->field($model,'phone_line')->checkbox()->label('Телефонная линия'); ?>
        <?= $form->field($model,'state_act')->checkbox()->label('Гос. акт на участок'); ?>
        <?= $form->field($model, 'gas_id')->dropdownList(
            Gas::find()->select(['name', 'gas_id'])->orderby('name')->indexBy('gas_id')->column(),['prompt'=>'Выберите...'])->label('Газ'); ?>
        <?= $form->field($model, 'comfort_id')->dropdownList(
            Comfort::find()->select(['name', 'comfort_id'])->orderby('name')->indexBy('comfort_id')->column(),['prompt'=>'Выберите...'])->label('Удобства'); ?>

        <?= $form->field($model, 'author_id')->dropdownList(
            User::find()->select(['username', 'id'])->where(['id'=> $model->author_id])->column(),['disabled' => 'true'])->label('Автор'); ?>
        <?= $form->field($model, 'update_author_id')->dropdownList(
            User::find()->select(['username', 'id'])->where(['id'=> $model->update_author_id])->column(),['disabled' => 'true'])->label('Изменил дпи'); ?>
        <?= $form->field($model, 'update_photo_user_id')->dropdownList(
            User::find()->select(['username', 'id'])->where(['id'=> $model->update_photo_user_id])->column(),['disabled' => 'true'])->label('Кто обновил фото'); ?>
        <?= Html::label("Доски объявлений") ?>
        <?= $form->field($model,'besplatka')->checkbox()->label('Бесплатка') ?>
        <?= $form->field($model,'est')->checkbox()->label('EST') ?>
        <?= $form->field($model,'mesto')->checkbox()->label('Mesto.ua') ?>
    </div>
    <div class="col-xs-12 col-sm-3 col-md-3 ">
        <?= $form->field($model, 'note')->textarea(['rows'=>6])->label('Заметки'); ?>
        <?= $form->field($model, 'notesite')->textarea(['rows'=>6])->label('Информация для показа на сайте'); ?>
        <?= Html::button(Yii::t('app', 'Add'), ['id' => 'add_phone']) ?>
        <?= Html::button(Yii::t('app', 'Edit'), ['id' => 'edit_phone']) ?>
        <?= Html::button(Yii::t('app', 'Delete'), ['id' => 'delete_phone']) ?>

        <div id="div_phone" style="display: none;">
        <input type="text" id="input_phone" class="span12" />

        <?= Html::button(Yii::t('app', 'OK'), ['id' => 'ok_phone']) ?>
        <?= Html::button(Yii::t('app', 'Cancel'), ['id' => 'cancel_phone']) ?>

        </div>
        <?php
        $phones = explode(",", $model['phone']);
        ?>
        <ul id="select_phone" data-target="House" style="width: 100%;height: 200px;background: #fff;list-style: none;">
            <?php foreach ($phones as $phone) { ?>
                <?php if ($phone) { ?>
                    <li><input type="checkbox" name="selected_phones[]"> <?php echo $phone; ?></li>
                <?php } ?>
            <?php } ?>
        </ul>
        <?= $form->field($model,'phone')->hiddenInput(); ?>
        <? if($model->id == null) $model->enabled = 1; ?>
        <?= $form->field($model,'enabled')->checkbox()->label('Активное') ?>

        <div class="new_site_form">
            <?= $form->field($model,'is_publish')->checkbox()->label('Опубликовать на новом сайте') ?>
            <?= $this->render('/new_site/_agents.php', ['form' => $form, 'data' => $data, 'model' => $model, 'hasMaxAgents' => $hasMaxAgents]); ?>
<!--            --><?//= $form->field($model,'realty_state_id')->dropDownList($data['states'])->label('Состояние недвижимости'); ?>
            <?= $form->field($model,'year_built')->textInput(['value' => ''])->label('Год постройки'); ?>
            <?php /* $form->field($model,'bathroom_type')->dropDownList($data['bathroom_types'])->label('Тип санузала');*/ ?>
            <?= $form->field($model,'status_publication')->dropDownList($data['statuses'])->label('Статус на сайте'); ?>
            <?= $form->field($model,'sub_type_id')->dropDownList($data['sub_types'])->label('Подтип'); ?>
            <?= $form->field($model,'deal_type_id')->hiddenInput(['deal_type'])->label(''); ?>

        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">

    <? $images = $model->getImages();
                $img = [];
                $keys = [];

                    foreach ($images as $image){
                        if($image){
                            $img[] = Url::base(true).'/'.$image->getPathToOrigin();
                            $keys[] = ['key' => $image->id];
                         }
                    }
    ?>

    <?= $form->field($model, 'imageFiles[]')->widget(FileInput::classname(), [
        'options' => ['multiple' => true, 'accept' => 'image/*'],
        'pluginOptions' => [

            'initialPreview' => $img,
            'initialPreviewAsData'=>true,
            'initialPreviewConfig'=> $keys,
            'deleteUrl' => "file-delete",
            'overwriteInitial' => false,
            'browseOnZoneClick' => true,
            'initialPreviewShowDelete' => true,
            'initialPreviewShowUpload' => false,
            'showRemove' => false,
            'showUpload' => false,
            'uploadUrl' => 'app',

            //'maxFileCount' => 10,
    ]
        ]); ?>

    </div>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']);?>
    <?= Html::resetButton('Сбросить', ['class' => 'btn btn-default']) ?>
    <a href="<?php echo \yii\helpers\Url::previous(); ?>" class="btn btn-default">Отменить</a>
    <?
        if($model->id != '')
        {
            if(Addsite::findOne(['idbase' => $model->id]))
            {
                echo Html::button(Yii::t('app', 'Delete from site'), ['id' => 'del_from_site','class' => 'btn btn-danger']);
                echo Html::button(Yii::t('app', 'Add site'), ['id' => 'add_site','class' => 'btn btn-primary','style' => 'display: none;']);
            }
            else
            {
                echo Html::button(Yii::t('app', 'Delete from site'), ['id' => 'del_from_site','class' => 'btn btn-danger','style' => 'display: none;']);
                echo Html::button(Yii::t('app', 'Add site'), ['id' => 'add_site','class' => 'btn btn-primary']);
            }
        }
    ?>

<?php ActiveForm::end(); ?>


<? $this->registerJs('
    $(document).ready(function () {
        change_location();
        }); 
        function change_location(){
            var selectVal = $("input[name=\'House[city_or_region]\']:checked").val();
            if (selectVal == \'1\') { 
                $("select[name=\'House[locality_id]\']").removeAttr("disabled");
                $("select[name=\'House[course_id]\']").removeAttr("disabled");
                $("select[name=\'House[region_id]\']").removeAttr("disabled");
                $("select[name=\'House[region_kharkiv_admin_id]\']").attr("disabled", true).find("[value=\'0\']").attr("selected", "selected");
                $("select[name=\'House[region_kharkiv_id]\']").attr("disabled", true).find("[value=\'0\']").attr("selected", "selected");
                $("select[name=\'House[metro_id]\']").attr("disabled", true).find("[value=\'0\']").attr("selected", "selected");
            } else {
                $("select[name=\'House[region_kharkiv_admin_id]\']").removeAttr("disabled");
                $("select[name=\'House[region_kharkiv_id]\']").removeAttr("disabled");
                $("select[name=\'House[metro_id]\']").removeAttr("disabled");
                $("select[name=\'House[locality_id]\']").attr("disabled", true).find("[value=\'0\']").attr("selected", "selected");
                $("select[name=\'House[course_id]\']").attr("disabled", true).find("[value=\'0\']").attr("selected", "selected");
                $("select[name=\'House[region_id]\']").attr("disabled", true).find("[value=\'0\']").attr("selected", "selected");
            }
        }

        $(\'#house-city_or_region\').change(change_location);
        ');

?>


<?= $this->render('/new_site/_js.php', ['agent' => $agent]); ?>
    <script src="/admin/js/site_index.js"></script>
    <script src="/admin/js/phone_field.js"></script>
<script>
        window.onload = function () {
                var add = document.getElementById("add_site");
                if(add)
                {
                    add.onclick = addSite;
                }
                var del = document.getElementById("del_from_site");
                if(del)
                {
                    del.onclick = delSite;
                }
            };

            function addSite(){
                if(confirm("<?php echo Yii::t('app', 'Add site?'); ?>"))
                {
                    var id = document.getElementById("house-id");
                    var xrequest = new XMLHttpRequest();
              xrequest.open("GET", "/admin/addsite/add?id="+id.value+"&base=house", true);
              xrequest.send();

                    xrequest.onload = function() {
                    alert(this.responseText);
                    var add = document.getElementById("add_site");
                    add.style.display = "none";
                    var del = document.getElementById("del_from_site");
                    del.style.display = "";
                };
                }

            };

            function delSite(){
                if(confirm("<?php echo Yii::t('app', 'Delete from site?'); ?>"))
                {
                    var id = document.getElementById("house-id");
                    var xrequest = new XMLHttpRequest();
              xrequest.open("GET", "/admin/addsite/del?id="+id.value, true);
              xrequest.send();

                    xrequest.onload = function() {
                    alert(this.responseText);
                    var add = document.getElementById("add_site");
                    add.style.display = "";
                    var del = document.getElementById("del_from_site");
                    del.style.display = "none";
                };
                }

            };
        $('textarea').keyup(function(event) {
            if (event.keyCode === 13) {
                var content = this.value;
                var caret = getCaret(this);
                this.value = content.substring(0, caret) + "\n" + content.substring(caret, content.length);;
                event.stopPropagation();
                setCaretToPos(event.target,caret + 1);

            }
        });
            $('#house-city_or_region input').change(function(){
                $('#house-region_kharkiv_admin_id').prop('selectedIndex',0)
                $('#house-region_kharkiv_id').prop('selectedIndex',0)
                $('#house-metro_id').prop('selectedIndex',0)
                $('#house-locality_id').prop('selectedIndex',0)
                $('#house-course_id').prop('selectedIndex',0)
                $('#house-region_id').prop('selectedIndex',0)
            })
 </script>

<?php
include Yii::getAlias('@fullRootPath') . '/backend/views/new_site/_google_maps.php';
?>
