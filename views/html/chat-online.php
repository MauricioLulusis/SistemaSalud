<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Online - MediCare+</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../views/css/chat-online-style.css">
    <link rel="stylesheet" href="../../views/css/medico-online-style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>


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


<body>
    <div class="chat-container">
        <div class="chat-header">
            <h2>Chat Online - MediCare+</h2>
        </div>
        <div class="chat-messages" id="chatMessages">
            <div class="message bot-message">
                👋 ¡Hola! Soy el Dr. Juan Pérez, ¿en qué puedo ayudarte hoy?
            </div>
        </div>
        <div class="chat-input">
            <input type="text" id="userInput" placeholder="Escribe tu mensaje aquí...">
            <button id="sendMessage"><i class="fa-solid fa-paper-plane"></i></button>
        </div>
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
                    <li><a href="../../views/html/chat-online.php">Chat online</a></li>
                    <li><a href="../../views/html/medico-online.php">Médico online</a></li>
                </ul>
            </div>
        </div>
    </footer>





    <script>
        $(document).ready(function () {
            const botResponses = {
                "hola": "👋 ¡Hola! ¿Cómo te encuentras hoy? 😊",
                "cita": "Puedes agendar tu cita llamando al 📞 0800-123-4567 o visitando nuestra página web 🌐.",
                "gracias": "¡De nada! 💙 ¿Algo más en lo que pueda ayudarte?",
                "adiós": "¡Hasta luego! Que tengas un excelente día. 🌟",
                "dolor de cabeza": "😔 El dolor de cabeza puede tener muchas causas. ¿Desde cuándo lo sientes? 🧠",
                "tengo problemas de usuario" : "Si tienes problemas de usuario, aguarda y en breve nos comunicaremos",
                "ambulancia": "El numero de emergencia es *111📞",
                "ubicacion": "Usted se encuentra en Posadas- Misiones",
                "ayuda": "Si necesitas atención, dirigete a tu centro mas cercano😊"
            };

            const defaultResponse = "🤔 Lo siento, no entiendo tu consulta. ¿Podrías darme más detalles?";

            function appendMessage(text, type) {
                const messageDiv = $(`<div class="message ${type}-message"></div>`);
                messageDiv.html(text);
                $("#chatMessages").append(messageDiv);
                $("#chatMessages").scrollTop($("#chatMessages")[0].scrollHeight);
            }

            function botReply(userMessage) {
                const response = botResponses[userMessage.toLowerCase()] || defaultResponse;
                setTimeout(() => appendMessage(response, "bot"), 1000);
            }

            $("#sendMessage").on("click", function () {
                const userInput = $("#userInput").val().trim();
                if (userInput !== "") {
                    appendMessage(userInput, "user");
                    $("#userInput").val("");
                    botReply(userInput);
                }
            });

            $("#userInput").on("keypress", function (e) {
                if (e.which === 13) { // Enter key
                    $("#sendMessage").click();
                }
            });
        });
    </script>
</body>

</html>
