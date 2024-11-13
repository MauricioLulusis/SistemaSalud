<?php 
session_start();
include("../../config/conexion.php");

$mensaje = ""; // Variable para almacenar el mensaje de estado
$nombrePaciente = isset($_SESSION['Nombre']) ? $_SESSION['Nombre'] : ''; // Inicializar el nombre del paciente

// Alta de turnos (Crear)
if (isset($_POST['crear_turno'])) {
    $medico = mysqli_real_escape_string($conexion, $_POST['medico']);
    $especialidad = mysqli_real_escape_string($conexion, $_POST['especialidad']); // Especialidad seleccionada
    $fecha = mysqli_real_escape_string($conexion, $_POST['fecha']);
    $hora = mysqli_real_escape_string($conexion, $_POST['hora']);
    $usuarioID = $_SESSION['UsuarioID']; // ID del usuario que está logueado
    $nombrePaciente = isset($_POST['nombre_paciente']) ? $_POST['nombre_paciente'] : $_SESSION['Nombre']; // Nombre del paciente

    // Verificar si ya existe un turno para el mismo médico, especialidad, fecha y hora
    $query_verificar = "SELECT COUNT(*) AS total 
                        FROM Turnos 
                        WHERE MedicoID = '$medico' 
                          AND EspecialidadID = '$especialidad'
                          AND Fecha = '$fecha' 
                          AND Hora = '$hora'";
    $result_verificar = mysqli_query($conexion, $query_verificar);
    $row_verificar = mysqli_fetch_assoc($result_verificar);

    if ($row_verificar['total'] > 0) {
        $mensaje = "El médico ya tiene un turno en esta especialidad para la fecha y hora seleccionadas.";
    } else {
        // Insertar el turno solo para la especialidad seleccionada
        $query = "INSERT INTO Turnos (MedicoID, UsuarioID, Fecha, Hora, Estado, Comentarios, EspecialidadID, FechaIngreso) 
                  VALUES ('$medico', '$usuarioID', '$fecha', '$hora', 'Pendiente', '$nombrePaciente', '$especialidad', NOW())";

        if (mysqli_query($conexion, $query)) {
            $mensaje = "Turno creado correctamente."; // Mensaje de éxito
        } else {
            $mensaje = "Error al crear el turno: " . mysqli_error($conexion); // Mensaje de error
        }
    }
}

// Eliminar turno
if (isset($_POST['eliminar_turno'])) {
    $turnoID = mysqli_real_escape_string($conexion, $_POST['turnoID']);
    
    // Consulta para eliminar el turno de la base de datos
    $query_eliminar = "DELETE FROM Turnos WHERE TurnoID = '$turnoID'";

    if (mysqli_query($conexion, $query_eliminar)) {
        $mensaje = "Turno eliminado correctamente."; // Mensaje de éxito
    } else {
        $mensaje = "Error al eliminar el turno: " . mysqli_error($conexion); // Mensaje de error
    }
}

// Modificar turno
if (isset($_POST['modificar_turno'])) {
    $turnoID = mysqli_real_escape_string($conexion, $_POST['turnoID']);
    $nuevaFecha = mysqli_real_escape_string($conexion, $_POST['fecha']);
    $nuevaHora = mysqli_real_escape_string($conexion, $_POST['hora']);
    
    // Consulta para modificar el turno en la base de datos
    $query_modificar = "UPDATE Turnos SET Fecha = '$nuevaFecha', Hora = '$nuevaHora' WHERE TurnoID = '$turnoID'";
    
    if (mysqli_query($conexion, $query_modificar)) {
        $mensaje = "Turno modificado correctamente."; // Mensaje de éxito
    } else {
        $mensaje = "Error al modificar el turno: " . mysqli_error($conexion); // Mensaje de error
    }
}

// Obtener todos los turnos
$query = "SELECT t.TurnoID, m.Nombre AS nombreMedico, e.Nombre AS nombreEspecialidad, t.Fecha, t.Hora, u.Nombre AS nombrePaciente, t.Estado
          FROM Turnos t
          JOIN Medicos m ON t.MedicoID = m.MedicoID
          JOIN MedicoEspecialidad me ON m.MedicoID = me.MedicoID
          JOIN Especialidades e ON me.EspecialidadID = e.EspecialidadID
          JOIN Usuarios u ON t.UsuarioID = u.UsuarioID";
$result = mysqli_query($conexion, $query);

// Obtener los turnos disponibles (horarios no reservados)
$query_disponibles = "
   SELECT DISTINCT 
    hd.HorarioID, 
    m.Nombre AS nombreMedico, 
    e.Nombre AS nombreEspecialidad, 
    hd.Fecha, 
    hd.HoraInicio, 
    hd.HoraFin
FROM 
    HorariosDisponibles hd
JOIN 
    Medicos m ON hd.MedicoID = m.MedicoID
JOIN 
    MedicoEspecialidad me ON m.MedicoID = me.MedicoID
JOIN 
    Especialidades e ON me.EspecialidadID = e.EspecialidadID
WHERE 
    (hd.Fecha, hd.HoraInicio) NOT IN (
        SELECT t.Fecha, t.Hora FROM Turnos t
    )
ORDER BY 
    hd.Fecha, hd.HoraInicio;
";
$result_disponibles = mysqli_query($conexion, $query_disponibles);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médico Online - ABM de Turnos</title>
    <link rel="stylesheet" href="../css/medico-online-style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
</head>

