<?php
require 'vendor/autoload.php';
require_once __DIR__ . '/tools/Mailer.php';
use Tools\Mailer;

$mailer = new Mailer();

echo $mailer->enviarCorreo(
    'bazeesteban@gmail.com',              
    'rubenvarea500@gmail.com',          
    'Super importante',    
    'testeo, prometeo.', 
    null,                              
    'src/laPereza.pdf'   
    )
?>
