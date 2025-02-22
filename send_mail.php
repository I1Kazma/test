<?php
$name = $_POST['name'];
$phone = $_POST['phone'];
$comment = $_POST['comment'];
$to = '89851007873@mail.ru';
$header = 'Новая заявка на сайте';
$message = "Имя пользователя: $name \nНомер телефона: $phone \nОтзыв: $comment";
$send = mail($to, $header, $message, "Content-type:text/plain; charset = UTF-8\r\nFrom:$email");
if (mail($to, $subject, $message, $headers)) {
    header('Location: success.html');
    exit();
} else {
    header('Location: index.html');
    exit();
}
?>