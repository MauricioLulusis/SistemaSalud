<?php
session_start();
if (!isset($_SESSION['UsuarioID'])) {
    header("Location: views/html/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control - Sistema de Salud</title>
    <link rel="stylesheet" href="views/css/style.css">
</head>
<body>
    <header>
        <h1>Bienvenido, <?php echo $_SESSION['Nombre']; ?>!</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="views/html/medico-online.html">Médico Online</a></li>
                <li><a href="views/html/nosotros.html">Nosotros</a></li>
                <li><a href="views/html/contacto.html">Contacto</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Panel de Usuario</h2>
        <p>Este es el panel de control donde puedes gestionar tus turnos, ver historial médico, y más.</p>
        <p>Selecciona una opción del menú de navegación para continuar.</p>
    </main>

    <footer>
        <a href="logout.php">Cerrar sesión</a>
    </footer>
</body>
</html>
