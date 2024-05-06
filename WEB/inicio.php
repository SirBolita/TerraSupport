<?php

    $servername = "localhost";
    $dBUsername = "id22015887_retr0";
    $dBPassword = "Admin@1234";
    $dBName = "id22015887_db_metricas";
    
    $conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);
    
    if (!$conn) {
    	die("Connection failed: ".mysqli_connect_error());
    }
    
    // Consulta para obtener el último registro
    $consulta = "SELECT luz, ph, temperatura, humedad FROM sensores ORDER BY fecha_actual DESC LIMIT 1";
    $resultado = mysqli_query($conn, $consulta);
    
    if ($resultado) {
        // Obtiene los datos del último registro
        $fila = mysqli_fetch_assoc($resultado);
        $luz = $fila['luz'];
        $ph = $fila['ph'];
        $temperatura = $fila['temperatura'];
        $humedad = $fila['humedad'];
    
    } else {
        $fila = 0;
        $luz = 0;
        $ph = 0.0;
        $temperatura = 0;
        $humedad = 0;
    }

    // Verifica si se han enviado los datos
    if(isset($_POST['temperatura']) && isset($_POST['humedad']) && isset($_POST['luz']) && isset($_POST['ph'])) {
        // Recupera los valores de los campos del formulario
        $temperatura = $_POST['temperatura'];
        $humedad = $_POST['humedad'];
        $luz = $_POST['luz'];
        $ph = $_POST['ph'];
    
        // Establece la zona horaria
        date_default_timezone_set('America/Lima');
        // Obtiene la fecha y hora actual
        $fecha_actual = date("Y-m-d H:i:s");
    
        // Inserta los datos en la tabla
        $consulta = "INSERT INTO sensores (Temperatura, Humedad, Luz, Ph, fecha_actual) VALUES ('$temperatura','$humedad','$luz','$ph', '$fecha_actual')";
        $resultado = mysqli_query($conn, $consulta);
    
        // Verifica si la consulta se ejecutó correctamente
        if ($resultado){
            echo "Registro en base de datos OK!";
        } else {
            echo "Falla! Registro BD: " . mysqli_error($conn);
        }
    
        // Cierra la conexión a la base de datos
        mysqli_close($conn);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="aurora.css">
</head>
<body class="bg-gray-700 p-4 flex h-full">
    <div class="menu">
        <ul class="menu-content">
            <li class="text-white"><a href="#"><span class="material-symbols-outlined">Home</span><span>Home</span></a></li>
            <li class="text-white"><a href="#"><span class="material-symbols-outlined">dashboard</span><span>DashBoard</span></a></li>
            <li class="text-white"><a href="#"><span class="material-symbols-outlined">explore</span><span>Explore</span></a></li>
            <li class="text-white"><a href="/analiticas.php"><span class="material-symbols-outlined">analytics</span><span>Analytics</span></a></li>
            <li class="text-white"><a href="#"><span class="material-symbols-outlined">settings</span><span>Settings</span></a></li>
            <li class="text-white"><a href="#"><span class="material-symbols-outlined">person</span><span>Account</span></a></li>
            <li class="text-white"><a href="#"><span class="material-symbols-outlined">report</span><span>Report</span></a></li>
            <li class="text-white"><a href="#"><span class="material-symbols-outlined">email</span><span>Contact</span></a></li>
            <li class="text-white"><a href="#"><span class="material-symbols-outlined">logout</span><span>Logout</span></a></li>
        </ul>
    </div>

    <div class="mr-16"></div>
    
    <div class="bg-gray-700 p-4  rounded-xl w-full h-auto">
        
        <div class="flex items-center justify-center mt-10">
            <h1 class="text-white font-bold text-3xl"> ULTIMOS DATOS RECOLECTADOS</h1>
        </div>

        <section class="h-auto my-12 lg:mx-44">
            <div class="grid lg:grid-cols-2 md:grid-cols-2  gap-10 w-full h-auto">
                <div class="metricas">
                    <div class="flex items-center justify-center my-4 mx-4">
                        <div class="gauge">
                            <div class="gauge__body">
                                <div class="gauge__fill"></div>
                                <div class="gauge__cover"></div>
                            </div>
                            <h1 class="flex items-center text-xl justify-center h-auto text-white font-bold mt-3">TEMPERATURA</h1>
                        </div>
                    </div>
                </div>

                <div class="metricas">
                    <div class="flex items-center justify-center my-4  mx-4">
                        <div class="humedad">
                            <div class="humedad__body">
                                <div class="humedad__fill"></div>
                                <div class="humedad__cover"></div>
                            </div>
                            <h1 class="flex items-center text-xl justify-center h-auto text-white font-bold mt-3">HUMEDAD</h1>
                        </div>
                    </div>
                </div>

                <div class="metricas">
                    <div class="flex items-center justify-center my-4  mx-4">
                        <div class="ph">
                            <div class="ph__body">
                                <div class="ph__fill"></div>
                                <div class="ph__cover"></div>
                            </div>
                            <h1 class="flex items-center text-xl justify-center h-auto text-white font-bold mt-3">PH</h1>
                        </div>
                    </div>
                </div>

                <div class="metricas">
                    <div class="flex items-center justify-center my-4  mx-4">
                        <div class="luz">
                            <div class="luz__body">
                                <div class="luz__fill"></div>
                                <div class="luz__cover"></div>
                            </div>
                            <h1 class="flex items-center text-xl justify-center h-auto text-white font-bold mt-3">LUZ</h1>
                        </div>
                    </div>
                </div>

                               
            </div>
        </section>
    </div>
    
    <section>
        <div>
            <button id="chatButton" type="button" class="text-4xl fixed bottom-4 right-4 text-white bg-blue-800 font-bold hover:bg-blue-600 z-50 font-bold rounded-xl text-sm px-5 py-2.5 me-2 mb-2">AURORA_AI</button>
            <div id="chatBox" class="hidden fixed bottom-0 right-0 mr-4 mb-20 bg-white w-80 md:w-96 lg:w-96 h-max-96 rounded-xl shadow-lg z-50">
                                                
                <div class="contenedor">
                    <h1 class="font-bold text-white text-xl">HABLA CON AURORA</h1>
                    <div id="mensajes"></div>
                    <div style="display: flex; margin-top:10px; margin-bottom: -20px;">
                        <input type="text" id="consulta" placeholder="Escribe tu consulta aquí...">
                        <button type="button" id="botonConsulta">Consultar</button>
                    </div>
                </div>
            
            </div>
        </div>
    </section>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Varaible PHP a Javascript -->
    <script>
        // Almacena los valores en variables de JavaScript
        var luz = <?php echo $luz; ?>;
        var ph = <?php echo $ph; ?>;
        var temperatura = <?php echo $temperatura; ?>;
        var humedad = <?php echo $humedad; ?>;
    </script>    

   
    <!-- GAUGE VIEW -->
    <script>
        const gaugeElement = document.querySelector(".gauge");
    
        function setGaugeValue(gauge, value) {
            if (value < 0 || value > 1) {
                return;
            }
    
            gauge.querySelector(".gauge__fill").style.transform = `rotate(${
                value / 2
            }turn)`;
            gauge.querySelector(".gauge__cover").textContent = `${Math.round(
                value * 100
            )}°`;
        }
    
        setGaugeValue(gaugeElement, parseFloat((0.01*(temperatura))));
    </script>

    <script>
        const humedadElement = document.querySelector(".humedad");

        function setHumedadValue(humedad, value) {
            if (value < 0 || value > 1) {
                return;
            }

            humedad.querySelector(".humedad__fill").style.transform = `rotate(${
                value / 2
            }turn)`;
            humedad.querySelector(".humedad__cover").textContent = `${Math.round(
                value * 100
            )}%`;
        }

        setHumedadValue(humedadElement, parseFloat((0.01*(humedad))));
    </script>
    
    <script>
        const phElement = document.querySelector(".ph");

        function setPhValue(ph, value) {
            if (value < 0 || value > 14 || isNaN(value)) {
                return;
            }

            ph.querySelector(".ph__fill").style.transform = `rotate(${(value / 14) * 180}deg)`;
            ph.querySelector(".ph__cover").textContent = `${value.toFixed(1)}`;
        }

        setPhValue(phElement, parseFloat(ph));
    </script>

    <script>
        const luzElement = document.querySelector(".luz");
    
        function setLuzValue(luz, value) {
            if (value < 0 || value > 1) {
                return;
            }
    
            const maxLumens = 1000; // Suponiendo que el valor máximo corresponde a 1000 lúmenes
            const lumensValue = value * maxLumens; // Convertir de valor entre 0 y 1 a lúmenes entre 0 y 1000
            luz.querySelector(".luz__fill").style.transform = `rotate(${(lumensValue / maxLumens) * 180}deg)`;
            luz.querySelector(".luz__cover").textContent = `${Math.round(lumensValue)} lm`; // Mostrar el valor en lúmenes
        }
    
        setLuzValue(luzElement, parseFloat((0.001*(luz))));
    </script>


    <!-- CHAT BOT -->

    <script>
        const chatButton = document.getElementById('chatButton');
        const chatBox = document.getElementById('chatBox');

        chatButton.addEventListener('click', () => {
            chatBox.classList.toggle('hidden');
        });
        document.getElementById('closeChat').addEventListener('click', () => {
            chatBox.classList.add('hidden');
        });
    </script>
    
    <!-- IA AURORA -->

    <script type="importmap">
        {
            "imports": {
                "@google/generative-ai": "https://esm.run/@google/generative-ai"
            }
        }
    </script>

    <script type="module">
        import { GoogleGenerativeAI } from "@google/generative-ai";
        const clave = "AIzaSyD2WVkk0mzd8DJQDkOrsRhTTI5NF4LgG58"; // copiar su clave

        const genAI = new GoogleGenerativeAI(clave);
        const model = genAI.getGenerativeModel({ model: "gemini-pro" });

        const mensajes = document.querySelector("#mensajes");

        function agregarMensaje(mensaje, clase) {
            const div = document.createElement("div");
            div.classList.add("mensaje", clase);
            div.textContent = mensaje;
            mensajes.appendChild(div);
            mensajes.scrollTop = mensajes.scrollHeight;
        }

        document.querySelector("#consulta").addEventListener("keydown", (event) => {
            if (event.key === "Enter") {
                event.preventDefault();
                document.querySelector("#botonConsulta").click();
            }
        });

        document.querySelector("#botonConsulta").addEventListener("click", async () => {
            const consulta = document.querySelector("#consulta").value;
            if (consulta.trim() !== "") {
                agregarMensaje(consulta, "mensaje-usuario");
                document.querySelector("#consulta").value = "";
                desactivarInput();
                try {
                    const result = await model.generateContent(consulta);
                    const response = await result.response;
                    const text = await response.text();
                    agregarMensaje(text, "mensaje-chatbot");
                } catch (error) {
                    agregarMensaje("Problemas en la consulta", "mensaje-chatbot");
                }
                activarInput();
                document.querySelector("#consulta").focus(); // Mantener el foco en el campo de texto
            }
        });

        function desactivarInput() {
            document.querySelector("#consulta").disabled = true;
            document.querySelector("#botonConsulta").disabled = true;
        }

        function activarInput() {
            document.querySelector("#consulta").disabled = false;
            document.querySelector("#botonConsulta").disabled = false;
        }
    </script>
</body>
</html>