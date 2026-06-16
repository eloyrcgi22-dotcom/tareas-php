<?php
// Inicializamos variables de datos y de errores
$nombre = $fecha = $hora = $comensales = $email = $telefono = $comentarios = "";
$errores = [];
$reserva_confirmada = false;

// Procesamos al recibir el formulario por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Validar Nombre y apellidos (Obligatorio)
    if (empty($_POST['nombre'])) {
        $errores['nombre'] = "Dato requerido";
        $nombre = "";
    } else {
        $nombre = htmlspecialchars(trim($_POST['nombre']));
    }
    
    // 2. Validar Fecha (Obligatorio - cuadro de texto según nota)
    if (empty($_POST['fecha'])) {
        $errores['fecha'] = "Dato requerido";
        $fecha = "";
    } else {
        $fecha = htmlspecialchars(trim($_POST['fecha']));
    }
    
    // 3. Validar Hora (Obligatorio)
    if (empty($_POST['hora'])) {
        $errores['hora'] = "Dato requerido";
        $hora = "";
    } else {
        $hora = htmlspecialchars(trim($_POST['hora']));
    }
    
    // 4. Validar Nº de comensales (Obligatorio)
    if (empty($_POST['comensales'])) {
        $errores['comensales'] = "Dato requerido";
        $comensales = "";
    } else {
        $comensales = htmlspecialchars(trim($_POST['comensales']));
    }
    
    // 5. Validar E-mail (Obligatorio y bien formado)
    if (empty($_POST['email'])) {
        $errores['email'] = "Dato requerido";
        $email = "";
    } else {
        $email_previo = trim($_POST['email']);
        if (filter_var($email_previo, FILTER_VALIDATE_EMAIL)) {
            $email = htmlspecialchars($email_previo);
        } else {
            $errores['email'] = "Introduzca un email correcto";
            $email = ""; // Se vacía al ser incorrecto
        }
    }
    
    // 6. Validar Teléfono (Obligatorio)
    if (empty($_POST['telefono'])) {
        $errores['telefono'] = "Dato requerido";
        $telefono = "";
    } else {
        $telefono = htmlspecialchars(trim($_POST['telefono']));
    }
    
    // 7. Comentarios (Opcional)
    $comentarios = htmlspecialchars(trim($_POST['comentarios']));
    
    // Verificamos si el checkbox opcional está marcado (puedes añadir validación si fuera obligatorio)
    $condiciones = isset($_POST['condiciones']) ? true : false;
    
    // Si el array de errores está limpio, procesamos el éxito
    if (empty($errores)) {
        $reserva_confirmada = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Reservas - El Tataguyo</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #fcfbf9; color: #333; }
        .contenedor { max-width: 550px; background: white; padding: 25px; border: 1px solid #dcd1c4; border-radius: 4px; margin: 0 auto; }
        h2 { color: #5a1216; font-serif; border-bottom: 2px solid #5a1216; padding-bottom: 5px; }
        .campo { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; font-size: 0.95em; }
        input[type="text"], select, textarea { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 3px; }
        textarea { height: 80px; resize: vertical; }
        .error-alerta { color: #b30000; font-size: 0.85em; font-weight: bold; margin-top: 4px; }
        .msg-exito { background-color: #f3f7f0; border-left: 5px solid #4a7c59; padding: 15px; margin-bottom: 20px; font-size: 1.05em; line-height: 1.5; }
        input[type="submit"] { background-color: #5a1216; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 3px; font-weight: bold; }
        input[type="submit"]:hover { background-color: #3d0c0e; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Petición de Reservas</h2>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $reserva_confirmada): ?>
        <div class="msg-exito">
            Don/Doña <?php echo $nombre; ?> su reserva el <?php echo $fecha; ?> a las <?php echo $hora; ?> ha sido registrada. Próximamente recibirá confirmación de su reserva en la dirección de correo electrónico <?php echo $email; ?>. Gracias.
        </div>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        
        <div class="campo">
            <label for="nombre">Nombre y apellidos *</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
            <?php if (isset($errores['nombre'])) echo "<div class='error-alerta'>".$errores['nombre']."</div>"; ?>
        </div>

        <div class="campo">
            <label for="fecha">Fecha * (Ej: 14/12/2026)</label>
            <input type="text" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
            <?php if (isset($errores['fecha'])) echo "<div class='error-alerta'>".$errores['fecha']."</div>"; ?>
        </div>

        <div class="campo">
            <label for="hora">Hora *</label>
            <select id="hora" name="hora">
                <option value="">Seleccione hora...</option>
                <option value="13:00" <?php if($hora == "13:00") echo "selected"; ?>>13:00</option>
                <option value="14:00" <?php if($hora == "14:00") echo "selected"; ?>>14:00</option>
                <option value="15:00" <?php if($hora == "15:00") echo "selected"; ?>>15:00</option>
                <option value="21:00" <?php if($hora == "21:00") echo "selected"; ?>>21:00</option>
                <option value="22:00" <?php if($hora == "22:00") echo "selected"; ?>>22:00</option>
            </select>
            <?php if (isset($errores['hora'])) echo "<div class='error-alerta'>".$errores['hora']."</div>"; ?>
        </div>

        <div class="campo">
            <label for="comensales">Nº de comensales *</label>
            <input type="text" id="comensales" name="comensales" value="<?php echo $comensales; ?>">
            <?php if (isset($errores['comensales'])) echo "<div class='error-alerta'>".$errores['comensales']."</div>"; ?>
        </div>

        <div class="campo">
            <label for="email">E-mail *</label>
            <input type="text" id="email" name="email" value="<?php echo $email; ?>">
            <?php if (isset($errores['email'])) echo "<div class='error-alerta'>".$errores['email']."</div>"; ?>
        </div>

        <div class="campo">
            <label for="telefono">Teléfono *</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo $telefono; ?>">
            <?php if (isset($errores['telefono'])) echo "<div class='error-alerta'>".$errores['telefono']."</div>"; ?>
        </div>

        <div class="campo">
            <label for="comentarios">Comentarios</label>
            <textarea id="comentarios" name="comentarios"><?php echo $comentarios; ?></textarea>
        </div>

        <div class="campo">
            <input type="checkbox" id="condiciones" name="condiciones" <?php if (isset($_POST['condiciones'])) echo "checked"; ?>>
            <label style="display:inline;" for="condiciones">He leído y acepto las condiciones de uso</label>
        </div>

        <div class="campo" style="margin-top: 20px;">
            <input type="submit" value="Enviar">
        </div>
    </form>
</div>

</body>
</html>