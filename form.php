<?
	if (isset($_POST) && $_POST != []) {
		$to = '89851007873@mail.ru';
		$subject = 'Новая заявка на сайте';
		$message = "Имя: " . $_POST['name'] . "\n" .
			"Почта: " . $_POST['email'] . "\n" .
			"Телефон: " . $_POST['phone'] . "\n";
		$headers = 'From: mysite@gmail.com' . "\n" .
    		'X-Mailer: PHP/' . phpversion();

    	if (mail($to, $subject, $message, $headers)) {
    		header('Location: success.html');
    		exit();
    	}
    } else {
    	header('Location: index.html');
    	exit();
    }
?>