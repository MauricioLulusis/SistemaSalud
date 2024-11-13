<?php
session_start();
include("../../config/conexion.php"); // Ajustar la ruta a la conexión

// Manejar el inicio de sesión al enviar el formulario
$mensaje = ""; // Variable para mensajes de estado

if (isset($_POST['send'])) {
    $correo = mysqli_real_escape_string($conexion, $_POST['username']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);

    // Consulta a la base de datos para verificar el correo y la contraseña
    $consulta = "SELECT * FROM usuarios WHERE Correo = '$correo' AND Contraseña = '$password'";
    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado) == 1) {
        // Credenciales correctas
        $usuario = mysqli_fetch_assoc($resultado);
        $_SESSION['UsuarioID'] = $usuario['UsuarioID']; // Puedes usar el ID específico del usuario
        $mensaje = "success"; // Se establece el mensaje de éxito para el script JavaScript
    } else {
        // Credenciales incorrectas
        $mensaje = "error"; // Se establece el mensaje de error para el script JavaScript
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Salud</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/login.css">
    <style>
        /* Estilo para el cartel de cargando */
        .loading-overlay {
            display: none; /* Oculto por defecto */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .loading-message {
            color: #fff;
            font-size: 1.5em;
            font-weight: bold;
        }
    </style>
    <script>
        // Mostrar el mensaje de cargando
        function mostrarLoading() {
            document.getElementById('loading-overlay').style.display = 'flex';
        }
    </script>
</head>

<body>
    <!-- Mensaje de carga -->
    <div class="loading-overlay" id="loading-overlay">
        <div class="loading-message">
            <i class="fas fa-spinner fa-spin"></i> Cargando, por favor espere...
        </div>
    </div>

    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="" method="post" onsubmit="mostrarLoading()">
            <div class="input-group">
                <input type="text" name="username" placeholder="Correo" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Contraseña" required>
            </div>
            <div class="button-container">
                <button type="submit" name="send">Iniciar Sesión</button>
                <button type="button" class="register-button" onclick="window.location.href='registro.php'">Registrarse</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Mostrar SweetAlert si se produjo un intento de inicio de sesión
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($mensaje == "success"): ?>
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Inicio de sesión exitoso. Redirigiendo...',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didClose: () => {
                        window.location.href = "../../index.php";
                    }
                });
            <?php elseif ($mensaje == "error"): ?>
                Swal.fire({
                    title: '¡Error!',
                    text: 'Usuario o contraseña incorrectos.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar',
                    allowOutsideClick: false
                });
            <?php endif; ?>
        });
    </script>

</body>

</html>