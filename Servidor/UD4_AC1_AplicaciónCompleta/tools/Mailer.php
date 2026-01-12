<?php

namespace Esteban\Ud4ac1\Tools;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private PHPMailer $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->cargarEntornoDesdeEnv();
        $this->configurarServidor();
    }

    /**
     * Carga variables de entorno desde config/.env si existen.
     * Formato: KEY=VALUE, admite líneas en blanco y comentarios que empiezan con '#'.
     */
    private function cargarEntornoDesdeEnv(): void
    {
        $envPath = __DIR__ . '/../config/.env';
        if (!is_readable($envPath)) {
            return;
        }
        $contenido = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($contenido === false) {
            return;
        }
        foreach ($contenido as $linea) {
            $linea = trim($linea);
            if ($linea === '' || str_starts_with($linea, '#')) {
                continue;
            }
            $partes = explode('=', $linea, 2);
            if (count($partes) !== 2) {
                continue;
            }
            $clave = trim($partes[0]);
            $valor = trim($partes[1]);
            // Quitar comillas envolventes si las hay
            if ((str_starts_with($valor, '"') && str_ends_with($valor, '"')) ||
                (str_starts_with($valor, "'") && str_ends_with($valor, "'"))) {
                $valor = substr($valor, 1, -1);
            }
            if ($clave !== '') {
                $_ENV[$clave] = $valor;
                // putenv para que getenv también lo vea
                @putenv($clave . '=' . $valor);
            }
        }
    }

    private function configurarServidor(): void
    {
        $this->mailer->isSMTP();
        $this->mailer->SMTPAuth = true;

        // Cargar parámetros desde variables de entorno (ajústalos en config/.env)
        $smtpHost = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
        $smtpUser = getenv('SMTP_USER') ?: 'bazeesteban@gmail.com';
        $smtpPass = getenv('SMTP_PASS') ?: '';
        $smtpPort = (int)(getenv('SMTP_PORT') ?: 587);
        $smtpSecure = strtolower((string)(getenv('SMTP_SECURE') ?: 'tls'));
        $smtpDebug = (int)(getenv('SMTP_DEBUG') ?: 0);

        $this->mailer->Host = $smtpHost;
        $this->mailer->Username = $smtpUser;
        $this->mailer->Password = $smtpPass;
        $this->mailer->Port = $smtpPort > 0 ? $smtpPort : 587;

        if ($smtpSecure === 'ssl' || $smtpSecure === 'smtps') {
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            if ($this->mailer->Port === 587) { // si no se ajustó, por defecto 465 para SSL
                $this->mailer->Port = 465;
            }
        } else {
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }

        if ($smtpDebug > 0) {
            $this->mailer->SMTPDebug = $smtpDebug; // 1,2,3 o 4
            $this->mailer->Debugoutput = 'error_log';
        }

        $this->mailer->CharSet = 'UTF-8';

        $this->mailer->setFrom($smtpUser, 'Tienda');

        if ($this->mailer->Password === '') {
            throw new \RuntimeException('SMTP_PASS no está configurado. Añádelo al archivo config/.env con la contraseña de aplicación de Gmail.');
        }
    }

    public function enviarCorreo(string $destinatario, string $asunto, string $mensaje): void
    {
        $this->mailer->clearAddresses();
        $this->mailer->addAddress($destinatario);

        $this->mailer->isHTML(true);
        $this->mailer->Subject = $asunto;
        $this->mailer->Body = $mensaje;

        try {
            $this->mailer->send();
        } catch (Exception $e) {
            error_log('Mailer error: ' . $this->mailer->ErrorInfo);
            throw new \RuntimeException('No se pudo enviar el correo: ' . $this->mailer->ErrorInfo);
        }
    }
}
