<?php
namespace Ol\Tools;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mailer {
    public static function enviarEmail($correo, $asunto, $cuerpo) {
        $mail = new PHPMailer(true);
        try {
            $mail->setFrom('noreply@example.com', 'Intranet Restaurante');
            $mail->addAddress($correo);
            $mail->isHTML(false);
            $mail->Subject = $asunto;
            $mail->Body = $cuerpo;
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log('No se pudo enviar el email: ' . $e->getMessage());
            return false;
        }
    }
}
?>