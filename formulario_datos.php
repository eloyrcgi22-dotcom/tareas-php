<?php
// Inicializamos variables para que no den error de "Undefined" la primera vez
$nombre = $apellidos = $nif = $fecha_nac = $direccion = "";
$autorizacion = "";
$mensaje_procesado = false;

// Comprobamos si el usuario ha enviado el formulario mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellidos = htmlspecialchars($_POST['apellidos']);
    $nif = htmlspecialchars($_POST['nif']);
    $fecha_nac = htmlspecialchars($_POST['fecha_nac']);
    $direccion = htmlspecialchars($_POST['direccion']);
    
    // Verificamos si el checkbox de autorización ha sido marcado
    $autorizacion = isset($_POST['autorizacion']) ? "SÍ autoriza el uso promocional." : "NO autoriza el uso promocional.";
    
    $mensaje_procesado = true;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Datos Personales</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f4f4f4; }
        .contenedor { max-width: 600px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); }
        .campo { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], input[type="date"] { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .resumen { background-color: #e2f0d9; border: 1px solid #385723; padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        input[type="submit"] { background-color: #0078d4; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; }
        input[type="submit"]:hover { background-color: #005a9e; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Formulario de Datos Personales</h2>

    <?php if ($mensaje_procesado): ?>
        <div class="resumen">
            <h3>🔍 Comprobación Visual de Datos:</h3>
            <p><strong>Por favor, comprueba que los datos introducidos son correctos. Si detectas algún error, modifícalo en el formulario de abajo y vuelve a enviar.</strong></p>
            <hr>
            <ul>
                <li><strong>Nombre:</strong> <?php echo $nombre; ?></li>
                <li><strong>Apellidos:</strong> <?php echo $apellidos; ?></li>
                <li><strong>NIF:</strong> <?php echo $nif; ?></li>
                <li><strong>Fecha de Nacimiento:</strong> <?php echo $fecha_nac; ?></li>
                <li><strong>Dirección Completa:</strong> <?php echo $direccion; ?></li>
                <li><strong>Fines Promocionales:</strong> <?php echo $autorizacion; ?></li>
            </ul>
        </div>
    <?php endif; ?>

    <!-- El formulario se envía a sí mismo usando PHP_SELF -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="campo">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
        </div>

        <div class="campo">
            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" value="<?php echo $apellidos; ?>" required>
        </div>

        <div class="campo">
            <label for="nif">NIF:</label>
            <input type="text" id="nif" name="nif" value="<?php echo $nif; ?>" required>
        </div>

        <div class="campo">
            <label for="fecha_nac">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nac" name="fecha_nac" value="<?php echo $fecha_nac; ?>" required>
        </div>

        <div class="campo">
            <label for="direccion">Dirección Completa:</label>
            <input type="text" id="direccion" name="direccion" value="<?php echo $direccion; ?>" required>
        </div>

        <div class="campo" style="margin-top: 20px;">
            <input type="checkbox" id="autorizacion" name="autorizacion" <?php if (isset($_POST['autorizacion'])) echo "checked"; ?>>
            <label style="display:inline;" for="autorizacion">Autorizo el uso de mis datos para fines promocionales.</label>
        </div>

        <div class="campo" style="margin-top: 20px;">
            <input type="submit" value="Enviar y Comprobar Datos">
        </div>
    </form>
</div>

</body>
</html>