<?php
require 'vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'bazeesteban@gmail.com'; 
    $mail->Password = 'clhj qwnq ewfi pszq'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('bazeesteban@gmail.com', 'Esteban Santolalla');
    $mail->addAddress('rubenvarea500@gmail.com', 'Ruben');

    $mail->addAttachment('src/laPereza.pdf'); 

    $mail->isHTML(true);
    $mail->Subject = 'Probando probando';
    $mail->Body    = 'prueba';

     $mail->send();
    echo 'Mensaje enviado correctamente';
} catch (Exception $e) {
    echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
}
?>
