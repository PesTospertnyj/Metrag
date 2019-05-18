<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<?php $count = \app\modules\parsercd\models\Parsercd::find()->count(); ?>
<div style="width: 90%; margin: auto;">
    <div class="colLeft">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'excelFile')->fileInput() ?>

            <button class="btn btn-success"><?php echo Yii::t('app', 'Parsing file')?></button>

        <?php ActiveForm::end() ?>
    </div>

    <div class="colRight" style="height: 150px;">
        <h1>
            <?
            echo $counter;
            ?>
        </h1>
        <br>
        <br>
        <br>

        <div id="progress" style="display: none;">
            <p>Please wait,operation in process...</p>
            <span id="proc">0</span> of
            <span id="count"><?php echo $count?></span>
        </div>

        <div id="success" style="display: none;">
            <p><big>Operation success! Please reload page.</big></p>
        </div>

        <button id="start" class="btn btn-success">Отсеять объявления</button>

        <script>
            var progress = document.getElementById("progress");
            window.onload = function () {
                var start = document.getElementById("start");
                start.onclick = doAjax;
            };

            var limit = 0;

            function doAjax(){
                progress.style.display = "";
                var count = document.getElementById("count");
                var proc = document.getElementById("proc");

                var start = proc.innerHTML;
                var all = count.innerHTML;

                var xrequest = new XMLHttpRequest();
                xrequest.open("GET", "/admin/parsercd/compare/compareitems?start=" +  start, true);
                xrequest.send();

                xrequest.onload = function() {
                    proc.innerHTML = this.responseText;

                    if(parseInt(start)<=parseInt(all))
                    //if(true)
                    {
                        doAjax();
                    }
                    else{
						var nxrequest = new XMLHttpRequest();
                		nxrequest.open("GET", "/admin/parsercd/compare/deleteitems", true);
                		nxrequest.send();
						
                        progress.style.display = "none";
                        var success = document.getElementById("success");
                        success.style.display = "";
                    }
                };
            }
        </script>
    </div>
</div>