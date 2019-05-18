<?php
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
use backend\models\Wc;
use backend\models\User;
use backend\models\Mediator;
use backend\models\Metro;
use backend\models\SourceInfo;
use backend\models\Addsite;

use kartik\file\FileInput;
use yii\helpers\Url;
?>

<? $this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Apartments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

<?php $form = ActiveForm::begin([
    'enableAjaxValidation'   => false,
    'enableClientValidation' => false,
]); ?>


<div class="col-xs-12 col-sm-3 col-md-3 ">

    <?= $form->field($model,'id')->textInput(['readonly' => 'true'])->label('ID'); ?>
    <?= $form->field($model, 'type_object_id')->textInput(['readonly' => 'true', 'value' => TypeObject::findOne(['type_object_id' => $model->type_object_id])->name])->label('Тип объекта'); ?>
    <?= $form->field($model,'count_room')->textInput(['readonly' => 'true'])->label('Кол. комнат'); ?>
    <?= $form->field($model, 'layout_id')->textInput(['readonly' => 'true',
        'value' => Layout::findOne(['layout_id' => $model->layout_id])->name ? Layout::findOne(['layout_id' => $model->layout_id])->name : ""])->label('Тип планировки'); ?>
    <?= $form->field($model,'floor')->textInput(['readonly' => 'true'])->label('Этаж'); ?>
    <?= $form->field($model,'floor_all')->textInput(['readonly' => 'true'])->label('Этажность'); ?>
    <?= $form->field($model,'city_or_region',['inline' => true, 'template' => '{input}'])->radiolist(['0' => Yii::t('app', 'Kharkiv'), '1' => Yii::t('app', 'Region')])->label(false); ?>

    <?= $form->field($model, 'region_kharkiv_admin_id')->textInput(['readonly' => 'true',
        'value' => RegionKharkivAdmin::findOne(['region_kharkiv_admin_id' => $model->region_kharkiv_admin_id])->name ? RegionKharkivAdmin::findOne(['region_kharkiv_admin_id' => $model->region_kharkiv_admin_id])->name : ""])->label('РайонАдмин/Харьков'); ?>
    <?= $form->field($model, 'region_kharkiv_id')->textInput(['readonly' => 'true',
        'value' => RegionKharkiv::findOne(['region_kharkiv_id' => $model->region_kharkiv_id])->name ? RegionKharkiv::findOne(['region_kharkiv_id' => $model->region_kharkiv_id])->name : ""])->label('Район/Харьков'); ?>
    <?= $form->field($model, 'metro_id')->textInput(['readonly' => 'true',
        'value' => Metro::findOne(['metro_id' => $model->metro_id])->name ? Metro::findOne(['metro_id' => $model->metro_id])->name : ""])->label('Метро'); ?>

    <?= $form->field($model, 'locality_id')->textInput(['readonly' => 'true',
        'value' => Locality::findOne(['locality_id' => $model->locality_id])->name ? Locality::findOne(['locality_id' => $model->locality_id])->name : ""])->label('Населенный пункт'); ?>
    <?= $form->field($model, 'course_id')->textInput(['readonly' => 'true',
        'value' => Course::findOne(['course_id' => $model->course_id])->name ?  Course::findOne(['course_id' => $model->course_id])->name : ""])->label('Направление'); ?>
    <?= $form->field($model, 'region_id')->textInput(['readonly' => 'true',
        'value' => Region::findOne(['region_id' => $model->region_id])->name ? Region::findOne(['region_id' => $model->region_id])->name : ""])->label('Район/Область'); ?>
    <?= $form->field($model,'street')->textInput(['readonly' => 'true'])->label('Улица'); ?>
    <?php echo $form->field($model, 'street_id')->textInput(['readonly' => 'true',
        'value' => Street::findOne(['street_id' => $model->street_id])->name ? Street::findOne(['street_id' => $model->street_id])->name : ""])->label('Улица(старое название)');

        echo $form->field($model,'number_building')->textInput(['readonly' => 'true'])->label('Номер дома'); ?>
    <?= $form->field($model,'corps')->textInput(['readonly' => 'true'])->label('Корпус'); ?>
    <?= $form->field($model,'number_apartment')->textInput(['readonly' => 'true'])->label('Номер квартиры'); ?>
