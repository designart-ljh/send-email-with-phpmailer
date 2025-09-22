<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
include_once '../lib/lib.php';

$mail = new PHPMailer(true);
$email_account = '이메일 계정';
$password = '앱 비밀번호';
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $email_account;
    $mail->Password = $password;
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->Timeout = 30;
    $mail->CharSet = 'utf8';
    $mail->Encoding = 'base64';
    $mail->SMTPDebug = 4;
    $mail->setFrom($email_account, '관리자');
    $mail->addAddress($_POST['email'], $_POST['name']);
    $mail->isHTML(true);
    $mail->Subject = '메일입니다.';
	$content = file_get_contents('template.html');
    $content = str_replace('{{name}}', htmlspecialchars($_POST['name']), $content);
    $content = str_replace('{{company}}', htmlspecialchars($_POST['company']), $content);
    $content = str_replace('{{phone}}', htmlspecialchars($_POST['phone']), $content);
    $content = str_replace('{{email}}', htmlspecialchars($_POST['email']), $content);
    $content = str_replace('{{message}}', nl2br(htmlspecialchars($_POST['message'])), $content);
	$mail->Body = $content;
    $mail->send();
    msg('메일이 정상적으로 발송되었습니다.', '/formmail');
} catch (Exception $e) {
	msg('오류가 발생하였습니다.');
}