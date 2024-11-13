<?php
session_start(); // Inicia la sesión

include("config/conexion.php"); // Incluir la conexión a la base de datos

if (isset($_POST['send'])) {
    if (
        strlen($_POST['name']) >= 1 &&
        strlen($_POST['phone']) >= 1 &&
        strlen($_POST['email']) >= 1 &&
        strlen($_POST['message']) >= 1
    ) {
        $name = trim($_POST['name']);
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $message = trim($_POST['message']);

        $consulta = "INSERT INTO formulario(nombre, telefono, email, mensaje) 
                     VALUES ('$name', '$phone', '$email', '$message')";

        $resultado = mysqli_query($conexion, $consulta);

        if ($resultado) {
            header("Location: index.php?mensaje=success");
            exit();
        } else {
            header("Location: index.php?mensaje=error");
            exit();
        }
    } else {
        header("Location: index.php?mensaje=incomplete");
        exit();
    }
}
?>
