<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
?>
<?//= Yii::$app->params['adminEmail'];?>
<div class="padding ">
    <div class="row breadcrum">
        <div class="col-md-12 breadcrum">
            <div class="col-md-9 col-xs-8">
                <a href="/" title="" class="text-muted" >Главная</a>
                <span class="text-muted">&gt;</span>
                <a title="Владельцам" href="/" class="text-muted">Владельцам</a>
                <span class="text-muted">&gt;</span>
                <span class="text-muted active is_last">Оценка недвижимости</span>
                <span id="for_back_to_search"></span>
            </div>
        </div>
    </div>
    <div class="product">
        <div class="content">
            <div class="line">
            <span>
                <h1><?= Yii::t('app', 'PROPERTY VALUATION')?></h1>
                <img src="<?= Url::base(true);?>/images/category-home.png" alt="">
            </span>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-md-9 col-xs-9">
        <div id="node-143" class="node">
            <span class="submitted"></span>
            <div class="clear-block">
            <h3>Экспертная оценка недвижимости</h3>
            <p>При совершении любой сделки с недвижимостью важно произвести правильную и актуальную оценку объекта. Однако сам процесс оценки является сложным. Во-первых, оценщик обязан досконально ориентироваться в текущей конъюнктуре и тенденциях столичного рынка недвижимости в целом. Во-вторых, он должен уметь «увидеть» и точно оценить индивидуальные особенности каждого конкретного объекта недвижимости — степень износа помещения, стоимость произведенных улучшений и множество других факторов. В-третьих, хорошо ориентироваться в современной законодательной базе относительно оценки и операций с недвижимым имуществом, а также оперативно отслеживать все происходящие изменения.</p>
            <p>В АН «Метраж» работают профильные специалисты, которые имеют огромный практический опыт и постоянно отслеживают ситуацию на рынке недвижимости Киева. Сертифицированный оценщик нашего агентства готов произвести для Вас профессиональную оценку рыночной, потребительской, инвестиционной и страховой стоимости любого объекта. Обратившись к нам, Вы можете быть уверены, что Вашу квартиру, дом, дачу или объект коммерческой недвижимости оценят быстро, точно и квалифицированно.</p>
            <p>Сертификат субъекта оценочной деятельности №14145/13, дата выдачи: 02 января 2013 года.</p>
            <p>Контактные телефоны: +380 (44) 537-07-07; +380 (50) 444-26-60 - <strong>Руслана Андроникова</strong></p>
            <p><strong>Оставить заявку</strong></p>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name')->textInput() ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'phone') ?>

                    <?= $form->field($model, 'subject') ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app' ,'Send'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <?php  echo $this->render('/layouts/_rightblock'); ?>
        </div>
    </div>
