<?php
// ControlHoras - Visualización de la pestaña "Actualidad" en PHP
// Este archivo carga los datos desde un CSV exportado de la hoja "Actualidad" y replica los cálculos principales

// Ruta al archivo CSV exportado desde Excel (debe contener los mismos datos y columnas que la hoja "Actualidad")
$csvFile = __DIR__ . '/Actualidad.csv';

// Función para convertir una cadena de tiempo (HH:MM:SS) a segundos
function timeToSeconds($time) {
    $parts = explode(':', $time);
    if (count($parts) == 3) {
        return $parts[0] * 3600 + $parts[1] * 60 + $parts[2];
    } elseif (count($parts) == 2) {
        return $parts[0] * 3600 + $parts[1] * 60;
    }
    return 0;
}

// Función para convertir segundos a formato HH:MM:SS
function secondsToTime($seconds) {
    $h = floor($seconds / 3600);
    $m = floor(($seconds % 3600) / 60);
    $s = $seconds % 60;
    return sprintf('%02d:%02d:%02d', $h, $m, $s);
}

// Leer el archivo CSV
$rows = [];
if (($handle = fopen($csvFile, 'r')) !== false) {
    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
        $rows[] = $data;
    }
    fclose($handle);
}

// Mostrar la tabla HTML
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Control de Horas - Actualidad</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 4px; text-align: center; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h1>Control de Horas - Actualidad</h1>
    <table>
        <thead>
            <tr>
                <?php foreach ($rows[0] as $col) { echo "<th>" . htmlspecialchars($col) . "</th>"; } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 1; $i < count($rows); $i++) {
                echo "<tr>";
                foreach ($rows[$i] as $cell) {
                    echo "<td>" . htmlspecialchars($cell) . "</td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
