<?php
session_start();
session_unset(); // Limpiar todas las variables de sesión
session_destroy(); // Destruir la sesión
header("Location: views/html/login.php"); // Redirigir al formulario de login
exit();
?>
