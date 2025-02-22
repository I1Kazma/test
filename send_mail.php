<?php
$name = $_POST['name'];
$phone = $_POST['phone'];
$comment = $_POST['comment'];
$to = 'karmakazmenko@gmail.com';
$header = 'Отзыв от пользователя';
$message = "Имя пользователя: $name \nНомер телефона: $phone \nОтзыв: $comment";
$send = mail($to, $header, $message, "Content-type:text/plain; charset = UTF-8\r\nFrom:$email");
?>