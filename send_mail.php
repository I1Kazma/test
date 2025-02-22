<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Ensure proper error handling
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Enable error logging
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');

// Set JSON header
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

try {
    if (!file_exists('vendor/autoload.php')) {
        throw new Exception('Composer autoload file not found. Please run composer install');
    }
    
    require 'vendor/autoload.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method: ' . $_SERVER['REQUEST_METHOD']);
    }

    // Get JSON input and decode
    $input = file_get_contents('php://input');
    if (!$input) {
        throw new Exception('No input data received');
    }

    error_log('Received input: ' . $input);

    $data = json_decode($input, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON data: ' . json_last_error_msg());
    }
    
    if (!isset($data['name']) || !isset($data['email']) || !isset($data['message'])) {
        throw new Exception('Missing required fields: ' . implode(', ', array_diff(['name', 'email', 'message'], array_keys($data))));
    }

    $mail = new PHPMailer(true);

    try {
        // Enable debug output
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Debugoutput = function($str, $level) {
            error_log("SMTP Debug: $str");
        };

        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.mail.ru';
        $mail->SMTPAuth = true;
        $mail->Username = '89851007873@mail.ru';
        // Здесь нужно будет заменить на пароль приложения, который вы получите в настройках mail.ru
        $mail->Password = 'Scpty3EaAa4wgKR0r31i';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->CharSet = 'UTF-8';

        // Увеличиваем таймаут
        $mail->Timeout = 60;
        $mail->SMTPKeepAlive = true;

        // Recipients
        $mail->setFrom('89851007873@mail.ru', 'Contact Form');
        $mail->addAddress('89851007873@mail.ru');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Новое сообщение с сайта';
        $mail->Body = "
            <h2>Новое сообщение с формы обратной связи</h2>
            <p><strong>Имя:</strong> " . htmlspecialchars($data['name']) . "</p>
            <p><strong>Номер телефона:</strong> " . htmlspecialchars($data['email']) . "</p>
            <p><strong>Сообщение:</strong><br>" . nl2br(htmlspecialchars($data['message'])) . "</p>
        ";

        if (!$mail->send()) {
            throw new Exception('Mailer Error: ' . $mail->ErrorInfo);
        }
        echo json_encode(['success' => true, 'message' => 'Сообщение успешно отправлено']);
    } catch (Exception $e) {
        error_log("PHPMailer Error: " . $e->getMessage());
        throw new Exception("Mail sending failed: " . $e->getMessage());
    }
} catch (Exception $e) {
    error_log("Error in send_mail.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Ошибка при отправке: ' . $e->getMessage(),
        'error_details' => $e->getTraceAsString()
    ]);
}
?> 