</div>
<div class="col-xs-12 col-sm-3 col-md-3 ">
    <?= $form->field($model,'price')->textInput(['readonly' => 'true'])->label('Цена'); ?>
    <?= $form->field($model, 'exclusive_user_id')->textInput(['readonly' => 'true',
        'value' => User::findOne(['id' => $model->exclusive_user_id])->username ? User::findOne(['id' => $model->exclusive_user_id])->username : ""])->label('Экслюзив'); ?>
    <?= $form->field($model, 'mediator_id')->textInput(['readonly' => 'true',
        'value' => Mediator::findOne(['mediator_id' => $model->mediator_id])->name ? Mediator::findOne(['mediator_id' => $model->mediator_id])->name : ""])->label('Посредник'); ?>
    <?= $form->field($model,'landmark')->textInput(['readonly' => 'true'])->label('Ориентир'); ?>
    <?= $form->field($model,'comment')->textInput(['readonly' => 'true'])->label('Причина удаления/восстановления'); ?>
    <?= $form->field($model,'exchange')->checkbox(['readonly' => 'true'])->label('Обмен'); ?>
    <?= $form->field($model,'exchange_formula')->textInput(['readonly' => 'true'])->label('Формула обмена'); ?>
    <?= $form->field($model, 'condit_id')->textInput(['readonly' => 'true',
        'value' => Condit::findOne(['condit_id' => $model->condit_id])->name ? Condit::findOne(['condit_id' => $model->condit_id])->name : ""])->label('Состояние'); ?>
    <?= $form->field($model, 'source_info_id')->textInput(['readonly' => 'true',
        'value' => SourceInfo::findOne(['source_info_id' => $model->source_info_id])->name ? SourceInfo::findOne(['source_info_id' => $model->source_info_id])->name : ""])->label('Источник информации'); ?>
    <?= $form->field($model, 'wc_id')->textInput(['readonly' => 'true',
        'value' => Wc::findOne(['wc_id' => $model->wc_id])->name ? Wc::findOne(['wc_id' => $model->wc_id])->name : ""])->label('Сан. узел'); ?>
    <?= $form->field($model, 'wall_material_id')->textInput(['readonly' => 'true',
        'value' => WallMaterial::findOne(['wall_material_id' => $model->wall_material_id])->name ? WallMaterial::findOne(['wall_material_id' => $model->wall_material_id])->name : ""])->label('Стены'); ?>
    <?= $form->field($model,'date_added')->textInput(['readonly' => 'true'])->label('Дата добавления'); ?>
    <?= $form->field($model,'date_modified')->textInput(['readonly' => 'true'])->label('Дата изменения'); ?>
</div>
<div class="col-xs-12 col-sm-3 col-md-3 ">
    <?= $form->field($model,'total_area')->textInput(['readonly' => 'true'])->label('Площадь общая'); ?>
    <?= $form->field($model,'floor_area')->textInput(['readonly' => 'true'])->label('Площадь жилая'); ?>
    <?= $form->field($model,'kitchen_area')->textInput(['readonly' => 'true'])->label('Площадь кухни'); ?>
    <?= $form->field($model,'phone_line')->checkbox(['disabled' => 'true'])->label('Телефонная линия'); ?>
    <?= $form->field($model,'bath')->checkbox(['disabled' => 'true'])->label('Ванна'); ?>
    <?= $form->field($model,'count_balcony')->textInput(['readonly' => 'true'])->label('Количество балконов'); ?>
    <?= $form->field($model,'count_balcony_glazed')->textInput(['readonly' => 'true'])->label('Застекленных балконов'); ?>
    <?= $form->field($model, 'author_id')->textInput(['readonly' => 'true',
        'value' => User::findOne(['id' => $model->author_id])->username ? User::findOne(['id' => $model->author_id])->username : ""]); ?>
    <?= $form->field($model, 'update_author_id')->textInput(['readonly' => 'true',
        'value' => User::findOne(['id' => $model->update_author_id])->username ? User::findOne(['id' => $model->update_author_id])->username : ""])->label('Изменил дпи'); ?>
    <?= $form->field($model, 'update_photo_user_id')->textInput(['readonly' => 'true',
        'value' => User::findOne(['id' => $model->update_photo_user_id])->username ? User::findOne(['id' => $model->update_photo_user_id])->username : ""])->label('Кто обновил фото'); ?>
    <?= Html::label("Доски объявлений") ?>
    <?= $form->field($model,'besplatka')->checkbox(['disabled' => 'true'])->label('Бесплатка') ?>
    <?= $form->field($model,'est')->checkbox(['disabled' => 'true'])->label('EST') ?>
    <?= $form->field($model,'mesto')->checkbox(['disabled' => 'true'])->label('Mesto.ua') ?>
</div>
<div class="col-xs-12 col-sm-3 col-md-3 ">
    <?= $form->field($model, 'note')->textarea(['rows'=>6,'readonly' => 'true'])->label('Заметки'); ?>
    <?= $form->field($model, 'notesite')->textarea(['rows'=>6, 'readonly' => 'true'])->label('Информация для показа на сайте'); ?>
    
    <select size="5" class="span12" id="select_phone" style="width: 100%">
        <?php
        $phones = explode(",", $model['phone']);
        ?>
        <?php foreach($phones as $phone) { ?>
            <?php if($phone) { ?>
                <option><?php echo $phone; ?></option>
            <?php } ?>
        <?php } ?>
    </select>
    <?= $form->field($model,'phone')->hiddenInput(); ?>
    <?= $form->field($model,'enabled')->checkbox(['disabled' => 'true'])->label('Активное') ?>
    <?= $form->field($model,'is_publish')->checkbox()->label('Опубликовать на сайте') ?>
    <?= $form->field($model,'realty_state_id')->dropDownList([
            1 => 'Новострой',
            2 => 'Вторичка',
            3 => 'Элитная',
    ])->label('Состояние недвижимости') ?>
    <?= $form->field($model,'year_built')->textInput(['readonly' => 'true'])->label('Год постройки'); ?>


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
            'overwriteInitial' => false,
            'initialPreviewShowDelete' => false,
            'initialPreviewShowUpload' => false,
            'showRemove' => false,
            'showUpload' => false,
            'showBrowse' => false,
            //'maxFileCount' => 10,
            
        ]
    ])->label(Yii::t('app', 'Photos')); ?>

</div>

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
<a href="<?php echo \yii\helpers\Url::previous(); ?>" class="btn btn-default">Отменить</a>

<?php ActiveForm::end(); ?>



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
            var id = document.getElementById("apartment-id");
            var xrequest = new XMLHttpRequest();
            xrequest.open("GET", "/admin/addsite/add?id="+id.value+"&base=apartment", true);
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
            var id = document.getElementById("apartment-id");
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
</script>


