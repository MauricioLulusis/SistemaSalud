$(document).ready(function() {
    // Función para mostrar el mensaje interactivo
    function mostrarMensaje(mensaje) {
        // Crear el contenedor del mensaje
        const mensajeHtml = `
            <div class="mensaje-overlay">
                <div class="mensaje-popup">
                    <p>${mensaje}</p>
                    <button class="cerrar-mensaje">Cerrar</button>
                </div>
            </div>`;

        // Agregar el mensaje al body
        $('body').append(mensajeHtml);

        // Manejar el clic en el botón "Cerrar"
        $('.cerrar-mensaje').click(function() {
            $('.mensaje-overlay').remove();
        });
    }

    // Detectar clic en "Historial de turnos" y "Médico online"
    $('a[href="index.php"], a[href="views/html/login.php"]').click(function(event) {
        if (!$(this).hasClass('logueado')) { // Si el usuario no está logueado
            event.preventDefault(); // Prevenir la navegación

            const mensaje = "Debes iniciar sesión para acceder a esta sección.";
            mostrarMensaje(mensaje);
        }
    });
});
