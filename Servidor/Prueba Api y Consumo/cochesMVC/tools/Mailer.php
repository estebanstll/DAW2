<?php
namespace Tools;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private const SMTP_HOST = 'smtp.gmail.com';
    private const SMTP_USER = 'rubenvarea500@gmail.com';
    private const SMTP_PASS = 'mdeg rmte gjrq ucmq';
    private const SMTP_PORT = 587;
    private const SMTP_SECURE = PHPMailer::ENCRYPTION_STARTTLS;

    private const REMITENTE_EMAIL = 'no-reply@mitienda.com';
    private const REMITENTE_NOMBRE = 'Mi Tienda Online';
    private const ASUNTO_DEFECTO = 'Confirmación de Pedido';

    /**
     * Método simplificado para enviar correos.
     * Solo requiere el destinatario y el mensaje.
     * * @param string $correo  Email del destinatario
     * @param string $mensaje Cuerpo del mensaje (acepta HTML)
     * @return bool           Devuelve true si se envió, false si falló.
     */
    public static function enviar(string $correo, string $mensaje): bool
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = self::SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = self::SMTP_USER;
            $mail->Password   = self::SMTP_PASS;
            $mail->SMTPSecure = self::SMTP_SECURE;
            $mail->Port       = self::SMTP_PORT;

            $mail->CharSet = 'UTF-8';

            $mail->setFrom(self::REMITENTE_EMAIL, self::REMITENTE_NOMBRE);

            $mail->addAddress($correo);

            $mail->isHTML(true);
            $mail->Subject = self::ASUNTO_DEFECTO;
            $mail->Body    = $mensaje;
            $mail->AltBody = strip_tags($mensaje);

            $mail->send();
            return true;

        } catch (Exception $e) {
            return false;
        }
    }
}