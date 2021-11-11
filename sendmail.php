<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/Exception.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru', 'phpmailer/language/');
$mail->IsHTML(true);

//От кого письмо
$mail->setFrom('pochta@email.ru', 'Отправитель');
//Кому отправляем
$mail->addAddress('this.prototype.user1@gmail.com');
//Тема письма
$mail->Subject = 'Письмо тестовое';

//Текущий статус
$role = "Ученик";
if ($_POST['role'] == "learner") {
    $role = "Студент";
} else if ($_POST['role'] == "working") {
    $role = "Работающий";
} else if ($_POST['role'] == "unemployed") {
    $role = "Домохозяин";
} else if ($_POST['role'] == "other") {
    $role = "Другой вариант";
}

//Рекомендации
$recommends = "Конечно";
if ($_POST['recommends'] == "maybe") {
    $recommends = "Может быть";
} else if ($_POST['recommends'] == "not-sure") {
    $recommends = "Не уверен";
}

//Тело письма
$body = '<h1>Вам письмо!</h1>';
//Проверка строк на пустоту и присваивание им параметров
if (trim(!empty($_POST['name']))) {
    $body .= '<p><strong>Имя:</strong> ' . $_POST['name'] . '</p>';
}
if (trim(!empty($_POST['email']))) {
    $body .= '<p><strong>Email:</strong> ' . $_POST['email'] . '</p>';
}
if (trim(!empty($_POST['age']))) {
    $body .= '<p><strong>Возраст:</strong> ' . $_POST['age'] . '</p>';
}
if (trim(!empty($_POST['role']))) {
    $body .= '<p><strong>Статус:</strong> ' . $role . '</p>';
}
if (trim(!empty($_POST['recommends']))) {
    $body .= '<p><strong>Рекомендации:</strong> ' . $recommends . '</p>';
}
if (trim(!empty($_POST['message']))) {
    $body .= '<p><strong>Сообщение:</strong> ' . $_POST['message'] . '</p>';
}
//Присваивание переменной плагину
$mail->Body = $body;
//Обработка отправки
if (!$mail->send()) {
    $message = 'Ошибка отправки';
} else {
    $message = 'Данные успешно отправлены!';
}
//Формируется cooбщение результата отправки в json
$response = ['message' => $message];
//Возврат сообщения с заголовком json в javascript
header('Content-type: application/json');
echo json_encode($response);
