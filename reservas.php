<?php
// Variables para guardar los datos y que no den error al cargar la primera vez
$nombre = "";
$fecha = "";
$hora = "";
$comensales = "";
$email = "";
$telefono = "";
$comentarios = "";

// Variables para los mensajes de error
$err_nombre = "";
$err_fecha = "";
$err_hora = "";
$err_comensales = "";
$err_email = "";
$err_telefono = "";

$todo_ok = true;
$mostrar_exito = false;

// Comprobar si se ha pulsado enviar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validar Nombre
    if (empty($_POST['nombre'])) {
        $err_nombre = "Dato requerido";
        $todo_ok = false;
    } else {
        $nombre = trim($_POST['nombre']);
    }
    
    // Validar Fecha
    if (empty($_POST['fecha'])) {
        $err_fecha = "Dato requerido";
        $todo_ok = false;
    } else {
        $fecha = trim($_POST['fecha']);
    }
    
    // Validar Hora
    if (empty($_POST['hora'])) {
        $err_hora = "Dato requerido";
        $todo_ok = false;
    } else {
        $hora = $_POST['hora'];
    }
    
    // Validar Comensales
    if (empty($_POST['comensales'])) {
        $err_comensales = "Dato requerido";
        $todo_ok = false;
    } else {
        $comensales = trim($_POST['comensales']);
    }
    
    // Validar Email
    if (empty($_POST['email'])) {
        $err_email = "Dato requerido";
        $todo_ok = false;
    } else {
        $email_temporal = trim($_POST['email']);
        // Comprobacion del formato de email
        if (strpos($email_temporal, '@') !== false && strpos($email_temporal, '.') !== false) {
            $email = $email_temporal;
        } else {
            $err_email = "Introduzca un email correcto";
            $todo_ok = false;
        }
    }
    
    // Validar Telefono
    if (empty($_POST['telefono'])) {
        $err_telefono = "Dato requerido";
        $todo_ok = false;
    } else {
        $telefono = trim($_POST['telefono']);
    }
    
    // Comentarios (es opcional)
    $comentarios = trim($_POST['comentarios']);
    
    // Si no ha saltado ningun error
    if ($todo_ok) {
        $mostrar_exito = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservas El Tataguyo</title>
    <style>
        /* Un estilo muy básico para que no quede pegado a los bordes, nada cantoso */
        body { font-family: sans-serif; margin: 40px; background-color: #fafafa; }
        .error { color: red; font-weight: bold; font-size: 0.9em; }
        .exito { background-color: #d4edda; color: #155724; padding: 15px; border: 1px solid #c3e6cb; margin-bottom: 20px; }
        .campo { margin-bottom: 12px; }
        label { display: block; font-weight: bold; }
    </style>
</head>
<body>

    <h2>Petición de Reservas</h2>

    <?php if ($mostrar_exito): ?>
        <div class="exito">
            Don/Doña <?php echo $nombre; ?> su reserva el <?php echo $fecha; ?> a las <?php echo $hora; ?> ha sido registrada. Próximamente recibirá confirmación de su reserva en la dirección de correo electrónico <?php echo $email; ?>. Gracias.
        </div>
    <?php endif; ?>

    <form action="reservas.php" method="POST">
        
        <div class="campo">
            <label>Nombre y apellidos *</label>
            <input type="text" name="nombre" value="<?php echo $nombre; ?>">
            <?php if ($err_nombre) echo "<span class='error'>$err_nombre</span>"; ?>
        </div>

        <div class="campo">
            <label>Fecha *</label>
            <input type="text" name="fecha" value="<?php echo $fecha; ?>">
            <?php if ($err_fecha) echo "<span class='error'>$err_fecha</span>"; ?>
        </div>

        <div class="campo">
            <label>Hora *</label>
            <select name="hora">
                <option value="">-- Seleccione --</option>
                <option value="13:00" <?php if($hora == "13:00") echo "selected"; ?>>13:00</option>
                <option value="14:00" <?php if($hora == "14:00") echo "selected"; ?>>14:00</option>
                <option value="15:00" <?php if($hora == "15:00") echo "selected"; ?>>15:00</option>
                <option value="21:00" <?php if($hora == "21:00") echo "selected"; ?>>21:00</option>
                <option value="22:00" <?php if($hora == "22:00") echo "selected"; ?>>22:00</option>
            </select>
            <?php if ($err_hora) echo "<span class='error'>$err_hora</span>"; ?>
        </div>

        <div class="campo">
            <label>Nº de comensales *</label>
            <input type="text" name="comensales" value="<?php echo $comensales; ?>">
            <?php if ($err_comensales) echo "<span class='error'>$err_comensales</span>"; ?>
        </div>

        <div class="campo">
            <label>E-mail *</label>
            <input type="text" name="email" value="<?php echo $email; ?>">
            <?php if ($err_email) echo "<span class='error'>$err_email</span>"; ?>
        </div>

        <div class="campo">
            <label>Teléfono *</label>
            <input type="text" name="telefono" value="<?php echo $telefono; ?>">
            <?php if ($err_telefono) echo "<span class='error'>$err_telefono</span>"; ?>
        </div>

        <div class="campo">
            <label>Comentarios</label>
            <textarea name="comentarios"><?php echo $comentarios; ?></textarea>
        </div>

        <div class="campo">
            <input type="checkbox" name="condiciones" <?php if(isset($_POST['condiciones'])) echo "checked"; ?>> He leído y acepto las condiciones de uso
        </div>

        <button type="submit">Enviar</button>
    </form>

</body>
</html>