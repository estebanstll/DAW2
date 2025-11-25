<?php

    require "../tools/conexion.php";

    

    $nombre= $_POST['nombre'];
    $tipo= $_POST['tipo'];
    $fecha= $_POST['fecha_nac'];
    $foto= $_FILES['foto'];
    $responsable= $_POST['responsable'];



    if ($foto['error'] !== UPLOAD_ERR_OK) {
        die("Error al subir la foto");
    }

    

    $destino = "C:\Program Files\Ampps\www\Examen1eva\public\img/" . basename($foto['name']);

    if (!move_uploaded_file($foto['tmp_name'], $destino)) {
        die("No se pudo guardar la foto");
    }


    $stmt = $pdo->prepare("INSERT INTO mascotas (nombre, tipo, fecha_nacimiento, foto_url,id_persona) VALUES (:n, :t, :f, :ru, :res)");
    $stmt->execute(['n' => $nombre, 't' => $tipo, 'f' => $fecha, 'ru' => $destino, 'res'=> $responsable]);
    echo "Producto insertado<br>";

    header('Location: ../public/ListadoMascotas.php');




