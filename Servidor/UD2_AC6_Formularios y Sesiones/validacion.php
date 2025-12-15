<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$usuario=$_POST['usuario'];
$contraseña=$_POST['password'];


    if ($usuario === 'admin' && $contraseña === '1234') {
        $_SESSION['usuario_autenticado'] = $usuario;
        header('Location: calculos.php');
    } else {
            header('Location: error.php');

    }
}
?>