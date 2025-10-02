<?php
// -------------------------------
// PASO 2: Página de Categoría
// -------------------------------

// 1) Importamos los datos (categorías y animales)
require_once '../data/datos.php';

// 2) Recuperamos el ID de la categoría desde la URL (category.php?id=3)
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// 3) Validamos que el ID sea válido (> 0)
if ($id <= 0) {
    // Título genérico porque no hay categoría válida
    $titulo_pagina = "Categoría - Enciclopedia de Animales";
    require_once '../includes/header.php';
    echo "<p>Parámetro <code>id</code> ausente o inválido.</p>";
    require_once '../includes/footer.php';
    exit;
}

// 4) Buscamos la categoría por su ID (búsqueda simple con foreach)
$categoria = null;
foreach ($categorias as $cat) {
    if ((int)$cat['id'] === $id) {
        $categoria = $cat;
        break;
    }
}

// 5) Si no se encuentra, mostramos mensaje y salimos
if ($categoria === null) {
    $titulo_pagina = "Categoría - Enciclopedia de Animales";
    require_once '../includes/header.php';
    echo "<p>Categoría no encontrada.</p>";
    require_once '../includes/footer.php';
    exit;
}

// 6) Ya tenemos la categoría => ponemos el título ANTES de incluir la cabecera
$titulo_pagina = "Categoría: " . $categoria['nombre'];

// 7) Incluimos la cabecera (usa $titulo_pagina en <title>)
require_once '../includes/header.php';
?>

<!-- 8) Mostramos nombre y descripción de la categoría -->
<h2><?php echo htmlspecialchars($categoria['nombre']); ?></h2>
<p><?php echo htmlspecialchars($categoria['descripcion'] ?? ""); ?></p>

<h3>Animales en esta categoría</h3>
<ul>
<?php
    // 9) Recorremos los animales y mostramos los que tengan 'categoria' == id de la categoría
    $encontrado = false;

    foreach ($animales as $ani) {
        // Usamos SOLO la clave 'categoria' como pediste
        if (!isset($ani['categoria'])) {
            continue; // si no tiene esa clave, lo saltamos
        }

        if ((int)$ani['categoria'] === (int)$categoria['id']) {
            $encontrado = true;
            ?>
            <li>
                <a href="animal.php?id=<?php echo (int)$ani['id']; ?>">
                    <?php echo htmlspecialchars($ani['nombre']); ?>
                </a>
            </li>
            <?php
        }
    }

    if (!$encontrado) {
        echo "<li>No hay animales en esta categoría.</li>";
    }
?>
</ul>

<?php
// 10) Pie de página
require_once '../includes/footer.php';
