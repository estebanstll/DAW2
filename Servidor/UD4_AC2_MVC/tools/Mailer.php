<?php
namespace Tools;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private static array $config = [];

    private const REMITENTE_EMAIL = 'no-reply@mitienda.com';
    private const REMITENTE_NOMBRE = 'Mi Tienda Online';
    private const ASUNTO_DEFECTO = 'Confirmación de Pedido';

    private static function cargarConfiguracion(): void
    {
        if (!empty(self::$config)) {
            return;
        }

        $rutaEnv = __DIR__ . '/../config/.env';

        if (!file_exists($rutaEnv)) {
            throw new \RuntimeException("Archivo .env no encontrado en: $rutaEnv");
        }

        $archivo = fopen($rutaEnv, 'r');
        if (!$archivo) {
            throw new \RuntimeException("No se pudo abrir el archivo .env");
        }

        while (($linea = fgets($archivo)) !== false) {
            $linea = trim($linea);

            if (empty($linea) || $linea[0] === '#') {
                continue;
            }

            if (strpos($linea, '=') === false) {
                continue;
            }

            [$clave, $valor] = explode('=', $linea, 2);
            $clave = trim($clave);
            $valor = trim($valor);

            self::$config[$clave] = $valor;
        }

        fclose($archivo);
    }

    /**
     * Método simplificado para enviar correos.
     * Solo requiere el destinatario y el mensaje.
     * 
     * @param string $correo  Email del destinatario
     * @param string $mensaje Cuerpo del mensaje (acepta HTML)
     * @return bool           Devuelve true si se envió, false si falló.
     */
    public static function enviar(string $correo, string $mensaje): bool
    {
        self::cargarConfiguracion();

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = self::$config['SMTP_HOST'] ?? 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = self::$config['SMTP_USER'] ?? '';
            $mail->Password   = self::$config['SMTP_PASS'] ?? '';
            $mail->SMTPSecure = self::$config['SMTP_SECURE'] === 'tls' ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = (int)(self::$config['SMTP_PORT'] ?? 587);
            $mail->SMTPDebug  = (int)(self::$config['SMTP_DEBUG'] ?? 0);

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