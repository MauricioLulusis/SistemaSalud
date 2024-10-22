<?php
include("../config/conexion.php");

// Registrar nuevo usuario
function registrarUsuario($nombre, $correo, $contraseña, $telefono) {
    global $conexion;
    $hashed_password = password_hash($contraseña, PASSWORD_DEFAULT);

    $query = "INSERT INTO Usuarios (Nombre, Correo, Contraseña, Telefono) VALUES ('$nombre', '$correo', '$hashed_password', '$telefono')";
    return mysqli_query($conexion, $query);
}

// Ejemplo de uso:
// registrarUsuario('Nuevo Usuario', 'nuevo@example.com', 'password123', '123456789');
?>
