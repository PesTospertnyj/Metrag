<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Покупатели'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Обновить'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger move-to-archive',
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => function($data){
                    return \backend\models\Customer::AVAILABLE_TYPES_LABELS[$data->type];
                }
            ],
            [
                'attribute' => 'localities',
                'format' => 'raw',
                'value' => function($data){

                    $result = [];
                    if(count($data->localities) > 0){
                        $result = $data->localities;
                    }
                    if(count($data->regions) > 0){
                        $result = $data->regions;

                    }
                    if(count($data->regionsKharkiv) > 0){
                        $result = array_merge($data->regionsKharkiv,$result);
                    }
                    $resultMapped = array_map(function($item){
                        return $item['name'];
                    },$result);

                    if(count($resultMapped) === 0) return '-';
                    return implode(', ',$resultMapped);
                }
            ],
            [
                'label' => 'Телефон(ы)',
                'value' => function($model){
                    $phones = array_map(function($phoneItem){
                        return $phoneItem->phone;
                    },$model->customerPhones);
                    return implode(', ',$phones);
                },
            ],
            'price_from',
            'price_to',
            'total_area_from',
            'total_area_to',
            'info:ntext',
            'is_public',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
<div id="openModal" class="modal" data-customer="<?=$model->id?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Укажите причину</h3>
                <a href="#close" title="Close" class="close">×</a>
            </div>
            <div class="modal-body">
                <div class="required">
                    <label for="reason" class="control-label">Причина</label>
                    <textarea name="" id="reason" style="resize: none;width: 100%;height: 100px" ></textarea>
                </div>
                <div class="text-center">
                    <button id="archive_putton" class="btn btn-danger inline-block">Удалить покупателя</button>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .modal {
        position: fixed;
        /* фиксированное положение */
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: rgba(0, 0, 0, 0.5);
        /* цвет фона */
        z-index: 1050;
        opacity: 0;
        /* по умолчанию модальное окно прозрачно */
        -webkit-transition: opacity 400ms ease-in;
        -moz-transition: opacity 400ms ease-in;
        transition: opacity 400ms ease-in;
        /* анимация перехода */
        pointer-events: none;
        /* элемент невидим для событий мыши */
    }

    /* при отображении модального окно */
    .modal.show {
        opacity: 1;
        pointer-events: auto;
        overflow-y: auto;
    }

    /* ширина модального окна и его отступы от экрана */
    .modal-dialog {
        position: relative;
        width: auto;
        margin: 10px;
    }

    @media (min-width: 576px) {
        .modal-dialog {
            max-width: 500px;
            margin: 30px auto;
        }
    }

    /* свойства для блока, содержащего контент модального окна */
    .modal-content {
        position: relative;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
        background-color: #fff;
        -webkit-background-clip: padding-box;
        background-clip: padding-box;
        border: 1px solid rgba(0, 0, 0, .2);
        border-radius: .3rem;
        outline: 0;
    }

    @media (min-width: 768px) {
        .modal-content {
            -webkit-box-shadow: 0 5px 15px rgba(0, 0, 0, .5);
            box-shadow: 0 5px 15px rgba(0, 0, 0, .5);
        }
    }

    /* свойства для заголовка модального окна */
    .modal-header {
        padding: 15px;
        border-bottom: 1px solid #eceeef;
    }
    .modal-header > h3 {
        float: left;
    }
    .modal-header>a{
        float: right;
    }
    .modal-title {
        margin-top: 0;
        margin-bottom: 0;
        line-height: 1.5;
        font-size: 1.25rem;
        font-weight: 500;
    }

    /* свойства для кнопки "Закрыть" */
    .close {
        float: right;
        font-family: sans-serif;
        font-size: 24px;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        opacity: .5;
        text-decoration: none;
    }

    /* свойства для кнопки "Закрыть" при нахождении её в фокусе или наведении */
    .close:focus,
    .close:hover {
        color: #000;
        text-decoration: none;
        cursor: pointer;
        opacity: .75;
    }

    /* свойства для блока, содержащего основное содержимое окна */
    .modal-body {
        position: relative;
        -webkit-box-flex: 1;
        -webkit-flex: 1 1 auto;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        padding: 15px;
        overflow: auto;
    }
</style>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
<script>

    $(document).ready(function (){


        $('.move-to-archive').click(function(e){
            e.preventDefault()
            $('#openModal').addClass('show')
        })
        $('#openModal button').click(function(){
            if($('#openModal textarea').val().length === 0){
                return
            }
            $('#openModal button').attr('disabled',true)
            let customerId =  $('#openModal').attr('data-customer')
            $.ajax({
                url: "/admin/customer/archive?id=" + customerId,
                type: "post",
                data:{reason: $('#openModal textarea').val()},
                success: function (response) {
                    if(response.success) {
                        $('#openModal button').attr('disabled',false)
                        $('#openModal textarea').val('')
                        $('#openModal').removeClass('show')
                        window.location.reload()
                    } else {

                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                }

            });
        })
        $('#openModal .close').click(function(e){
            e.preventDefault()
            $('#openModal textarea').val('')
            $('#openModal').removeClass('show')
        })
    })
</script>