<body>

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
                    <li><a href="../../views/html/historial-turnos.php">Historial de turnos</a></li> 
                    <li><a href="../../views/html/medico-online.php">Médico online</a></li>
                    <li><a href="../../logout.php">Cerrar sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <h3 class="section-title" data-title="Crear un nuevo turno">Crear Turno</h3>
        <!-- Formulario para Crear Turno -->
        <form method="POST" action="medico-online.php">
            <label>Médico:</label>
            <select name="medico" id="medico" required>
                <option value="">Seleccione un médico</option>
                <?php
                // Obtener todos los médicos de la base de datos para el selector
                $query_medicos = "SELECT MedicoID, TRIM(REPLACE(REPLACE(Nombre, 'Dr. ', ''), 'Dra. ', '')) AS Nombre FROM Medicos";
                $result_medicos = mysqli_query($conexion, $query_medicos);
                while ($row_medico = mysqli_fetch_assoc($result_medicos)) {
                    echo "<option value='" . $row_medico['MedicoID'] . "'>" . $row_medico['Nombre'] . "</option>";
                }
                ?>
            </select><br>
            <label>Especialidad:</label>
            <select name="especialidad" id="especialidad" required>
                <!-- Se llenará dinámicamente con JavaScript -->
            </select><br>
            <label>Fecha:</label>
            <input type="date" name="fecha" required><br>
            <label>Hora:</label>
            <input type="time" name="hora" required><br>
            <label>Nombre del Paciente:</label>
            <input type="text" name="nombre_paciente" value="<?php echo $nombrePaciente; ?>" required><br>
            <button type="submit" name="crear_turno">Crear Turno</button>
        </form>

        <h3 class="section-title" data-title="Todos los turnos registrados">Listado de Turnos</h3>
        <!-- Tabla de Turnos -->
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Médico</th>
                    <th>Especialidad</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Paciente</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['TurnoID']; ?></td>
                    <td><?php echo $row['nombreMedico']; ?></td>
                    <td><?php echo $row['nombreEspecialidad']; ?></td>
                    <td><?php echo $row['Fecha']; ?></td>
                    <td><?php echo $row['Hora']; ?></td>
                    <td><?php echo $row['nombrePaciente']; ?></td>
                    <td>
                        <div class="action-buttons">
                            <!-- Formulario para Eliminar Turno -->
                            <form method="POST" action="medico-online.php" style="display:inline;">
                                <input type="hidden" name="turnoID" value="<?php echo $row['TurnoID']; ?>">
                                <button type="submit" name="eliminar_turno" class="btn eliminar-btn">Eliminar</button>
                            </form>

                            <!-- Formulario para Modificar Turno -->
                            <form method="POST" action="medico-online.php" style="display:inline;">
                                <input type="hidden" name="turnoID" value="<?php echo $row['TurnoID']; ?>">
                                <label for="fecha">Nueva Fecha:</label>
                                <input type="date" name="fecha" required>
                                <label for="hora">Nueva Hora:</label>
                                <input type="time" name="hora" required>
                                <button type="submit" name="modificar_turno" class="btn modificar-btn">Modificar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3 class="section-title" data-title="Horarios disponibles">Turnos Disponibles</h3>
        <!-- Tabla de Turnos Disponibles -->
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Médico</th>
                    <th>Especialidad</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row_disponibles = mysqli_fetch_assoc($result_disponibles)): ?>
                <tr>
                    <td><?php echo $row_disponibles['Fecha']; ?></td>
                    <td><?php echo $row_disponibles['HoraInicio']; ?></td>
                    <td><?php echo $row_disponibles['HoraFin']; ?></td>
                    <td><?php echo $row_disponibles['nombreMedico']; ?></td>
                    <td><?php echo $row_disponibles['nombreEspecialidad']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <footer class="footer">
        <div class="footer-content container">
            <div class="link">
                <a href="#" class="medicina-integral">Medicina Integral</a>
            </div>
            <div class="link">
                <ul>
                    <li><a href="../../index.php">Inicio</a></li>
                    <li><a href="../../index.php">Nosotros</a></li>
                    <li><a href="../../views/html/chat-online.php">Servicios</a></li>
                    <li><a href="../../views/html/medico-online.php">Médico online</a></li>
                    <li><a href="../../index.php">Contacto</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script>
        // Animar los títulos al cargar la página
        document.addEventListener("DOMContentLoaded", () => {
            const titles = document.querySelectorAll(".section-title");

            titles.forEach((title) => {
                setTimeout(() => {
                    title.classList.add("visible");
                }, 200);
            });
        });

        // Cargar las especialidades del médico seleccionado
        $('#medico').on('change', function() {
            var medicoID = $(this).val();
            if (medicoID) {
                $.ajax({
                    url: 'obtener_especialidades.php',
                    type: 'POST',
                    data: { medico_id: medicoID },
                    dataType: 'json',
                    success: function(response) {
                        $('#especialidad').empty();
                        $('#especialidad').append('<option value="">Seleccione una especialidad</option>');
                        if (response.length > 0) {
                            $.each(response, function(index, especialidad) {
                                $('#especialidad').append('<option value="' + especialidad['EspecialidadID'] + '">' + especialidad['Nombre'] + '</option>');
                            });
                        } else {
                            $('#especialidad').append('<option value="">No hay especialidades disponibles</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error en la solicitud de especialidades: ", error);
                    }
                });
            } else {
                $('#especialidad').empty();
                $('#especialidad').append('<option value="">Seleccione un médico primero</option>');
            }
        });

        // Mostrar la notificación de SweetAlert después de una operación
        <?php if ($mensaje != ""): ?>
            Swal.fire({
                title: '¡Notificación!',
                text: '<?php echo $mensaje; ?>',
                icon: '<?php echo strpos($mensaje, "Error") === false ? "success" : "error"; ?>',
                confirmButtonText: 'Aceptar'
            });
        <?php endif; ?>
    </script>

</body>

</html>

Este es mi medico online 