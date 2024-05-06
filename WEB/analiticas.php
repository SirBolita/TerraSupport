<?php
    
    $servername = "localhost";
    $dBUsername = "id22015887_retr0";
    $dBPassword = "Admin@1234";
    $dBName = "id22015887_db_metricas";
    
    $conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);
    
    if (!$conn) {
    	die("Connection failed: ".mysqli_connect_error());
    }
    
    // Consulta SQL para seleccionar los últimos 5 registros de la tabla "sensores"
    $sql1 = "SELECT * FROM sensores ORDER BY id DESC LIMIT 5;";
    $result1 = mysqli_query($conn, $sql1);
?>

<?php
    
    // Consulta SQL para seleccionar los últimos 5 registros de la tabla "predicciones"
    $sql2 = "SELECT * FROM predicciones ORDER BY id DESC LIMIT 5;";
    $result2 = mysqli_query($conn, $sql2);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Visualización de registros de sensores</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Últimos 5 Registros de Sensores</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Temperatura</th>
            <th>Humedad</th>
            <th>Luz</th>
            <th>PH</th>
            <th>Fecha Actual</th>
        </tr>
        <?php
        // Itera sobre los resultados y muestra cada registro en una fila de la tabla
        while($row = mysqli_fetch_assoc($result1)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['Temperatura'] . "</td>";
            echo "<td>" . $row['Humedad'] . "</td>";
            echo "<td>" . $row['Luz'] . "</td>";
            echo "<td>" . $row['Ph'] . "</td>";
            echo "<td>" . $row['fecha_actual'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    
    <h1>Últimos 5 Registros de Predicciones</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>ID_Sensor</th>
            <th>Alimento</th>
            <th>Detalle</th>
            <th>Estado del Suelo</th>
            <th>Recomendaciones</th>
            <th>Fecha Actual</th>
        </tr>
        <?php
        // Itera sobre los resultados y muestra cada registro en una fila de la tabla
        while($row = mysqli_fetch_assoc($result2)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['id_sensor'] . "</td>";
            echo "<td>" . $row['alimento'] . "</td>";
            echo "<td>" . $row['detalle'] . "</td>";
            echo "<td>" . $row['estado_suelo'] . "</td>";
            echo "<td>" . $row['recomendaciones'] . "</td>";
            echo "<td>" . $row['fecha_actual'] . "</td>";
            echo "</tr>";
        }

        // Cierra la conexión a la base de datos
        mysqli_close($conn);
        ?>
    </table>
    
    <h1>Ejecutar Prediccion con una IA</h1>
    <form action="envio.php" method="post">
        <input type="submit" value="Hacer Prediccion">
    </form>
    
</body>
</html>
