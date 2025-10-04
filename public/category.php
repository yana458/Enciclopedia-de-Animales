<?php
// Título inicial
$titulo_pagina = 'Categoría - Enciclopedia de Animales';

// Incluimos header (abre main)
require_once __DIR__ . '/../includes/header.php';

// Incluimos datos
require_once __DIR__ . '/../data/datos.php';

// Obtenemos el id de la categoría desde GET
$cat_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// Validación del id
if ($cat_id === null || $cat_id === false) {
    echo '<h2>Categoría no encontrada</h2>';
    echo '<p>El identificador de la categoría no es válido.</p>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

// Buscamos la categoría
$categoria_encontrada = null;
if (isset($categorias[$cat_id])) {
    $categoria_encontrada = $categorias[$cat_id];
}

// Si no se encontró
if ($categoria_encontrada === null) {
    echo '<h2>Categoría no encontrada</h2>';
    echo '<p>No existe una categoría con ese identificador.</p>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

// Mostramos nombre y descripción
echo '<h2>' . htmlspecialchars($categoria_encontrada['nombre']) . '</h2>';
echo '<p>' . htmlspecialchars($categoria_encontrada['descripcion']) . '</p>';

// Listamos animales de esta categoría
echo '<h3>Animales en esta categoría</h3>';
echo '<ul>';
$hay_animales = false;

foreach ($animales as $a_id => $animal) { // $a_id es la clave (47293, etc.)
    if ($animal['categoria_id'] == $cat_id) {
        echo '<li><a href="/animal.php?id=' . urlencode($a_id) . '">' 
             . htmlspecialchars($animal['nombre']) . '</a></li>';
        $hay_animales = true;
    }
}

if (!$hay_animales) {
    echo '<li>No hay animales en esta categoría.</li>';
}

echo '</ul>';

// Footer
require_once __DIR__ . '/../includes/footer.php';
?>