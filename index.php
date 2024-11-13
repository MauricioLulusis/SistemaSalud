<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
$isLoggedIn = isset($_SESSION['UsuarioID']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Salud</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="views/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header class="header">
        <div class="menu container">
            <a href="#" class="medicina-integral">Medicina Integral</a>
            <input type="checkbox" id="menu" />
            <label for="menu">
                <img src="images/menu.png" class="menu-icono" alt="menu">
            </label>
            <nav class="navbar">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="views/html/chat-online.php">Chat online</a></li>
                    <li><a href="views/html/historial-turnos.php">Historial de turnos</a></li>
                    <li><a href="views/html/medico-online.php">Médico online</a></li>
                    <!-- Mostrar el enlace "Cerrar sesión" si el usuario está logueado -->
                    <?php if ($isLoggedIn): ?>
                        <li><a href="logout.php">Cerrar sesión</a></li>
                    <?php else: ?>
                        <li><a href="views/html/login.php">Iniciar sesión</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>

        <div class="header-content container">
            <div class="header-txt">
                <h1>MediCare+</h1>
                <p>
                    En MediCare+, nos enfocamos en ofrecer atención médica integral y personalizada, utilizando
                    tecnología avanzada para cuidar de tu bienestar. Nuestro equipo está comprometido con la salud
                    preventiva y un trato humano, asegurando que cada consulta sea una oportunidad para mejorar tu
                    calidad de vida. Tu salud es nuestra prioridad.
                </p>
                <a href="#" class="btn-1">informacion</a>
            </div>
            <div class="header-img">
                <img src="images/left.png" alt="imagen de medicos">
            </div>
        </div>
    </header>

    <section class="about container">
        <div class="about-img">
            <img src="images/about.png" alt="imagen de consultorio">
        </div>
        <div class="about-txt">
            <h2>Nosotros</h2>
            <p>
                Nuestro enfoque se basa en una visión holística de la salud, donde cada aspecto del bienestar de
                nuestros pacientes es considerado. Nos especializamos en ofrecer una gama completa de servicios médicos,
                desde consultas generales hasta especialidades avanzadas, siempre con el objetivo de proporcionar una
                atención integral y personalizada. Creemos que la salud es más que la ausencia de enfermedad, es un
                estado de equilibrio físico, mental y emocional.
            </p>
            <br>
            <p>
                Nos distinguimos por nuestra dedicación a la innovación médica y la educación continua de nuestro
                equipo. Esto nos permite estar a la vanguardia en tratamientos y tecnologías, garantizando que nuestros
                pacientes reciban el mejor cuidado posible. Además, nos comprometemos a mantener una comunicación clara
                y abierta, asegurando que nuestros pacientes comprendan su estado de salud y las opciones disponibles
                para su tratamiento. En MediCare+, tu salud es nuestro compromiso.
            </p>
        </div>
    </section>

    <main class="servicios">
        <h2>Servicios</h2>
        <div class="servicios-content container">
            <div class="servicio-1">
                <i class="fa-sharp fa-solid fa-hospital-user"></i>
                <h3>Pediatría</h3>
            </div>
            <div class="servicio-1">
                <i class="fa-sharp fa-solid fa-stethoscope"></i>
                <h3>Ginecología</h3>
            </div>
            <div class="servicio-1">
                <i class="fa-solid fa-bed-pulse"></i>
                <h3>Dermatología</h3>
            </div>
            <div class="servicio-1">
                <i class="fa-solid fa-hospital"></i>
                <h3>Cardiología</h3>
            </div>
        </div>
    </main>

    <section class="formulario container">
        <form method="POST" action="send.php" autocomplete="off">
            <h2>Más información</h2>
            <div class="input-group">
                <div class="input-container">
                    <input type="text" name="name" placeholder="Nombre y Apellido" required>
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="input-container">
                    <input type="tel" name="phone" placeholder="Teléfono Celular" required>
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div class="input-container">
                    <input type="email" name="email" placeholder="Correo" required>
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div class="input-container">
                    <textarea name="message" placeholder="Detalles de la consulta" required></textarea>
                </div>
                <input type="submit" name="send" class="btn" value="Enviar">
            </div>
        </form>
    </section>

    <footer class="footer">
        <div class="footer-content container">
            <div class="link">
                <a href="#" class="medicina-integral">Medicina Integral</a>
            </div>
            <div class="link">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="../../views/html/chat-online.php">Chat online</a></li>
                    <li><a href="index.php">Historial de Turnos</a></li>
                    <?php if ($isLoggedIn): ?>
                        <li><a href="logout.php">Cerrar sesión</a></li>
                    <?php else: ?>
                        <li><a href="views/html/login.php">Iniciar sesión</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </footer>

    <script>
        // Mostrar la notificación de SweetAlert según el parámetro en la URL
        const urlParams = new URLSearchParams(window.location.search);
        const mensaje = urlParams.get('mensaje');

        if (mensaje) {
            let title = '';
            let text = '';
            let icon = '';

            switch (mensaje) {
                case 'success':
                    title = '¡Éxito!';
                    text = 'Datos enviados correctamente.';
                    icon = 'success';
                    break;
                case 'error':
                    title = '¡Error!';
                    text = 'Error al enviar los datos.';
                    icon = 'error';
                    break;
                case 'incomplete':
                    title = '¡Advertencia!';
                    text = 'Por favor, complete todos los campos.';
                    icon = 'warning';
                    break;
                default:
                    break;
            }

            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                confirmButtonText: 'Aceptar'
            });
        }
    </script>

</body>
</html>
