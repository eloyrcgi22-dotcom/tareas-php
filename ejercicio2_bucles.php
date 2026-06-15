<?php
// Enunciado: Estructuras de control (Condicionales y Bucles)
echo "<h2>Ejercicio 2: Estructuras de Control</h2>";

$nota_final = 8.75;

// Estructura condicional (if-else)
if ($nota_final >= 5) {
    echo "Resultado: ¡Asignatura Aprobada!<br><br>";
} else {
    echo "Resultado: Suspendido. Toca recuperar.<br><br>";
}

// Estructura de repetición (Bucle for) - Generar la tabla de multiplicar del 5
echo "<strong>Tabla de multiplicar del 5:</strong><br>";
for ($i = 1; $i <= 10; $i++) {
    $resultado = 5 * $i;
    echo "5 x $i = " . $resultado . "<br>";
}
?>