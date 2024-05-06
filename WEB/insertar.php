<?php
$servername = "localhost";
$username = "id22015887_retr0";
$password = "Admin@1234";
$dbname = "id22015887_db_metricas";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

// Obtiene los datos del POST
$temperatura = $_POST["temperatura"];
$humedad = $_POST["humedad"];
$luz = $_POST["luz"];
$ph = $_POST["ph"];

// Inserta los datos en la base de datos
$sql = "INSERT INTO sensores (Temperatura, Humedad, Luz, Ph, fecha_actual) VALUES ('$temperatura', '$humedad', '$luz', '$ph', NOW())";

if ($conn->query($sql) === TRUE) {
  echo "Datos insertados correctamente";
} else {
  echo "Error al insertar datos: " . $conn->error;
}

// Cierra la conexión
$conn->close();
?>
