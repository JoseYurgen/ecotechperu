<!-- index.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoTechPeru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('images/fondo_index.jpg'); /* Ruta de tu imagen de fondo */
            background-size: cover;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        @media screen and (max-width: 600px) {
            form {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <form action="index.php" method="post">
        <h1>Registro de Reciclaje Electrónico</h1>

        <?php
        // Procesar el formulario cuando se envía
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Conectar a la base de datos (reemplazar con tus credenciales)
            $conexion = new mysqli("localhost", "id21633136_ecotechperu", "Soyecologico_2023$", "id21633136_reciclaje_db");

            // Verificar la conexión
            if ($conexion->connect_error) {
                die("Error en la conexión a la base de datos: " . $conexion->connect_error);
            }

            // Obtener los datos del formulario
            $nombre = $_POST["nombre"];
            $direccion = $_POST["direccion"];
            $telefono = $_POST["telefono"];
            $dispositivosInteres = $_POST["dispositivos_interes"];

            // Utilizar consultas preparadas para prevenir inyección SQL
            $sql = "INSERT INTO usuarios (nombre, direccion, telefono, dispositivos_interes) VALUES (?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);

            // Verificar si la preparación fue exitosa
            if ($stmt) {
                // Vincular parámetros
                $stmt->bind_param("ssss", $nombre, $direccion, $telefono, $dispositivosInteres);

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    echo "<div id='mensajeExito' style='color: #4caf50;'>
                            Registro exitoso. Gracias por tu interés en reciclar dispositivos electrónicos.
                          </div>";

                    // Desaparecer el mensaje de éxito después de 5 segundos
                    echo "<script>
                            setTimeout(function() {
                                document.getElementById('mensajeExito').style.display = 'none';
                            }, 5000);
                          </script>";
                } else {
                    echo "Error al registrar el usuario: " . $stmt->error;
                }

                // Cerrar la consulta preparada
                $stmt->close();
            } else {
                echo "Error en la preparación de la consulta: " . $conexion->error;
            }

            // Cerrar la conexión
            $conexion->close();
        }
        ?>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" required>

        <label for="telefono">Teléfono:</label>
        <input type="tel" name="telefono" required>

        <label for="dispositivos_interes">Dispositivos de Interés:</label>
        <input type="text" name="dispositivos_interes" required>

        <input type="submit" value="Registrarse">
    </form>
</body>
</html>
