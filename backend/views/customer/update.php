<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = Yii::t('app', 'Обновить покупателя: ', [
        'modelClass' => 'Customer',
    ]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Покупатели'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Обновить');
?>
<div class="customer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?= $this->render('/new_site/_js.php', ['agent' => isset($agent) ? $agent : null]); ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $(".customer-phone").mask("+38(999) 999-99-99");

        $('.add_phone_icon').click(function(){
            let patternField = $('.additional-customer-phone.hidden').clone()
            patternField.find('input').attr('name',"<?=$model->getClassName()?>[phones][]")
            let newField = patternField.clone().appendTo('.phones-container');

            $('.phones-container .additional-customer-phone').removeClass('hidden')
            $(".customer-phone").mask("+38(999) 999-99-99");

            $(newField).find('.remove_phone_icon').click(function (){
                $(newField).remove()
            })
        })

        $('.additional-customer-phone .remove_phone_icon').click(function (){
            $(this).parents('.additional-customer-phone').remove()
        })

        if ($('#customer-type option:selected').length > 0) {
            switch ($('#customer-type option:selected').val()){
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
                    $('.field-customer-localities').css('display', 'block')
                    $('#customer-city_or_region ').css('display','none')
                    break;
                case 'land_plot':
                    $('.select-for-flats').css('display', 'none')
                    $('.select-for-houses').css('display', 'block')
                    $('.field-customer-localities').css('display', 'block')
                    $('#customer-city_or_region ').css('display','none')
                    break;
                case 'rent_house':
                    $('.select-for-flats').css('display', 'none')
                    $('.select-for-houses').css('display', 'block')
                    $('.field-customer-localities').css('display', 'block')
                    $('#customer-city_or_region ').css('display','none')
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
        } else {
            $('.select-for-flats').css('display', 'none')
            $('.select-for-houses').css('display', 'none')
        }
        $('#customer-type').change(function () {
            if ($('#customer-type option:selected').length > 0) {

                switch ($('#customer-type option:selected').val()) {
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
                        $('.field-customer-localities').css('display', 'block')
                        $('#customer-city_or_region ').css('display','none')
                        break;
                    case 'land_plot':
                        $('.select-for-flats').css('display', 'none')
                        $('.select-for-houses').css('display', 'block')
                        $('.field-customer-localities').css('display', 'block')
                        $('#customer-city_or_region ').css('display','none')
                        break;
                    case 'rent_house':
                        $('.select-for-flats').css('display', 'none')
                        $('.select-for-houses').css('display', 'block')
                        $('.field-customer-localities').css('display', 'block')
                        $('#customer-city_or_region ').css('display','none')
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
                    default:
                        break;
                }
            }
            else {
                $('.select-for-flats').css('display', 'none')
                $('.select-for-houses').css('display', 'none')
            }
        })

        // $('#customer-city_or_region input').change(function () {
        //     if ($('#customer-city_or_region input:checked').val() == 1) {
        //         $('.field-customer-regionskharkivcopy').css('display', 'none')
        //         $('.field-customer-localities').css('display', 'block')
        //     } else {
        //         $('.field-customer-localities').css('display', 'none')
        //         $('.field-customer-regionskharkivcopy').css('display', 'block')
        //     }
        // })

        $('#w0').submit(function () {
            if ($('#customer-type option:selected').val() === 'flats' || $('#customer-type option:selected').val() === 'new_buildings') {
                $('.select-for-houses').remove()
            } else {
                $('.select-for-flats').remove()
            }
        })

        $('#customer-is_enabled').change(function(){
            let checkbox = $(this)

            if(!checkbox.prop("checked")){
                $('.field-customer-archive_reason').removeClass('hidden')
            }
            else{
                $('.field-customer-archive_reason textarea').val('')
                $('.field-customer-archive_reason').addClass('hidden')
            }
        })
    })
</script>
