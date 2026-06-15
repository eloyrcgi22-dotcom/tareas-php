<?php
// Enunciado: Definición y uso de funciones en PHP
echo "<h2>Ejercicio 3: Funciones en PHP</h2>";

// Definición de la función
function calcularPrecioConIva($precioBase, $iva = 21) {
    $total = $precioBase + ($precioBase * ($iva / 100));
    return $total;
}

$servidor_web_precio = 150; // Euros

// Llamada a la función pasándole los datos
$precio_final = calcularPrecioConIva($servidor_web_precio);

echo "El precio base del servidor es: " . $servidor_web_precio . "€<br>";
echo "El precio total con el 21% de IVA aplicado es: " . $precio_final . "€";
?>