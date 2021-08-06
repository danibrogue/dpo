$( document ).ready(function() {
    $("#btn").click(
		function(){
			sendAjaxForm('result_form', 'ajax_form', 'action_ajax_form.php');
			return false; 
		}
	);
});
 
function sendAjaxForm(result_form, ajax_form, url) {

	var names = ["Фамилия", "Имя", "E-mail", "Номер телефона"];
	var ids = ["surname", "name", "email", "phone"];
	var elements = [];
	ids.forEach(id => elements.push(document.getElementById(id)))

	for(let i = 0; i < elements.length; ++i)
	{
		if (elements[i].value == "") {
		elements[i].style.borderColor = "red";
		alert("Заполните поле \"" + names[i] + "\"");
		return false;
		}
		elements[i].style.borderColor = "";
	}

	var format_email  = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	if (format_email.test(elements[2].value) == false) {
		elements[2].style.borderColor = "red";
		alert("Введите корректный E-mail");
    	return false;
	}

	var format_phone = /^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/;
	if (format_phone.test(elements[3].value) == false) {
		alert('Введите корректный номер телефона');
		elements[3].style.borderColor = "red";
		return false;
	}

    $.ajax({
        url:     url, //url страницы (action_ajax_form.php)
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#"+ajax_form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
        	result = $.parseJSON(response);
			if(result.error != 1){
				$('#result_form').html('<p>'+result.error+'</p>');
			}
			else {
				$('#result_form').html(
				'Фамилия: '+result.surname+
				'<br>Имя: '+result.name+
				'<br>Отчество: '+result.patronymic+
				'<br>Телефон: '+result.phone+
				'<br>E-mail: '+result.email);
			}
    	},
    	error: function(response) { // Данные не отправлены
            $('#result_form').html('Ошибка. Данные не отправлены.');
    	}
 	});
}