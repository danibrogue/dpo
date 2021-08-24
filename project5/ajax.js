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
            let fetched_data='';
            for(let i=0;i<result.length;++i){
                fetched_data=fetched_data+'<br> Запись №'+(i+1)+
                    '<br> id: ' + result[i].id +
                    '<br> Фамилия: ' + result[i].surname +
                    '<br> Имя: ' + result[i].name +
                    '<br> Отчество: ' + result[i].patronymic + 
                    '<br> Телефон: ' + result[i].phone +
                    '<br> E-mail: ' + result[i].email;
            }
            $('#result_form').html('Получены данные:\n'+fetched_data);
        },
        error: function(response)
        {
            $('#result_form').html('Ошибка. Данные не отправлены.');
        }
    });
}