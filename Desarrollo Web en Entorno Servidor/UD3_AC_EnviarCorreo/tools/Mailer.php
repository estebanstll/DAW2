<?php
namespace Tools;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->configurarServidor();
    }

    private function configurarServidor()
    {
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.gmail.com';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'bazeesteban@gmail.com'; 
        $this->mailer->Password = 'clhj qwnq ewfi pszq';
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = 587;
    }

    public function enviarCorreo($remitente, $destinatario, $asunto, $mensaje, $cc = null, $adjunto = null)
    {
        try {
            $this->mailer->setFrom($remitente);
            $this->mailer->addAddress($destinatario);

            if ($cc) {
                $this->mailer->addCC($cc);
            }

            if ($adjunto) {
                $this->mailer->addAttachment($adjunto);
            }

            $this->mailer->isHTML(true);
            $this->mailer->Subject = $asunto;
            $this->mailer->Body = $mensaje;

            $this->mailer->send();
            return 'Correo enviado correctamente.';
        } catch (Exception $e) {
            return 'Error: ' . $this->mailer->ErrorInfo;
        }
    }
}
