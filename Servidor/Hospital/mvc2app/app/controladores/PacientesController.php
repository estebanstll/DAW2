<?php

use App\Models\Paciente;

// Cargar manualmente la clase medicos
require_once __DIR__.'/../modelos/Paciente.php';

class PacientesController extends Controlador{


public function index(){
    $pacientes = Paciente::getAll();

    $this->vista("pacientes/index",["Pacientes"=>$pacientes]);

}

public function verUnico($id){

 $pacientes = Paciente::getporID($id);
    $this->vista("pacientes/pacienteDetalles",["Pacientes"=>$pacientes]);


}

public function eliminar($id){

    $paciente= Paciente::deleteId($id);
        $this->index();

}


public function form($id){

 $pacientes = Paciente::getporID($id);
    $this->vista("pacientes/formularioPaciente",["Pacientes"=>$pacientes]);

    // Si el formulario fue enviado por POST, procesar la actualización
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postId = $_POST['id'] ?? $id;
        $medico_id = $_POST['medico_id'] ?? null;
        $nombre = $_POST['nombre'] ?? null;
        $motivo = $_POST['motivo'] ?? null;

        $payload = [
            'medico_id' => $medico_id,
            'nombre' => $nombre,
            'motivo' => $motivo,
        ];

        $resultado = Paciente::update($postId, $payload);

        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        $_SESSION['flash'] = $resultado;

        // Redirigir al listado de pacientes
        header('Location: ' . BASE_URL . 'PacientesController');
        exit;
    }

    $pacientes = Paciente::getporID($id);
    $this->vista("pacientes/formularioPaciente", ["Pacientes" => $pacientes]);

}

public function actualizar($id,$payload){

     $pacientes = Paciente::update($id,$payload);
             $this->index();

}
}