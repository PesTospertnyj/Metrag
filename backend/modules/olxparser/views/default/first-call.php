<?php

use app\modules\olxparser\olxParserHelper;
use yii\helpers\Url;

/** @var app\modules\olxparser\models\ParsercdSearch $searchModel  */
/** @var yii\data\ActiveDataProvider $dataProvider  */

?>
<div class="row">
    <div class="col-md-2 col-md-offset-10">
        <a href="<?= Url::to(['/olxparser/default/params']) ?>" class="btn btn-success">Настройки</a>
    </div>
</div>
<div class="colLeft">
    <h2>На данный момент база данных пуста.</h2>
    <h3>Начать процесс парсинга?</h3>

    <form action="<?=Url::to(['default/clear-tables'])?>">
        <input type="submit" value="Очистить таблицы" class="btn btn-danger">
    </form>
    <br>
    <br>
    <br>
    <br>
    <button id="pageSearchStart" class="btn btn-success">Начать поиск страниц</button>
    <button id="linksParseStart" class="btn btn-success">Начать разбор ссылок</button>
    <br>
    <br>
    <div style="color: red;">Процес может занять некоторое время</div>
    <div class="messages" ></div>
    <div class="errors"></div>
    <br>
    <br>
    <br>
    <br>
    <br>

</div>

<div id="hellopreloader"><div id="hellopreloader_preload"></div></div>

<div class="colRg">

    </div>

        <span class="showTable">Показать таблицу</span>
        <a href="<?= Url::to(['/olxparser/compare/index']) ?>">
            <span class="showTable">Отсеять объявления</span>
        </a>

    </div>

<?php

if( olxParserHelper::tableExists('new_parser_olx_parser') ){
echo $this->render('result', [
'searchModel' => $searchModel,
'dataProvider' => $dataProvider,
]);

} else {
?>


    <p>
        Ссыли не были получены
    </p>

    <?php
}
?>





