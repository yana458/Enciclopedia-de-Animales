<?php
// Título inicial
$titulo_pagina = 'Animal - Enciclopedia';

// Incluimos header
require_once __DIR__ . '/../includes/header.php';

// Incluimos datos
require_once __DIR__ . '/../data/datos.php';

// Obtenemos id desde GET
$animal_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// Validación
if ($animal_id === null || $animal_id === false) {
    echo '<h2>Animal no encontrado</h2>';
    echo '<p>El identificador del animal no es válido.</p>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

// Buscamos animal usando la clave del array
$animal_encontrado = isset($animales[$animal_id]) ? $animales[$animal_id] : null;

// Si no existe
if ($animal_encontrado === null) {
    echo '<h2>Animal no encontrado</h2>';
    echo '<p>No existe un animal con ese identificador.</p>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

// Título dinámico
$titulo_pagina = 'Animal: ' . htmlspecialchars($animal_encontrado['nombre']);

// Mostrar datos del animal
echo '<h2>' . htmlspecialchars($animal_encontrado['nombre']) . '</h2>';
echo '<p><strong>Hábitat:</strong> ' . htmlspecialchars($animal_encontrado['habitat']) . '</p>';

// Imagen
if (!empty($animal_encontrado['imagen'])) {
    echo '<div class="animal-card">';
    echo '<img src="uploads/images/' . htmlspecialchars($animal_encontrado['imagen']) . '" alt="' 
         . htmlspecialchars($animal_encontrado['nombre']) . '">';
    echo '</div>';
}

// Características
if (!empty($animal_encontrado['caracteristicas'])) {
    echo '<h3>Características</h3><ul>';
    foreach ($animal_encontrado['caracteristicas'] as $c) {
        echo '<li>' . htmlspecialchars($c) . '</li>';
    }
    echo '</ul>';
}

// PDF
if (!empty($animal_encontrado['pdf'])) {
    echo '<p><a href="uploads/pdfs/' . htmlspecialchars($animal_encontrado['pdf']) . '" target="_blank" rel="noopener">Ver PDF con la descripción</a></p>';
}

// Enlace a actualización
echo '<p><a href="/update-animal.php?id=' . urlencode($animal_id) . '">Actualizar archivos de este animal</a></p>';

// Footer
require_once __DIR__ . '/../includes/footer.php';
?>