<?php
// category.php - Paso 2
// Página que muestra la información de una categoría y lista los animales que pertenecen a ella

// Título dinámico para la cabecera
$titulo_pagina = "Categoría - Enciclopedia de Animales";

// Incluir cabecera HTML
require_once "../includes/header.php";

// Importar los datos de categorías y animales
require_once "../data/datos.php";

// Recuperamos el ID de la categoría que viene en la URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Validamos que el ID existe y que corresponde a una categoría válida
if (!$id || !isset($categorias[$id])) {
    echo "<p>Categoría no encontrada.</p>";
    require_once "../includes/footer.php"; // cerramos con el pie de página
    exit;
}

// Si el ID es correcto, guardamos la categoría en una variable
$categoria = $categorias[$id];
?>

<!-- Mostramos el nombre y descripción de la categoría -->
<h2><?= htmlspecialchars($categoria['nombre']) ?></h2>
<p><?= htmlspecialchars($categoria['descripcion']) ?></p>

<h3>Animales en esta categoría</h3>
<ul>
    <?php
    // Variable de control para saber si encontramos algún animal
    $encontrado = false;

    // Recorremos todos los animales
    foreach ($animales as $ani) {
        // Si el animal pertenece a la categoría seleccionada
        if ((int)$ani['categoria'] === (int)$categoria['id']) {
            $encontrado = true; // marcamos que hemos encontrado al menos uno
            ?>
            <!-- Mostramos el animal como un enlace hacia su página (animal.php) -->
            <li>
                <a href="animal.php?id=<?= $ani['id'] ?>"><?= htmlspecialchars($ani['nombre']) ?></a>
            </li>
            <?php
        }
    }

    // Si no encontramos ningún animal, mostramos un mensaje
    if (!$encontrado) {
        echo "<li>No hay animales en esta categoría.</li>";
    }
    ?>
</ul>

<?php
// Cerramos con el pie de página
require_once "../includes/footer.php";
?>
