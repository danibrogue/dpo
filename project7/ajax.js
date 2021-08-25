$(document).ready(function(){
    $("#send_form").click(function(){
        send_ajax("formx", "model.php");
        return false;
    });
});

function send_ajax(ajax_form, url)
{
    $.ajax({
        url:     url, //url страницы
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#"+ajax_form).serialize(),  // Сериализуем объект
        success: function(response) { //Данные отправлены успешно
            result = $.parseJSON(response);
            $('#result_form').html('Получен ответ:'+
                '<br> Индекс: ' + result.zip_code +
                '<br> Страна: ' + result.country +
                '<br>Регион: ' + result.province +
                '<br> Населенный пункт: ' + result.locality +
                '<br> Улица: ' + result.street +
                '<br> Дом: ' + result.house +
                '<br> Координаты: ' + result.longtitude+' '+result.latitude +
                '<br> Ближайшее метро: ' + result.metro
            )
        },
        error: function(response)
        {
            $('#result_form').html('Ошибка. Данные не отправлены.');
        }
    });
}