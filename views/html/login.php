<?php
session_start();
include("../../config/conexion.php");

// Tiempo límite de inactividad (en segundos, 600 segundos = 10 minutos)
$tiempo_inactividad = 600;

// Verificar si la sesión está activa
if (isset($_SESSION['UsuarioID'])) {
    
    // Verificar si la sesión ha expirado por inactividad
    if (isset($_SESSION['ultimo_movimiento'])) {
        $tiempo_transcurrido = time() - $_SESSION['ultimo_movimiento']; // Calcula el tiempo de inactividad
        
        if ($tiempo_transcurrido > $tiempo_inactividad) {
            // Si el tiempo de inactividad excede el límite, destruir la sesión
            session_unset(); // Limpiar variables de sesión
            session_destroy(); // Destruir la sesión
            header("Location: views/html/login.php"); // Redirigir al login
            exit();
        }
    }
    
    // Actualizar el tiempo del último movimiento
    $_SESSION['ultimo_movimiento'] = time();

    // Si la sesión está activa y no ha expirado, redirigir al inicio
    header("Location: ../../index.php");
    exit();
}

// Si se ha enviado un formulario POST, procesar el login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $contraseña = $_POST['contraseña'];

    // Consultar si el correo existe en la base de datos
    $query = "SELECT * FROM Usuarios WHERE Correo = '$correo'";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) == 1) {
        // Usuario encontrado
        $usuario = mysqli_fetch_assoc($result);

        // Comparar contraseñas en texto plano (usamos trim para evitar espacios adicionales)
        if (trim($contraseña) === trim($usuario['Contraseña'])) {
            // Autenticar al usuario
            $_SESSION['UsuarioID'] = $usuario['UsuarioID'];
            $_SESSION['Nombre'] = $usuario['Nombre'];

            // Inicializar el tiempo del último movimiento
            $_SESSION['ultimo_movimiento'] = time();

            // Redirigir al inicio después de iniciar sesión
            header("Location: ../../index.php");
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "El correo no está registrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión - Sistema de Salud</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Iniciar sesión</h2>
    <form method="POST" action="login.php">
        <input type="email" name="correo" placeholder="Correo" required>
        <input type="password" name="contraseña" placeholder="Contraseña" required>
        <button type="submit">Iniciar sesión</button>
    </form>
</body>
</html>