<?php

namespace App\Controllers;

use Core\Controller;
use Tools\Mailer;
use Tools\Hash;

class UsuariosController extends Controller
{
    public function index(): void
    {
        $this->vista("usuarios/index");
    }

    public function autenticar(): void
    {
        $email = $_POST["usuario"] ?? "";
        $clave = $_POST["password"] ?? "";

        try {
            $validado = \App\Models\Usuario::validarCredenciales($email, $clave);
        } catch (\Throwable $e) {
            $this->vista("usuarios/index", ["error" => "Error en el servidor: " . $e->getMessage()]);
            return;
        }

        if ($validado) {
            $_SESSION["usuarioAutenticado"] = $email;
            header("Location: " . BASE_URL . "categorias/index");
            exit;
        }

        $this->vista("usuarios/index", ["error" => "Credenciales no válidas"]);
    }

    public function cerrarSesion(): void
    {
        $this->vista("usuarios/logout");
    }

    /**
     * Método logout - alias de cerrarSesion
     */
    public function logout(): void
    {
        $this->cerrarSesion();
    }

    /**
     * Muestra la página de registro
     */
    public function registro(): void
    {
        $this->vista("usuarios/registro");
    }

    /**
     * Procesa el registro de un nuevo usuario
     */
    public function procesarRegistro(): void
    {
        $email = $_POST["email"] ?? "";
        $contrasena = $_POST["password"] ?? "";
        $confirmar = $_POST["password_confirm"] ?? "";
        $domicilio = $_POST["domicilio"] ?? "";

        // Validaciones
        if (empty($email) || empty($contrasena) || empty($domicilio)) {
            $this->vista("usuarios/registro", ["error" => "Todos los campos son obligatorios"]);
            return;
        }

        if ($contrasena !== $confirmar) {
            $this->vista("usuarios/registro", ["error" => "Las contraseñas no coinciden"]);
            return;
        }

        if (strlen($contrasena) < 6) {
            $this->vista("usuarios/registro", ["error" => "La contraseña debe tener al menos 6 caracteres"]);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->vista("usuarios/registro", ["error" => "El email no es válido"]);
            return;
        }

        // Intentar registrar
        $usuario = new \App\Models\Usuario();
        if ($usuario->registrar($email, $contrasena, $domicilio)) {
            // Redirigir al login con mensaje de éxito
            header("Location: " . BASE_URL . "usuarios/index?registro=exito", true, 303);
            exit;
        } else {
            $this->vista("usuarios/registro", ["error" => "Este email ya está registrado. Intenta con otro."]);
        }
    }

    /**
     * Muestra la página de recuperación de contraseña
     */
    public function recuperarContrasena(): void
    {
        $this->vista("usuarios/recuperar");
    }

