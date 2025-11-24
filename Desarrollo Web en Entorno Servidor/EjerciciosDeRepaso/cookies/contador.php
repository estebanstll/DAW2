<?php
if (isset($_COOKIE['visitas'])) {
    $visitas = $_COOKIE['visitas'] + 1;
} else {
    $visitas = 1;
}

setcookie("visitas", $visitas, time() + 3600);

echo "Has visitado esta página $visitas veces.";
?>
