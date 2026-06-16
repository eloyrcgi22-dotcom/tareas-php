<?php
// Inicializamos variables de datos y de errores
$nombre = $apellidos = $dni = $fecha_nac = $direccion = $url = "";
$autorizacion = "";
$errores = [];
$procesado_con_exito = false;

// 3. FUNCIÓN PHP PARA VALIDAR EL DNI REAL (Algoritmo oficial de la AEAT)
function validarDNI($dni) {
    // Limpiar espacios y pasar a mayúsculas
    $dni = strtoupper(trim($dni));
    
    // Comprobar formato básico (8 números y 1 letra)
    if (!preg_match('/^[0-9]{8}[A-Z]$/', $dni)) {
        return false;
    }
    
    // Separar el número de la letra
    $numero = substr($dni, 0, 8);
    $letra = substr($dni, -1);
    
    // Calcular la letra matemática correspondiente
    $letrasValidas = "TRWAGMYFPDXBNJZSQVHLCKE";
    $letraCalculada = $letrasValidas[$numero % 23];
    
    // Devolver si coincide o no
    return ($letra === $letraCalculada);
}

// Procesamos el formulario al recibir el POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validar Nombre
    if (empty($_POST['nombre'])) {
        $errores['nombre'] = "El campo Nombre es obligatorio.";
    } else {
        $nombre = htmlspecialchars(trim($_POST['nombre']));
    }
    
    // Validar Apellidos
    if (empty($_POST['apellidos'])) {
        $errores['apellidos'] = "El campo Apellidos es obligatorio.";
    } else {
        $apellidos = htmlspecialchars(trim($_POST['apellidos']));
    }
    
    // 2. Validar DNI (Obligatorio y usando la función PHP)
    if (empty($_POST['dni'])) {
        $errores['dni'] = "El campo DNI es obligatorio.";
        $dni = ""; // Requisito 1: Si es incorrecto/vacío, se limpia
    } else {
        $dni_introducido = trim($_POST['dni']);
        if (validarDNI($dni_introducido)) {
            $dni = htmlspecialchars(strtoupper($dni_introducido)); // Correcto: se guarda
        } else {
            $errores['dni'] = "El DNI introducido no es válido o la letra es incorrecta.";
            $dni = ""; // Requisito 1: Si es incorrecto, NO aparece en el formulario
        }
    }
    
    // Validar Fecha de Nacimiento
    $fecha_nac = htmlspecialchars($_POST['fecha_nac']);
    
    // Validar Dirección
    $direccion = htmlspecialchars(trim($_POST['direccion']));
    
    // Validar URL Propia
    if (empty($_POST['url'])) {
        $errores['url'] = "El campo URL propia es obligatorio.";
        $url = "";
    } else {
        $url_introducida = trim($_POST['url']);
        if (filter_var($url_introducida, FILTER_VALIDATE_URL)) {
            $url = htmlspecialchars($url_introducida);
        } else {
            $errores['url'] = "La URL introducida no tiene un formato válido.";
            $url = ""; // Requisito 1: Si es incorrecto, se limpia
        }
    }
    
    // Checkbox de autorización promocional
    $autorizacion = isset($_POST['autorizacion']) ? "SÍ autoriza el uso promocional." : "NO autoriza el uso promocional.";
    
    // Si no hay errores, la validación global es un éxito
    if (empty($errores)) {
        $procesado_con_exito = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación Avanzada de DNI</title>
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
    <h2>Validación de Formulario con Control de DNI</h2>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $procesado_con_exito): ?>
        <div class="resumen-exito">
            <h3>Validación Visual: ¡Todo Correcto!</h3>
            <p>El DNI es válido y los campos obligatorios han pasado los filtros del servidor.</p>
            <hr>
            <ul>
                <li><strong>Nombre:</strong> <?php echo $nombre; ?></li>
                <li><strong>Apellidos:</strong> <?php echo $apellidos; ?></li>
                <li><strong>DNI:</strong> <?php echo $dni; ?></li>
                <li><strong>Fecha Nacimiento:</strong> <?php echo $fecha_nac; ?></li>
                <li><strong>Dirección:</strong> <?php echo $direccion; ?></li>
                <li><strong>URL Propia:</strong> <?php echo $url; ?></li>
                <li><strong>Promociones:</strong> <?php echo $autorizacion; ?></li>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && !$procesado_con_exito): ?>
        <div class="resumen-error">
            <h3>Se han detectado errores en la validación:</h3>
            <p>Los campos con datos válidos se han mantenido, los incorrectos se han vaciado.</p>
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
            <label for="dni">DNI (*):</label>
            <input type="text" id="dni" name="dni" value="<?php echo $dni; ?>" placeholder="12345678A">
            <?php if (isset($errores['dni'])) echo "<div class='error-texto'>".$errores['dni']."</div>"; ?>
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
            <input type="text" id="url" name="url" value="<?php echo $url; ?>">
            <?php if (isset($errores['url'])) echo "<div class='error-texto'>".$errores['url']."</div>"; ?>
        </div>

        <div class="campo">
            <input type="checkbox" id="autorizacion" name="autorizacion" <?php if (isset($_POST['autorizacion'])) echo "checked"; ?>>
            <label style="display:inline;" for="autorizacion">Autorizo el uso promocional de datos.</label>
        </div>

        <div class="campo" style="margin-top: 20px;">
            <input type="submit" value="Validar DNI y Datos">
        </div>
    </form>
</div>

</body>
</html>