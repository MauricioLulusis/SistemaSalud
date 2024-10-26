<?php
session_start();
include("../../config/conexion.php");

// Verificar si la conexión es exitosa
if (!$conexion) {
    die("Error en la conexión a la base de datos: " . mysqli_connect_error());
}

// Verificar si se ha enviado el formulario de registro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $contraseña = mysqli_real_escape_string($conexion, $_POST['contraseña']);
    $confirmar_contraseña = mysqli_real_escape_string($conexion, $_POST['confirmar_contraseña']);
    $fecha_ingreso = date("Y-m-d H:i:s");

    // Verificar que las contraseñas coincidan
    if ($contraseña !== $confirmar_contraseña) {
        echo "Error: Las contraseñas no coinciden.";
        exit();
    }

    // Verificar si el correo ya existe
    $query = "SELECT * FROM Usuarios WHERE Correo = '$correo'";
    $result = mysqli_query($conexion, $query);

    if (!$result) {
        die("Error al ejecutar la consulta de verificación: " . mysqli_error($conexion));
    } elseif (mysqli_num_rows($result) > 0) {
        echo "Error: Este correo ya está registrado.";
        exit();
    } else {
        // Insertar el nuevo usuario en la tabla, incluyendo Nombre, Correo, Contraseña y FechaIngreso
        $insert_query = "INSERT INTO Usuarios (Nombre, Correo, Contraseña, FechaIngreso) VALUES ('$nombre', '$correo', '$contraseña', '$fecha_ingreso')";
        
        if (mysqli_query($conexion, $insert_query)) {
            echo "Registro exitoso. Ahora puedes iniciar sesión.";
            header("Location: login.php");
            exit();
        } else {
            echo "Error al registrar el usuario: " . mysqli_error($conexion);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Sistema de Salud</title>
    <link rel="stylesheet" href="../css/login.css"> <!-- Asegúrate de que la ruta sea correcta -->
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h2>Registro</h2>
            <form method="POST" action="">
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="email" name="correo" placeholder="Email" required>
                <input type="password" name="contraseña" placeholder="Contraseña" required>
                <input type="password" name="confirmar_contraseña" placeholder="Confirmar Contraseña" required>
                <button type="submit">Registrarse</button>
            </form>
        </div>
    </div>
</body>
</html>
