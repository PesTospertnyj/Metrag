<h1>
    <?
    echo "page for pic convert!!!!";
    echo $counter;
    ?>
</h1>
<br>
<br>
<br>

<div id="progress" style="display: none;">
    <p><big>Please wait,operation in process...</big></p>
    <span id="proc">0</span> of
    <span id="all"><?= $count; ?></span>
</div>

<div id="success" style="display: none;">
    <p><big>Operation success! Please reload page.</big></p>
</div>

<button id="start">Start convert</button>

<script>
    var progress = document.getElementById("progress");
    window.onload = function () {
        var start = document.getElementById("start");
        start.onclick = doAjax;
    };

    var limit = 0;

    function doAjax(){
        progress.style.display = "";
        var all = document.getElementById("all");
        var proc = document.getElementById("proc");
        var start = proc.innerHTML;
        //var limit = 100;
        var xrequest = new XMLHttpRequest();
        xrequest.open("GET", "/admin/house/linkimages?start=" +  start, true);
        xrequest.send();

        xrequest.onload = function() {
            proc.innerHTML = this.responseText;

            if(start<=all){
                doAjax();
            }
            else{
                progress.style.display = "none";
                var success = document.getElementById("success");
                success.style.display = "";
            }
        };
    }
</script>
