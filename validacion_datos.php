<?php
// Inicializamos variables de datos y de errores
$nombre = $apellidos = $nif = $fecha_nac = $direccion = $url = "";
$autorizacion = "";
$errores = [];
$procesado_con_exito = false;

// Procesamos el formulario al recibir el POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Validar Nombre (Obligatorio)
    if (empty($_POST['nombre'])) {
        $errores['nombre'] = "El campo Nombre es obligatorio.";
    } else {
        $nombre = htmlspecialchars(trim($_POST['nombre']));
    }
    
    // 2. Validar Apellidos (Obligatorio)
    if (empty($_POST['apellidos'])) {
        $errores['apellidos'] = "El campo Apellidos es obligatorio.";
    } else {
        $apellidos = htmlspecialchars(trim($_POST['apellidos']));
    }
    
    // 3. Validar NIF (Obligatorio)
    if (empty($_POST['nif'])) {
        $errores['nif'] = "El campo NIF es obligatorio.";
    } else {
        $nif = htmlspecialchars(trim($_POST['nif']));
        // Validación básica de formato de NIF/NIE (8 números y una letra)
        if (!preg_match('/^[0-9XYZ][0-9]{7}[A-Z]$/i', $nif)) {
            $errores['nif'] = "El formato del NIF introducido no es válido (Ej: 12345678A).";
        }
    }
    
    // 4. Validar Fecha de Nacimiento (Opcional pero sanitizada)
    $fecha_nac = htmlspecialchars($_POST['fecha_nac']);
    
    // 5. Validar Dirección (Opcional pero sanitizada)
    $direccion = htmlspecialchars(trim($_POST['direccion']));
    
    // 6. Validar URL Propia (Filtro avanzado de PHP)
    if (empty($_POST['url'])) {
        $errores['url'] = "El campo URL propia es obligatorio para esta entrega.";
    } else {
        $url = htmlspecialchars(trim($_POST['url']));
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $errores['url'] = "La URL introducida no tiene un formato válido (Ej: https://misitio.com).";
        }
    }
    
    // Checkbox de autorización promocional
    $autorizacion = isset($_POST['autorizacion']) ? "SÍ autoriza el uso promocional." : "NO autoriza el uso promocional.";
    
    // Si el array de errores está vacío, la validación visual es exitosa
    if (empty($errores)) {
        $procesado_con_exito = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación Avanzada de Datos Personales</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f4f4f4; }
        .contenedor { max-width: 600px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); }
        .campo { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], input[type="date"] { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .error-texto { color: #a51d24; font-size: 0.9em; margin-top: 5px; font-weight: bold; }
        .resumen-exito { background-color: #e2f0d9; border: 1px solid #385723; padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .resumen-error { background-color: #fce4d6; border: 1px solid #c65911; padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        input[type="submit"] { background-color: #0078d4; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; }
        input[type="submit"]:hover { background-color: #005a9e; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Validación de Datos Personales y URL</h2>

    <!-- ESTADO: VALIDACIÓN CORRECTA -->
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $procesado_con_exito): ?>
        <div class="resumen-exito">
            <h3>Validación Visual: ¡Datos Correctos!</h3>
            <p>Los datos han pasado la validación PHP del servidor de forma satisfactoria.</p>
            <hr>
            <ul>
                <li><strong>Nombre:</strong> <?php echo $nombre; ?></li>
                <li><strong>Apellidos:</strong> <?php echo $apellidos; ?></li>
                <li><strong>NIF:</strong> <?php echo $nif; ?></li>
                <li><strong>Fecha Nacimiento:</strong> <?php echo $fecha_nac; ?></li>
                <li><strong>Dirección:</strong> <?php echo $direccion; ?></li>
                <li><strong>URL Propia:</strong> <a href="<?php echo $url; ?>" target="_blank"><?php echo $url; ?></a></li>
                <li><strong>Promociones:</strong> <?php echo $autorizacion; ?></li>
            </ul>
        </div>
    <?php endif; ?>

    <!-- ESTADO: ERRORES DETECTADOS (Proponer corrección) -->
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && !$procesado_con_exito): ?>
        <div class="resumen-error">
            <h3>Se han detectado errores en los datos:</h3>
            <p>Por favor, revisa los campos marcados en rojo abajo para corregirlos y volver a validar.</p>
        </div>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        
        <div class="campo">
            <label for="nombre">Nombre (*):</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
            <?php if (isset($errores['nombre'])) echo "<div class='error-texto'>".$errores['nombre']."</div>"; ?>
        </div>

        <div class="campo">
            <label for="apellidos">Apellidos (*):</label>
            <input type="text" id="apellidos" name="apellidos" value="<?php echo $apellidos; ?>">
            <?php if (isset($errores['apellidos'])) echo "<div class='error-texto'>".$errores['apellidos']."</div>"; ?>
        </div>

        <div class="campo">
            <label for="nif">NIF (*):</label>
            <input type="text" id="nif" name="nif" value="<?php echo $nif; ?>">
            <?php if (isset($errores['nif'])) echo "<div class='error-texto'>".$errores['nif']."</div>"; ?>
        </div>

        <div class="campo">
            <label for="fecha_nac">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nac" name="fecha_nac" value="<?php echo $fecha_nac; ?>">
        </div>

        <div class="campo">
            <label for="direccion">Dirección Completa:</label>
            <input type="text" id="direccion" name="direccion" value="<?php echo $direccion; ?>">
        </div>

        <div class="campo">
            <label for="url">URL Propia (*):</label>
            <input type="text" id="url" name="url" value="<?php echo $url; ?>" placeholder="https://ejemplo.com">
            <?php if (isset($errores['url'])) echo "<div class='error-texto'>".$errores['url']."</div>"; ?>
        </div>

        <div class="campo">
            <input type="checkbox" id="autorizacion" name="autorizacion" <?php if (isset($_POST['autorizacion'])) echo "checked"; ?>>
            <label style="display:inline;" for="autorizacion">Autorizo el uso promocional de datos.</label>
        </div>

        <div class="campo" style="margin-top: 20px;">
            <input type="submit" value="Validar Datos con PHP">
        </div>
    </form>
</div>

</body>
</html>