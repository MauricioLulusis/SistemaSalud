<?php
session_start();
include("../../config/conexion.php");

// Consultar historial de turnos
$query_historial = "
    SELECT h.HistorialID, t.TurnoID, u.Nombre AS nombreUsuario, m.Nombre AS nombreMedico, 
           h.FechaTurno, h.EstadoTurno, h.Comentario, h.FechaIngreso
    FROM HistorialTurnos h
    JOIN Turnos t ON h.TurnoID = t.TurnoID
    JOIN Usuarios u ON t.UsuarioID = u.UsuarioID
    JOIN Medicos m ON t.MedicoID = m.MedicoID
    ORDER BY h.FechaIngreso DESC";
$result_historial = mysqli_query($conexion, $query_historial);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Turnos</title>
    <link rel="stylesheet" href="../css/medico-online-style.css">
</head>
<body>

    <!-- Reutilizar el header existente -->
    <header class="header">
        <div class="menu container">
            <a href="#" class="medicina-integral">Medicina Integral</a>
            <input type="checkbox" id="menu" />
            <label for="menu">
                <img src="../../images/menu.png" class="menu-icono" alt="menu">
            </label>
            <nav class="navbar">
                <ul>
                    <li><a href="../../index.php">Inicio</a></li>
                    <li><a href="../../views/html/chat-online.php">Chat online</a></li>
                    <li><a href="historial-turnos.php">Historial de Turnos</a></li>
                    <li><a href="../../views/html/medico-online.php">Médico online</a></li>
                    <li><a href="../../logout.php">Cerrar sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <h2>Historial de Turnos</h2>

        <!-- Tabla de Historial de Turnos -->
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID Historial</th>
                    <th>ID Turno</th>
                    <th>Usuario</th>
                    <th>Médico</th>
                    <th>Fecha del Turno</th>
                    <th>Estado</th>
                    <th>Comentario</th>
                    <th>Fecha de Ingreso</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row_historial = mysqli_fetch_assoc($result_historial)): ?>
                <tr>
                    <td><?php echo $row_historial['HistorialID']; ?></td>
                    <td><?php echo $row_historial['TurnoID']; ?></td>
                    <td><?php echo $row_historial['nombreUsuario']; ?></td>
                    <td><?php echo $row_historial['nombreMedico']; ?></td>
                    <td><?php echo $row_historial['FechaTurno']; ?></td>
                    <td><?php echo $row_historial['EstadoTurno']; ?></td>
                    <td><?php echo $row_historial['Comentario']; ?></td>
                    <td><?php echo $row_historial['FechaIngreso']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Reutilizar el footer existente -->
    <footer class="footer">
        <div class="footer-content container">
            <div class="link">
                <a href="#" class="medicina-integral">Medicina Integral</a>
            </div>
            <div class="link">
            <ul>
                    <li><a href="../../index.php">Inicio</a></li>
                    <li><a href="../../index.php">Nosotros</a></li>
                    <li><a href="../../views/html/chat-online.php">Chat online</a></li>
                    <li><a href="../../views/html/medico-online.php">Médico online</a></li>
                </ul>
            </div>
        </div>
    </footer>

</body>
</html>
