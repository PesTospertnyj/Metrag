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
<?= $this->render('/new_site/_js.php', ['agent' => $agent]); ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        if ($('#customer-type option:selected').length > 0) {

            if ($('#customer-type option:selected').val() === 'flats' || ($('#customer-type option:selected').val() === 'new_buildings') {
                $('.select-for-flats').css('display', 'block')
                $('.select-for-houses').css('display', 'none')
            } else {
                $('.select-for-flats').css('display', 'none')
                $('.select-for-houses').css('display', 'block')
                $('.field-customer-localities').css('display', 'none')
            }
        }
        else{
            $('.select-for-flats').css('display', 'none')
            $('.select-for-houses').css('display', 'none')
        }
        $('#customer-type').change(function () {
            if ($('#customer-type option:selected').length > 0) {

                if ($('#customer-type option:selected').val() === 'flats' || ($('#customer-type option:selected').val() === 'new_buildings') {
                    $('.select-for-flats').css('display', 'block')
                    $('.select-for-houses').css('display', 'none')
                } else {
                    $('.select-for-flats').css('display', 'none')
                    $('.select-for-houses').css('display', 'block')
                    $('.field-customer-localities').css('display', 'none')
                }
            }
            else{
                $('.select-for-flats').css('display', 'none')
                $('.select-for-houses').css('display', 'none')
            }
        })

        $('#customer-city_or_region input').change(function(){
            if($('#customer-city_or_region input:checked').val() == 1){
                $('.field-customer-regionskharkivcopy').css('display','none')
                $('.field-customer-localities').css('display','block')
            }
            else{
                $('.field-customer-localities').css('display','none')
                $('.field-customer-regionskharkivcopy').css('display','block')
            }
        })

        $('#w0').submit(function(){
            if ($('#customer-type option:selected').val() === 'flats' || ($('#customer-type option:selected').val() === 'new_buildings') {
                $('.select-for-houses').remove()
            }
            else{
                $('.select-for-flats').remove()
            }
        })
    })
</script>
