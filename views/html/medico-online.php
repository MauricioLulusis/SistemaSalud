<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médico Online</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../views/css/style.css">
    <link rel="stylesheet" href="../../views/css/medico-online-style.css">
</head>

<body>
    <header class="header">
        <div class="menu container">
            <a href="index.html" class="medicina-integral">Medicina Integral</a>
            <input type="checkbox" id="menu" aria-label="Abrir menú" />
            <label for="menu">
                <img src="images/menu.png" class="menu-icono" alt="Ícono de menú">
            </label>
            <nav class="navbar">
                <ul>
                    <li><a href="../../index.html">Inicio</a></li>
                    <li><a href="#">Nosotros</a></li>
                    <li><a href="#">Médico Online</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="medico-online container">
        <h2>Sacar Turno</h2>
        <form class="turnero-form" id="turnero-form">
            <div class="form-group">
                <label for="medico">Médico:</label>
                <select id="medico" name="medico">
                    <option value="Dr. Juan Pérez - Cardiología">Dr. Juan Pérez - Cardiología</option>
                    <option value="Dra. María Gómez - Pediatría">Dra. María Gómez - Pediatría</option>
                    <option value="Dr. Luis Rodríguez - Dermatología">Dr. Luis Rodríguez - Dermatología</option>
                    <option value="Dra. Ana López - Ginecología">Dra. Ana López - Ginecología</option>
                    <option value="Dr. Carlos Fernández - Neurología">Dr. Carlos Fernández - Neurología</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha">
            </div>
            <div class="form-group">
                <label for="hora">Hora:</label>
                <input type="time" id="hora" name="hora">
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Tu nombre">
            </div>
            <button type="submit" class="btn">Reservar Turno</button>
        </form>

        <!-- Campo de búsqueda mejorado -->
        <h2>Buscar Turno por Médico</h2>
        <div class="search-container">
            <input type="text" id="search" placeholder="Buscar médico..." onkeyup="buscarTurno()">
        </div>

        <h2>Listado de Turnos Disponibles</h2>
        <table class="styled-table" id="turnos-table">
            <thead>
                <tr>
                    <th>Médico</th>
                    <th>Especialidad</th>
                    <th>Día</th>
                    <th>Hora</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="turnos-body">
                <!-- Turnos agregados dinámicamente aquí -->
            </tbody>
        </table>
    </section>

    <footer class="footer">
        <div class="footer-content container">
            <div class="link">
                <a href="index.php" class="medicina-integral">Medicina Integral</a>
            </div>
            <div class="link">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="nosotros.php">Nosotros</a></li>
                    <li><a href="servicios.php">Servicios</a></li>
                    <li><a href="contacto.php">Contacto</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script>
        // Turnos disponibles por defecto
        let turnos = [
            { medico: "Dr. Juan Pérez - Cardiología", fecha: "2024-09-25", hora: "10:00", nombre: "Pedro González" },
            { medico: "Dra. María Gómez - Pediatría", fecha: "2024-09-26", hora: "11:30", nombre: "Ana López" },
            { medico: "Dr. Luis Rodríguez - Dermatología", fecha: "2024-09-27", hora: "14:00", nombre: "Carlos Fernández" },
            { medico: "Dra. Ana López - Ginecología", fecha: "2024-09-28", hora: "09:00", nombre: "María Rodríguez" },
            { medico: "Dr. Carlos Fernández - Neurología", fecha: "2024-09-29", hora: "16:00", nombre: "Juan Pérez" },
            { medico: "Dr. Juan Pérez - Cardiología", fecha: "2024-09-30", hora: "10:00", nombre: "Sofía García" },
            { medico: "Dra. María Gómez - Pediatría", fecha: "2024-10-01", hora: "11:30", nombre: "Miguel Martín" },
            { medico: "Dr. Luis Rodríguez - Dermatología", fecha: "2024-10-02", hora: "14:00", nombre: "Laura Gómez" },
            { medico: "Dr. Juan Pérez - Cardiología", fecha: "2024-10-03", hora: "10:30", nombre: "Gonzalo Herrera" },
            { medico: "Dra. María Gómez - Pediatría", fecha: "2024-10-04", hora: "09:00", nombre: "Sara Martínez" },
            { medico: "Dr. Luis Rodríguez - Dermatología", fecha: "2024-10-05", hora: "12:00", nombre: "Patricia López" },
            { medico: "Dra. Ana López - Ginecología", fecha: "2024-10-06", hora: "15:00", nombre: "Diego Rivera" },
            { medico: "Dr. Carlos Fernández - Neurología", fecha: "2024-10-07", hora: "09:30", nombre: "Rosa Maldonado" },
            { medico: "Dr. Juan Pérez - Cardiología", fecha: "2024-10-08", hora: "10:00", nombre: "Federico Méndez" },
            { medico: "Dra. María Gómez - Pediatría", fecha: "2024-10-09", hora: "11:30", nombre: "Lucía Navarro" },
            { medico: "Dr. Luis Rodríguez - Dermatología", fecha: "2024-10-10", hora: "13:00", nombre: "Roberto Sosa" },
            { medico: "Dra. Ana López - Ginecología", fecha: "2024-10-11", hora: "09:00", nombre: "Valeria Gómez" },
            { medico: "Dr. Carlos Fernández - Neurología", fecha: "2024-10-12", hora: "16:30", nombre: "Julio Peña" },
            { medico: "Dr. Juan Pérez - Cardiología", fecha: "2024-10-13", hora: "10:00", nombre: "Andrea Domínguez" },
            { medico: "Dr. Federico Castro - Traumatología", fecha: "2024-10-14", hora: "09:00", nombre: "Ricardo Alonso" },
            { medico: "Dra. Fernanda Escobar - Oftalmología", fecha: "2024-10-15", hora: "10:00", nombre: "Laura Méndez" },
            { medico: "Dr. Ignacio Sosa - Urología", fecha: "2024-10-16", hora: "11:00", nombre: "Raúl Benítez" },
            { medico: "Dra. Claudia Jiménez - Cardiología", fecha: "2024-10-17", hora: "12:30", nombre: "Sandra Iglesias" },
            { medico: "Dr. Andrés Paredes - Psiquiatría", fecha: "2024-10-18", hora: "09:45", nombre: "Martín Cabrera" },
            { medico: "Dra. Lucía Gutiérrez - Oncología", fecha: "2024-10-19", hora: "14:30", nombre: "Paula Guzmán" },
            { medico: "Dr. Marcelo Duarte - Reumatología", fecha: "2024-10-20", hora: "15:00", nombre: "Juliana López" },
            { medico: "Dra. Patricia Suárez - Gastroenterología", fecha: "2024-10-21", hora: "08:30", nombre: "Mateo Rodríguez" },
            { medico: "Dr. Enrique Ramírez - Nefrología", fecha: "2024-10-22", hora: "13:30", nombre: "Liliana Ríos" },
            { medico: "Dra. Verónica Silva - Endocrinología", fecha: "2024-10-23", hora: "11:15", nombre: "Daniel Vargas" }
        ];

        document.getElementById('turnero-form').addEventListener('submit', function (event) {
            event.preventDefault(); // Evita que el formulario se envíe de forma predeterminada

            // Obtener los valores de los campos del formulario
            const medico = document.getElementById('medico').value;
            const fecha = document.getElementById('fecha').value;
            const hora = document.getElementById('hora').value;
            const nombre = document.getElementById('nombre').value;

            // Validar que todos los campos estén completos antes de reservar el turno
            if (medico && fecha && hora && nombre) {
                // Crear un nuevo objeto turno
                const nuevoTurno = { medico, fecha, hora, nombre };

                // Agregar el nuevo turno a la lista de turnos
                turnos.push(nuevoTurno);

                // Actualizar la tabla de turnos
                actualizarTablaTurnos();

                // Limpiar los campos del formulario después de agregar el turno
                document.getElementById('medico').value = "";
                document.getElementById('fecha').value = "";
                document.getElementById('hora').value = "";
                document.getElementById('nombre').value = "";

                alert('Turno reservado exitosamente.');
            } else {
                alert('Por favor, complete todos los campos antes de reservar el turno.');
            }
        });



        // Función para actualizar la tabla de turnos
        function actualizarTablaTurnos() {
            const turnosBody = document.getElementById('turnos-body');
            turnosBody.innerHTML = '';  // Vacía la tabla actual

            // Generar una nueva fila en la tabla para cada turno
            turnos.forEach((turno, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
            <td>${turno.medico.split(' - ')[0]}</td>
            <td>${turno.medico.split(' - ')[1]}</td>
            <td>${turno.fecha}</td>
            <td>${turno.hora}</td>
            <td><button class="btn cancel" onclick="cancelarTurno(${index})">Cancelar</button></td>
        `;
                turnosBody.appendChild(row);  // Agregar la fila a la tabla
            });
        }

        // Función para cancelar un turno
        function cancelarTurno(index) {
            turnos.splice(index, 1);  // Eliminar el turno de la lista
            actualizarTablaTurnos();  // Actualizar la tabla después de eliminar el turno
        }

        // Función para buscar un turno
        function buscarTurno() {
            const input = document.getElementById('search').value.toLowerCase();
            const turnosBody = document.getElementById('turnos-body');
            turnosBody.innerHTML = '';  // Limpiar la tabla para mostrar los resultados filtrados

            // Mostrar solo los turnos que coinciden con la búsqueda
            turnos.forEach((turno, index) => {
                if (turno.medico.toLowerCase().includes(input)) {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                <td>${turno.medico.split(' - ')[0]}</td>
                <td>${turno.medico.split(' - ')[1]}</td>
                <td>${turno.fecha}</td>
                <td>${turno.hora}</td>
                <td><button class="btn cancel" onclick="cancelarTurno(${index})">Cancelar</button></td>
            `;
                    turnosBody.appendChild(row);  // Mostrar solo los turnos filtrados
                }
            });
        }

        // Inicializa la tabla con los turnos predefinidos
        actualizarTablaTurnos();



    </script>
</body>

</html>