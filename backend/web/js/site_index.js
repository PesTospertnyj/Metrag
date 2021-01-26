
let idleTime = 0;
$(function() {
    $('#search').submit(function() {
        $.ajax({
            url: '/admin/building/searchallrealty',
            data: $(this).serialize(),
            datatype : "application/json",
            type : "GET",
            async: false,
            success: function(data){
                displayRealties(data);
                //console.log(data);
            },
            beforeSend: function() {
                $('tr:not(#main-tr)').remove();
                $('#search button').attr("disabled", "disabled");
            }
        });
        $('#search button').removeAttr("disabled");
        return false;
    });

    //Increment the idle time counter every minute.
    var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

    //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
        idleTime = 0;
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });
});

var types = {
    apartments: 'Квартира',
    buildings: 'Новостройки',
    houses: 'Дома',
    commercial: 'Коммерческая недвижимость',
    areas: 'Участок',
    rent: 'Аренда'
};

function getBaseLinkOnCurrentType(type)
{
    var links = {
        apartments: 'https://admin.metrag.com.ua/admin/apartment',
        buildings: 'https://admin.metrag.com.ua/admin/building',
        houses: 'https://admin.metrag.com.ua/admin/house',
        commercial: 'https://admin.metrag.com.ua/admin/commercial',
        areas: 'https://admin.metrag.com.ua/admin/area',
        rent: 'https://admin.metrag.com.ua/admin/rent'
    };

    return links[type];
}

function displayRealties(realtyTypes)
{


    for(realtyTypeIndex in realtyTypes) {

        var realties = realtyTypes[realtyTypeIndex];

        if(!realties.length) {
            continue;
        }


        var tableBody = document.getElementById("tbody");

        for(realtyIndex in realties) {
            var realty = realties[realtyIndex];

            displayRealty(tableBody, realty);
        }
    }
}

function displayIfExists(variableText)
{
    return variableText !== undefined ? variableText: '';
}
function displayRealty(tableBody, realty) {


    var tr = document.createElement('TR');
    tableBody.appendChild(tr);


    var td = document.createElement('TD');
    td.appendChild(document.createTextNode(realty.id));
    tr.appendChild(td);

    var td = document.createElement('TD');
    td.appendChild(document.createTextNode(types[realtyTypeIndex]));
    tr.appendChild(td);

    var td = document.createElement('TD');
    td.appendChild(document.createTextNode(displayIfExists(realty.floor)));
    tr.appendChild(td);

    var td = document.createElement('TD');
    td.appendChild(document.createTextNode(displayIfExists(realty.floor_all)));
    tr.appendChild(td);

    var td = document.createElement('TD');
    td.appendChild(document.createTextNode(displayIfExists(realty.count_room)));
    tr.appendChild(td);

    var notesite = realty.notesite ? '...': '';

    var td = document.createElement('TD');
    td.appendChild(document.createTextNode(displayIfExists(realty.notesite.substr(0, 100) + notesite)));
    tr.appendChild(td);

    var td = document.createElement('TD');
    td.appendChild(document.createTextNode(displayIfExists(realty.price)));
    tr.appendChild(td);
    var td = document.createElement('TD');
    td.appendChild(document.createTextNode(displayIfExists(realty.phone)));
    tr.appendChild(td);

    var baseLink = getBaseLinkOnCurrentType(realtyTypeIndex);


    var aElement2 = document.createElement('a');
    var linkText = document.createTextNode("Показать");
    aElement2.appendChild(linkText);
    aElement2.href = baseLink + '/view?id=' + realty.id;
    document.body.appendChild(aElement2);
    var td = document.createElement('TD');
    td.appendChild(aElement2);
    tr.appendChild(td);


    var aElement1 = document.createElement('a');
    var linkText = document.createTextNode("Изменить");
    aElement1.appendChild(linkText);
    aElement1.href = baseLink + '/update?id=' + realty.id;
    document.body.appendChild(aElement1);

    var td = document.createElement('TD');
    td.appendChild(aElement1);
    tr.appendChild(td);



}

function timerIncrement() {
    idleTime = idleTime + 1;
    if (idleTime >= 30) { // 20 minutes
       $('a[href="/admin/site/logout"]').click()
    }
}

function getCaret(el) {
    if (el.selectionStart) {
        return el.selectionStart;
    } else if (document.selection) {
        el.focus();

        var r = document.selection.createRange();
        if (r == null) {
            return 0;
        }

        var re = el.createTextRange(),
            rc = re.duplicate();
        re.moveToBookmark(r.getBookmark());
        rc.setEndPoint('EndToStart', re);

        return rc.text.length;
    }
    return 0;
}

function setSelectionRange(input, selectionStart, selectionEnd) {
    if (input.setSelectionRange) {
        input.focus();
        input.setSelectionRange(selectionStart, selectionEnd);
    }
    else if (input.createTextRange) {
        var range = input.createTextRange();
        range.collapse(true);
        range.moveEnd('character', selectionEnd);
        range.moveStart('character', selectionStart);
        range.select();
    }
}

function setCaretToPos (input, pos) {
    setSelectionRange(input, pos, pos);
}
