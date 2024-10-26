<?php
include("../../config/conexion.php");

if (isset($_POST['medico_id'])) {
    $medicoID = mysqli_real_escape_string($conexion, $_POST['medico_id']);

    // Obtener las especialidades del médico
    $query_especialidades = "SELECT e.EspecialidadID, e.Nombre 
                             FROM Especialidades e 
                             JOIN MedicoEspecialidad me ON e.EspecialidadID = me.EspecialidadID 
                             WHERE me.MedicoID = '$medicoID'";

    $result_especialidades = mysqli_query($conexion, $query_especialidades);

    $especialidades = array();
    while ($row = mysqli_fetch_assoc($result_especialidades)) {
        $especialidades[] = array(
            'EspecialidadID' => $row['EspecialidadID'],
            'Nombre' => $row['Nombre']
        );
    }

    // Devolver el array en formato JSON
    echo json_encode($especialidades);
} else {
    echo json_encode(array('error' => 'No se ha proporcionado medico_id'));
}
?>
