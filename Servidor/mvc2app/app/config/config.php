<?php

//Configuración acceso a base de datos
define('DB_HOST', 'localhost'); //tu servidor de BD.
define('DB_USUARIO', 'root');
define('DB_PASSWORD', 'mysql');
define('DB_NOMBRE', 'test'); // Tu base de datos



//Ruta de la aplicación. /app o /src
define('RUTA_APP', dirname(dirname(__FILE__)));

//Ruta url Ejemplo: http://localhost/mvc2app
//define ('RUTA_URL', '_URL_');
define('RUTA_URL', 'http://localhost/mvc2app/public');

//define ('NOMBRESITIO', '_NOMBRE_SITIO');
define('NOMBRESITIO', 'ED 23 - 24');

// Función helper para generar URLs
if (!function_exists('url')) {
    function url($ruta = '')
    {
        if (empty($ruta)) {
            return RUTA_URL . '/index.php';
        }
        return RUTA_URL . '/index.php?url=' . $ruta;
    }
}

// Cargar archivo INI si es necesario.
//$config = parse_ini_file(RUTA_APP . '/config/config.ini', true);

// Otras configuraciones iniciales pueden ir aquí