<?php
session_start();
include("../../config/conexion.php");

// Tiempo límite de inactividad (en segundos, 600 segundos = 10 minutos)
$tiempo_inactividad = 600;

// Verificar si la sesión está activa
if (isset($_SESSION['UsuarioID'])) {
    if (isset($_SESSION['ultimo_movimiento'])) {
        $tiempo_transcurrido = time() - $_SESSION['ultimo_movimiento'];
        
        if ($tiempo_transcurrido > $tiempo_inactividad) {
            session_unset();
            session_destroy();
            header("Location: views/html/login.php");
            exit();
        }
    }
    
    $_SESSION['ultimo_movimiento'] = time();
    header("Location: ../../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $contraseña = $_POST['contraseña'];

    $query = "SELECT * FROM Usuarios WHERE Correo = '$correo'";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) == 1) {
        $usuario = mysqli_fetch_assoc($result);
        if (trim($contraseña) === trim($usuario['Contraseña'])) {
            $_SESSION['UsuarioID'] = $usuario['UsuarioID'];
            $_SESSION['Nombre'] = $usuario['Nombre'];
            $_SESSION['ultimo_movimiento'] = time();
            header("Location: ../../index.php");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "El correo no está registrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión - Sistema de Salud</title>
    <link rel="stylesheet" href="../css/login.css"> <!-- Asegúrate de que la ruta sea correcta -->
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h2>Iniciar sesión</h2>
            <?php if(isset($error)) { echo "<p class='error'>$error</p>"; } ?>
            <form method="POST" action="login.php">
                <input type="email" name="correo" placeholder="Correo" required>
                <input type="password" name="contraseña" placeholder="Contraseña" required>
                <button type="submit">Iniciar sesión</button>
                <button type="button" onclick="window.location.href='registro.php'" class="register-button">Registrarse</button>
            </form>
        </div>
    </div>
</body>
</html>
