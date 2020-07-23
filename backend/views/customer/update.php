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
<script>
    $(document).ready(function () {
        if ($('#customer-type option:selected').length > 0) {

            if ($('#customer-type option:selected').val() === 'flats-new_buildings') {
                $('.select-for-flats').css('display', 'block')
                $('.select-for-houses').css('display', 'none')
            } else {
                $('.select-for-flats').css('display', 'none')
                $('.select-for-houses').css('display', 'block')
                $('.field-customer-locality_id').css('display', 'none')
            }
        }
        else{
            $('.select-for-flats').css('display', 'none')
            $('.select-for-houses').css('display', 'none')
        }
        $('#customer-type').change(function () {
            if ($('#customer-type option:selected').length > 0) {

                if ($('#customer-type option:selected').val() === 'flats-new_buildings') {
                    $('.select-for-flats').css('display', 'block')
                    $('.select-for-houses').css('display', 'none')
                } else {
                    $('.select-for-flats').css('display', 'none')
                    $('.select-for-houses').css('display', 'block')
                    $('.field-customer-locality_id').css('display', 'none')
                }
            }
            else{
                $('.select-for-flats').css('display', 'none')
                $('.select-for-houses').css('display', 'none')
            }
        })

        $('#customer-city_or_region input').change(function(){
            if($('#customer-city_or_region input:checked').val() == 1){
                $('.field-customer-region_kharkiv_id').css('display','none')
                $('.field-customer-locality_id').css('display','block')
            }
            else{
                $('.field-customer-locality_id').css('display','none')
                $('.field-customer-region_kharkiv_id').css('display','block')
            }
        })

        $('#w0').submit(function(){
            debugger
            if ($('#customer-type option:selected').val() === 'flats-new_buildings') {
                $('.select-for-houses').remove()
            }
            else{
                $('.select-for-flats').remove()
            }
        })
    })
</script>
