<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
?>
<style>
    table {
        background: #fafbff;
    }
    #main-tr {
        border-bottom: 2px solid;
    }

    td,th {
        padding: 6px;
    }
</style>
<?php

/* @var $this yii\web\View */

$this->title = Yii::t('yii', 'Metrag Admin');
?>
<div class="site-index" style="width: 30%">

    <?php $form = ActiveForm::begin([
        'action' => '/admin/search',
        'options' => [
            'id' => 'search'
        ]
    ]); ?>

    <?php
//    $model->type_realty = 'apartment';
//    echo $form->field($model, 'type_realty')->dropDownList(
//        \backend\models\TypeRealty::find()->select(['name', 'name_table'])->indexBy('name_table')->column())->label(false);
//    ?>
    <?= $form->field($model, 'id')->label('ID'); ?>
    <?= $form->field($model, 'phone')->label(Yii::t('app', 'Phone')); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div id="search-result">

        <table border="1">
            <tbody id="tbody">
                <tr id="main-tr">
                    <th>Id</th>
                    <th>Тип</th>
                    <th>Этаж</th>
                    <th>Этажей</th>
                    <th>Комнаты</th>
                    <th>Текст</th>
                    <th>Цена</th>
                    <th>Телефон</th>
                    <th>Просмотр</th>
                    <th>Редактирование</th>
                </tr>
            </tbody>
        </table>

    </div>

</div>

<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script src="/admin/js/site_index.js"></script>