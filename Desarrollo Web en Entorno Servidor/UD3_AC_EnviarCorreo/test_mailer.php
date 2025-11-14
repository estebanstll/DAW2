<?php
    require 'vendor/autoload.php';
    require_once __DIR__ . '/tools/Mailer.php';
    use Tools\Mailer;

// Cuando se envía el formulario, se ejecuta el envío de correo:
if ($_SERVER["REQUEST_METHOD"] === "POST") {



    $mailer = new Mailer();

    $from    = $_POST['from'] ?? '';
    $to      = $_POST['to'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    $attachmentPath = null;

    if (!empty($_FILES['attachment']['tmp_name'])) {
        $attachmentPath = $_FILES['attachment']['tmp_name'];
    }

    $resultado = $mailer->enviarCorreo(
        $from,
        $to,
        $subject,
        $message,
        null,
        $attachmentPath
    );

    echo "<p><b>Resultado:</b> $resultado</p><hr>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Enviar Correo</title>
</head>
<body>

<h2>Enviar Correo</h2>

<form method="POST" enctype="multipart/form-data">

    <label>Correo desde:</label><br>
    <input type="email" name="from" required><br><br>

    <label>Correo para:</label><br>
    <input type="email" name="to" required><br><br>

    <label>Asunto:</label><br>
    <input type="text" name="subject" required><br><br>

    <label>Mensaje:</label><br>
    <textarea name="message" rows="5" cols="40" required></textarea><br><br>

    <label>Adjunto (opcional):</label><br>
    <input type="file" name="attachment"><br><br>

    <button type="submit">Enviar</button>
</form>

</body>
</html>
