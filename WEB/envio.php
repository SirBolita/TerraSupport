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
    
    // Consulta el último registro insertado
    $sql = "SELECT * FROM sensores ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    
    // Verifica si hay resultados
    if (mysqli_num_rows($result) > 0) {
      // Obtiene el último registro
      $row = mysqli_fetch_assoc($result);
    
      // Filtra solo los campos de temperatura, humedad, luz y pH
      $sensores_data = array(
        'temperatura' => $row['Temperatura'],
        'humedad' => $row['Humedad'],
        'luz' => $row['Luz'],
        'ph' => $row['Ph']
      );
    
      // Convierte los datos a JSON
      $sensores_json = json_encode($sensores_data);
    
      // Configura la solicitud HTTP
      $url = 'https://kobadev.pythonanywhere.com/predict';
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $sensores_json);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
          'Content-Type: application/json',
          'Content-Length: ' . strlen($sensores_json)
        )
      );
    
      // Envía la solicitud y obtiene la respuesta
      $response = curl_exec($ch);
      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);
    
      // Maneja la respuesta
      if ($httpcode == 200) {
    
        // Decodificar la respuesta JSON
        $response_array = json_decode($response, true);
    
        // Verificar si la decodificación fue exitosa
        if ($response_array === null) {
          // Si la decodificación falla
          echo "Error al decodificar la respuesta JSON.";
        } else {
          // Si la decodificación es exitosa, puedes acceder a los datos como un array asociativo
          $alimento = $response_array['alimento'][0];
          $detalle = $response_array['detalle'][0];
          $estado_suelo = $response_array['estado_suelo'][0];
          $recomendaciones = $response_array['recomendaciones'][0];
    
          // Insertar la respuesta en la tabla predicciones junto con el ID del sensor asociado
          $id_sensor = $row['id'];
          $sql_insert = "INSERT INTO predicciones (id_sensor, alimento, detalle, estado_suelo, recomendaciones) 
                         VALUES ('$id_sensor', '$alimento', '$detalle', '$estado_suelo', '$recomendaciones')";
          if ($conn->query($sql_insert) === TRUE) {
            echo "La respuesta se ha guardado en la tabla predicciones correctamente.";
          } else {
            echo "Error al guardar la respuesta en la tabla predicciones: " . $conn->error;
          }
        }
      } else {
        echo "Error al enviar la solicitud HTTP. Código de estado: " . $httpcode;
      }
    } else {
      // Si no hay resultados en la consulta
      echo "No se encontraron datos en la tabla de sensores.";
    }
    
    // Cierra la conexión
    $conn->close();
?>
