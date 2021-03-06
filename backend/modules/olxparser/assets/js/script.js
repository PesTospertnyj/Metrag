$(function() {
    $.ajaxSetup({
        async: true,
        type: 'POST',
        dataType: 'json',
        timeout: 0
    });

    $("#pageSearchStart").click(searchAllPages);
    $("#linksParseStart").click(linksParse);
    $("#researchPage").click(researchPage);

    //======================== парсинг страниц
    function searchAllPages() {
        addMessage("Поиск...");
        getPage();
    }

    function getPage() {

        //addMessage("Запрос на поиск страницы",true);
        $.ajax({
            url: main_url,
            dataType: 'json',
            success: function(data) {
                if (parseInt(data.ready) == parseInt(data.total)) {
                    addMessage("Все страницы обработаны: " + data.ready + " из " + data.total, true);
                    addError("", true);
                }
                if (parseInt(data.ready) < parseInt(data.total)) {
                    if (data.errorCode == 0) {
                        //addMessage("Страница: " + data.url + " " + data.ready + " из " + data.total, true);
                        addMessage("Страница: " + data.url, true);
                        getPage();
                    } else {
                        addError("Ошибка при получении страницы:" + data.url + "<br>" + "Обработано " + data.ready + " из " + data.total, true );
                        switch(+data.errorCode){
                            case 1:{
                                addError("Список прокси пуст. Начните сначала");
                                // и сами начинаем
                                getPage();
                            }break;
                            case 2:{
                                addError("Прокси не отвечает:" + data.proxy);
                                getPage();
                            }break;


                        }
                    }


                    console.dir(data);
                }


            },
            error: function(data, txtStatus, error) {
                $(".errors").html("Работа завершена некорректно" + data);
                addMessage(txtStatus);
                addMessage(error);
                addMessage("!!!" + data.responseText + "!!!");
                console.log(main_url);
                console.log(data);
            }
        });


    }

    //=====================парсинг уникальных ссылок
    function linksParse() {
        addMessage("Парсинг ссылки...");
        getObject();
    }

    function getObject() {

        //addMessage("Запрос на разбор объекта",true);
        $.ajax({
            url: "/admin/olxparser/default/handle-apartments-links",
            dataType: 'json',
            success: function(data) {
                if(data.status == "end"){
                    addMessage("Все страницы разобраны.", true);
                    addError("", true)
                }else{
                    if (data.errorCode == 0) {
                        //addMessage("Страница: " + data.url + " " + data.ready + " из " + data.total, true);
                        addMessage("Страница: " + data.url, true);
                        getObject();
                    } else {
                        addError("Ошибка при получении данных:" + data.url + "<br>" + "Обработано " + data.ready + " из " + data.total, true );
                        switch(+data.errorCode){
                            case 1:{
                                addError("Список прокси пуст. Начните сначала");

                            }break;
                            case 2:{
                                addError("Прокси не отвечает:" + data.proxy);
                                getObject();
                            }break;


                        }
                    }

                }


                console.dir(data);

            },
            error: function(data, txtStatus, error) {
                $(".errors").html("Работа завершена некорректно" + data);
                addMessage(txtStatus);
                addMessage(error);
                addMessage("!!!" + data.responseText + "!!!");
                console.log(main_url);
                console.log(data);
            }
        });


    }

    //-------------research page----------------
    function researchPage() {
        var limit = $("select[id=\"pageLimit\"] option:selected").val();
        //alert(limit);
        $.ajax({
         url: "/admin/olxparser/default/research-page?limit="+limit,
         dataType: 'json',
         success: function(data) {
             console.log(data);
             getPage();
         },
         error: function(data, txtStatus, error) {
         $(".errors").html("Работа завершена некорректно" + data);
         console.log(main_url);
         console.log(data);
         }
         });
    }







        function serverPagesRequest() {
        $.post("/admin/olxparser/default/process-pages-info", { timeout: 5 }, function(data) {
                console.log(data);
                addMessage("total:" + data.total + " :: ready:" + data.ready);
                if (parseInt(data.ready) < parseInt(data.total)) {
                    searchAllPages();
                }
            }, "json")
            .fail(function() {
                var d = new Date;
                addMessage("WTF?Сервер не отвечает." + d.getHours() + ":" +
                    d.getMinutes() + ":" + d.getSeconds());
            });
    }

    function serverLinksRequest() {
        $.post("/admin/olxparser/default/process-links-info", { timeout: 5 }, function(data) {
                console.log(data);
                addMessage("total:" + data.total + " :: ready:" + data.ready);
                if (parseInt(data.ready) < parseInt(data.total)) {
                    linksParse();
                }
            }, "json")
            .fail(function() {
                var d = new Date;
                addMessage("WTF?Сервер не отвечает." + d.getHours() + ":" +
                    d.getMinutes() + ":" + d.getSeconds());
            });
    }

    function addMessage($mess, replace = false) {
        if (replace) {
            $(".messages").html($mess);
        } else {
            $(".messages").html($mess + "<br>" + $(".messages").html());
        }
    }
    function addError($mess, replace = false) {
        if (replace) {
            $(".errors").html($mess);
        } else {
            $(".errors").html($mess + "<br>" + $(".errors").html());
        }
    }
});