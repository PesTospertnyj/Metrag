var add_phone_tmp;

$("#input_phone").keyup(function(){
    $(this).val($(this).val().replace(/[^0-9]/gim,''));
});

$("#cancel_phone").click(function(e){
    e.preventDefault();
    $("#input_phone").val("");
    $("#div_phone").css("display", "none");
});

$("#add_phone").click(function(e){
    e.preventDefault();
    $("#input_phone").val("");
    $("#div_phone").css("display", "block");
    add_phone_tmp = true;
});

$("#edit_phone").click(function(e){
    e.preventDefault();
    if($("#select_phone input:checkbox:checked").length) {
        $("#input_phone").val($("#select_phone input:checkbox:checked").parent().text());
        $("#div_phone").css("display", "block");
        add_phone_tmp = false;
    } else {
        alert("Вы не выбрали номер телефона для редактирования.");
    }
});

$("#delete_phone").click(function(e){
    e.preventDefault();
    if($("#select_phone input:checkbox:checked").length) {
        if(confirm("Вы уверены что хотите удалить?")) {
            $("#select_phone input:checkbox:checked").parent().remove();
            save_phone();
        }
    } else {
        alert("Вы не выбрали номер телефона для удаленя.");
    }
});

$("#ok_phone").click(function(e){
    e.preventDefault();
    if($("#input_phone").val()) {
        $("#select_phone input:checkbox:checked").parent().remove()
        $("#select_phone").append($('<li> <input type="checkbox" name="selected_phones[]"> ' + $("#input_phone").val() + '</li>'));
        save_phone();
    } else {
        alert("Вы не ввели номер телефона.");
    }
    $("#input_phone").val("");
    $("#div_phone").css("display", "none");
});

function save_phone() {
    var phone = [];
    $('#select_phone li').each(function(){
        phone.push($(this).text());
    });
    let nameEntity = $('#select_phone').attr('data-target')
    $("input[name='"+ nameEntity +"[phone]']").val(phone.join(","));
}