    /**
     * Procesa la solicitud de recuperación de contraseña
     */
    public function procesarRecuperacion(): void
    {
        $email = $_POST["email"] ?? "";

        if (empty($email)) {
            $this->vista("usuarios/recuperar", ["error" => "El email es obligatorio"]);
            return;
        }

        $usuario = \App\Models\Usuario::obtenerPorEmail($email);

        if (!$usuario) {
            // No mostramos que el email no existe por seguridad, pero indicamos que se envió
            $this->vista("usuarios/recuperar", ["exito" => "Si el email existe en nuestra base de datos, recibirás un enlace para restablecer tu contraseña."]);
            return;
        }

        // Generar enlace con hash del ID
        $enlace = BASE_URL . "usuarios/restablecer/" . Hash::encode($usuario->obtenerId());

        // Crear mensaje con HTML
        $mensaje = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f5f5f5; }
                .header { background-color: #ff6b35; color: white; padding: 20px; text-align: center; border-radius: 5px; }
                .content { background-color: white; padding: 20px; margin-top: 20px; border-radius: 5px; }
                .button { display: inline-block; background-color: #ff6b35; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
                .footer { color: #666; font-size: 12px; margin-top: 20px; text-align: center; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>FoodHub - Recuperar Contraseña</h1>
                </div>
                <div class='content'>
                    <p>Hola $email,</p>
                    <p>Hemos recibido una solicitud para restablecer tu contraseña. Haz clic en el enlace a continuación:</p>
                    <a href='$enlace' class='button'>Restablecer Contraseña</a>
                    <p>Este enlace expirará en 24 horas.</p>
                    <p>Si no solicitaste este cambio, ignora este email.</p>
                </div>
                <div class='footer'>
                    <p>&copy; 2026 FoodHub. Todos los derechos reservados.</p>
                </div>
            </div>
        </body>
        </html>";

        // Enviar email
        Mailer::enviar($email, $mensaje);

        $this->vista("usuarios/recuperar", ["exito" => "Se ha enviado un enlace de recuperación a tu email. Por favor, revisa tu bandeja de entrada."]);
    }

    /**
     * Muestra el formulario para restablecer contraseña
     */
    public function restablecer($usuarioHash): void
    {
        // Decodificar el hash
        $usuarioId = Hash::decodeFromDatabase($usuarioHash, 'restaurantes', 'CodRes');

        if ($usuarioId === null) {
            die('Error: Enlace inválido o expirado');
        }

        // Verificar que el usuario existe
        $usuario = \App\Models\Usuario::obtenerPorId($usuarioId);
        if (!$usuario) {
            die('Error: Usuario no encontrado');
        }

        $this->vista("usuarios/restablecer", ["usuarioHash" => $usuarioHash, "email" => $usuario->obtenerEmail()]);
    }

    /**
     * Procesa el restablecimiento de contraseña
     */
    public function procesarRestablecer(): void
    {
        $usuarioHash = $_POST["usuario_hash"] ?? "";
        $nuevaContrasena = $_POST["password"] ?? "";
        $confirmar = $_POST["password_confirm"] ?? "";

        if (empty($usuarioHash) || empty($nuevaContrasena) || empty($confirmar)) {
            die('Error: Datos incompletos');
        }

        if ($nuevaContrasena !== $confirmar) {
            die('Error: Las contraseñas no coinciden');
        }

        if (strlen($nuevaContrasena) < 6) {
            die('Error: La contraseña debe tener al menos 6 caracteres');
        }

        // Decodificar el hash
        $usuarioId = Hash::decodeFromDatabase($usuarioHash, 'restaurantes', 'CodRes');

        if ($usuarioId === null) {
            die('Error: Enlace inválido');
        }

        $usuario = \App\Models\Usuario::obtenerPorId($usuarioId);
        if (!$usuario) {
            die('Error: Usuario no encontrado');
        }

        // Actualizar contraseña
        if (\App\Models\Usuario::actualizarContrasena($usuarioId, $nuevaContrasena)) {
            // Enviar email de confirmación
            $mensaje = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f5f5f5; }
                    .header { background-color: #2ecc71; color: white; padding: 20px; text-align: center; border-radius: 5px; }
                    .content { background-color: white; padding: 20px; margin-top: 20px; border-radius: 5px; }
                    .footer { color: #666; font-size: 12px; margin-top: 20px; text-align: center; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>FoodHub - Contraseña Actualizada</h1>
                    </div>
                    <div class='content'>
                        <p>Tu contraseña ha sido restablecida correctamente.</p>
                        <p>Ya puedes iniciar sesión con tu nueva contraseña.</p>
                        <p>Si no realizaste este cambio, contacta con soporte inmediatamente.</p>
                    </div>
                    <div class='footer'>
                        <p>&copy; 2026 FoodHub. Todos los derechos reservados.</p>
                    </div>
                </div>
            </body>
            </html>";

            Mailer::enviar($usuario->obtenerEmail(), $mensaje);

            $this->vista("usuarios/restablecerExito");
        } else {
            die('Error: No se pudo actualizar la contraseña');
        }
    }
}
