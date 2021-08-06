<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

ini_set('display_errors',1);
$connection = new PDO('pgsql:host=localhost;port=5432;user=postgres;password=empty;dbname=task3_db');
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$date_string = date('Y-m-d H:i:s');
$error = '0';
    
$send_time = spam_filter();
if ($send_time > 0)
{
    $error = 'Следующую заявку можно будет отправить через '.$send_time.' минут';
}
else
{
    $error = send_message();
}

// Формируем массив для JSON ответа
$result = array(
	'surname' => $_POST["surname"],
    'name' => $_POST["name"],
    'patronymic' => $_POST["patronymic"],
	'phone' => $_POST["phone"],
    'email' => $_POST["email"],
    'error' => $error
); 

// Переводим массив в JSON
echo json_encode($result);

function spam_filter() //возвращает кол-во минут до отправки формы
    {
        global $connection;
        global $date_string;
        
        $query = $connection->prepare('SELECT datetime FROM request WHERE email=\'{'.$_POST['email'].'}\' ORDER BY id DESC LIMIT 1');
        $result = $query->execute();
        if ($result) {
            $query_date = $query->fetchColumn();
        }
        if ($query_date != '') {
            $date_now = new DateTime($date_string);
            $date_last = new DateTime($query_date);
            $diff = $date_now->diff($date_last);
            if($diff->y > 0 || $diff->m > 0 || $diff->d > 0 || $diff->h > 1) {
                return 0;
            }
            return 60 - $diff->i;
        }
        return 0;
    }
    
    function send_message()
    {
        global $connection;
        global $date_string;
        // Создание экземпляра и передача `true` для включения исключений
        $mail= new \PHPMailer\PHPMailer\PHPMailer(true);
        try {
            //Настройки почты
            $mail->isSMTP();                                            //Отправление сообщения черещ SMTP
            $mail->Host = 'smtp.gmail.com';                             //Настройка SMTP для отправки
            $mail->SMTPAuth = true;                                     //Включение аутетнтификатора SMTP
            $mail->Username = 'hotlinetheslayer@gmail.com';              //SMTP имя пользователя
            $mail->Password = 'CutMyHair';                           //SMTP пароль
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;    //Включение шифрования
            $mail->Port = 587;                                        //TCP  порт для подключения
            $mail->CharSet = 'UTF-8';
            
            //Получатель сообщения
            $mail->setFrom('hotlinetheslayer@gmail.com', 'Newsletter');//Адрес почты и имя отправителя
            $mail->addAddress("daniel_frawley@protonmail.com", "$_POST[name]");     //Добавление получателя сообщения.Имя не обязательно
            
            /*Вложения
            $mail->addAttachment('/var/tmp/file.tar.gz');         //Добавления вложений
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Имя не обязателно
            */
            
            //Содержание сообщения
            $mail->isHTML(true);                                  //Установка формата html в эл. почте
            $mail->Subject = 'Test message sending';
            $mail->Body = "<h3>Новая заявка:</h3>
            Имя: $_POST[name]<br>
            Фамилия: $_POST[surname]<br>
            Отчество: $_POST[patronymic]<br>
            <b>Электронная почта: $_POST[email]</b><br> 
            <b>Номер телефона: $_POST[phone]</b>";
            
            //В виде обычного текста для почтовых клиентов, отличных от HTML.
            //$mail->AltBody = '';
            
            $mail->send();
            try {
                $query = $connection->prepare('INSERT INTO request (name, surname, patronymic, phone, datetime, email)
                    values(\'{'.$_POST['name'].'}\', \'{'.$_POST['surname'].'}\',
                    \'{'.$_POST['patronymic'].'}\',\'{'.$_POST['phone'].'}\',\''.$date_string.'\', \'{'.$_POST['email'].'}\')');
                    $query->execute();
                } 
                catch (Exception $e) {
                    return $e;
                }
        } 
        catch (Exception $e) {
            return "Не удалось отправить сообщение: {$mail->ErrorInfo}";
        }
        return 1;
    }

?>