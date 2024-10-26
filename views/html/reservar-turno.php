<?php
session_start();
include("../../config/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $horarioID = mysqli_real_escape_string($conexion, $_POST['horarioID']);
    $usuarioID = $_SESSION['UsuarioID']; // Suponemos que el usuario ya está logueado

    // Insertar el turno en la base de datos
    $query = "INSERT INTO turnos (usuarioID, horarioID, fechaReserva) VALUES ('$usuarioID', '$horarioID', NOW())";

    if (mysqli_query($conexion, $query)) {
        echo "Turno reservado correctamente.";
        header("Location: medico-online.php"); // Redirige a la página principal de turnos
    } else {
        echo "Error al reservar el turno: " . mysqli_error($conexion);
    }
}
?>
