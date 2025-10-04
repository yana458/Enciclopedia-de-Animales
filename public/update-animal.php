<?php // Abrimos PHP
// Título inicial
$titulo_pagina = 'Actualizar archivos - Animal'; // Título

// Incluimos header (abre main)
require_once __DIR__ . '/../includes/header.php'; // Header

// Incluimos datos para validar que el animal exista
require_once __DIR__ . '/../data/datos.php'; // Datos

// Obtenemos id desde GET
$animal_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // ID del animal

// Si el id no es válido, mostramos mensaje
if ($animal_id === null || $animal_id === false) {
    echo '<h2>Animal no encontrado</h2>'; // Mensaje
    echo '<p>ID inválido.</p>'; // Explicación
    require_once __DIR__ . '/../includes/footer.php'; // Footer
    exit; // Salir
}

// Buscamos el animal en $animales
$animal_encontrado = null; // Inicializamos
if (isset($animales) && is_array($animales)) {
    foreach ($animales as $a) { // Recorremos animales
        if (isset($a['id']) && $a['id'] == $animal_id) { // Si coincide
            $animal_encontrado = $a; // Guardamos
            break; // Salimos
        }
    }
}

// Si no existe el animal, indicamos que no se puede actualizar
if ($animal_encontrado === null) {
    echo '<h2>Animal no encontrado</h2>'; // Mensaje
    echo '<p>No se puede actualizar un animal inexistente.</p>'; // Explicación
    require_once __DIR__ . '/../includes/footer.php'; // Footer
    exit; // Salimos
}

// Si la petición es POST, procesamos las subidas (estamos en el mismo archivo)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Rutas de destino dentro de public/uploads
    $dir_images = __DIR__ . '/uploads/images'; // Ruta absoluta imágenes
    $dir_pdfs = __DIR__ . '/uploads/pdfs'; // Ruta absoluta pdfs

    // Creamos carpetas si no existen
    if (!is_dir($dir_images)) { mkdir($dir_images, 0755, true); } // Crear images
    if (!is_dir($dir_pdfs)) { mkdir($dir_pdfs, 0755, true); } // Crear pdfs

    // Procesamos imagen nueva (si se ha subido)
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['imagen']; // Archivo
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)); // Extensión
        $ext_permitidas = array('jpg','jpeg','png','gif'); // Permitidas
        if (in_array($ext, $ext_permitidas)) {
            $nombre_archivo = $animal_id . '.' . $ext; // Nombre final
            $ruta_destino = $dir_images . '/' . $nombre_archivo; // Ruta absoluta
            if (move_uploaded_file($file['tmp_name'], $ruta_destino)) {
                echo '<p>Imagen actualizada correctamente.</p>'; // Mensaje éxito imagen
            } else {
                echo '<p>Error al mover la imagen.</p>'; // Error mover
            }
        } else {
            echo '<p>Formato de imagen no permitido.</p>'; // Extensión no permitida
        }
    } else {
        // No se subió nueva imagen o hubo error, no lo tratamos como fatal
    }

    // Procesamos PDF nuevo (si se ha subido)
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['pdf']; // Archivo
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)); // Extensión
        if ($ext === 'pdf') {
            $nombre_pdf = $animal_id . '.pdf'; // Nombre final
            $ruta_destino = $dir_pdfs . '/' . $nombre_pdf; // Ruta absoluta
            if (move_uploaded_file($file['tmp_name'], $ruta_destino)) {
                echo '<p>PDF actualizado correctamente.</p>'; // Mensaje éxito pdf
            } else {
                echo '<p>Error al mover el PDF.</p>'; // Error mover
            }
        } else {
            echo '<p>El archivo no es un PDF válido.</p>'; // Extensión inválida
        }
    } else {
        // No se subió nuevo PDF o hubo error, no lo tratamos como fatal
    }

    // Mensaje final de la operación de actualización
    echo '<p><a href="/animal.php?id=' . urlencode($animal_id) . '">Ver animal</a> | <a href="/index.php">Volver al inicio</a></p>'; // Enlaces
    require_once __DIR__ . '/../includes/footer.php'; // Footer
    exit; // Terminamos la ejecución después del POST
}

// Si no es POST, mostramos el formulario para subir nuevos archivos
echo '<h2>Actualizar archivos de: ' . htmlspecialchars($animal_encontrado['nombre']) . '</h2>'; // Título con nombre del animal
?>

<!-- Formulario que se envía a sí mismo (misma página), por POST, con multipart/form-data -->
<form action="/update-animal.php?id=<?php echo urlencode($animal_id); ?>" method="post" enctype="multipart/form-data">
    <div class="form-group"> <!-- Nueva imagen -->
        <label for="imagen">Nueva imagen</label> <!-- Label -->
        <input type="file" name="imagen" id="imagen" accept="image/*"> <!-- Input file -->
    </div>

    <div class="form-group"> <!-- Nuevo pdf -->
        <label for="pdf">Nuevo PDF</label> <!-- Label -->
        <input type="file" name="pdf" id="pdf" accept="application/pdf"> <!-- Input file -->
    </div>

    <button type="submit">Subir cambios</button> <!-- Botón enviar -->
</form>

<?php
// Incluimos footer al final
require_once __DIR__ . '/../includes/footer.php'; // Footer
?>
