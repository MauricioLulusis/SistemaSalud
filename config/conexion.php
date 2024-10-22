<?php
$conexion = mysqli_connect("localhost", "root", "", "SistemaSalud");

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}
?>
