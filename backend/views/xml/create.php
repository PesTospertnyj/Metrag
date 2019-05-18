<?
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
?>
<div class="tab-content active">
    <div class="row-fluid">
         <div class="span12">
             <div class="control-group">
                  <?php if ($timestamp){ ?>
                        <p>Дата последнего обновления: <?php echo $timestamp ?></p>
                        <?php } ?>

                        <h5>Активные XML:</h5>
                        <p><a target="_blank" href="<?= Url::base(true);?>/xmls/besplatka.xml">Бесплатка</a></p>
                        <p><a target="_blank" href="<?= Url::base(true);?>/xmls/mesto.xml">mesto.ua</a></p>
                        <p><a target="_blank" href="<?= Url::base(true);?>/xmls/est.xml">est.ua</a></p>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="control-group">
                        <h5>Просмотр объявлений добавленных в XML:</h5>
                        <p><a target="_blank" href="show-xml-objects?resource=besplatka">Бесплатка</a></p>
                        <p><a target="_blank" href="show-xml-objects?resource=mesto">mesto.ua</a></p>
                        <p><a target="_blank" href="show-xml-objects?resource=est">est.ua</a></p>
                    </div>
                </div>
            </div>
            <div class='row-fluid'>
                <div class="span12">
                    <div class="control-group">
                        <h5>Статус формирования XML:</h5>
                        <?php if (isset($data['xml_success']) && $data['xml_success']) foreach ($data['xml_success'] as $one_success) echo $one_success . "<br>" ?>
                    </div>
                </div>
            </div>
            <div class='row-fluid'>
                <div class="span12">
                    <div class="control-group">
                        <h5>Лог ошибок:</h5>
                        <?php if (isset($data['errors']) && $data['errors']) foreach ($data['errors'] as $error) foreach ($error as $row_err) echo $row_err . "<br>" ?>
                    </div>
                </div>
            </div>

  </div>
<div class="pull-right">
    <?php
    $form = ActiveForm::begin([
        'method' => 'post',
        'action' => ['xml/create-xml'],
    ]);
    ?>
    <?= Html::submitButton('Сформировать', ['class' => 'btn btn-primary']);?>
    <?php ActiveForm::end(); ?>
</div>


