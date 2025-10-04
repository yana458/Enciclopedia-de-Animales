<?php // Abrimos PHP
// Definimos título general
$titulo_pagina = 'Procesar Registro - Enciclopedia'; // Título

// Incluimos header
require_once __DIR__ . '/../includes/header.php'; // Header

// Aseguramos que la carpeta uploads/images y uploads/pdfs existan dentro de public
$dir_images = __DIR__ . '/uploads/images'; // Ruta absoluta carpeta imágenes
$dir_pdfs = __DIR__ . '/uploads/pdfs'; // Ruta absoluta carpeta pdfs

// Si las carpetas no existen, las creamos con permisos 0755
if (!is_dir($dir_images)) { mkdir($dir_images, 0755, true); } // Crear si no existe
if (!is_dir($dir_pdfs)) { mkdir($dir_pdfs, 0755, true); } // Crear si no existe

// Recogemos los datos enviados por POST
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : ''; // Categoría seleccionada
$id = isset($_POST['id']) ? $_POST['id'] : ''; // ID proporcionado por el usuario
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : ''; // Nombre del animal
$habitat = isset($_POST['habitat']) ? trim($_POST['habitat']) : ''; // Hábitat
$caracteristicas_raw = isset($_POST['caracteristicas']) ? $_POST['caracteristicas'] : ''; // Características en una cadena

// Validación básica: comprobamos que campos de texto no estén vacíos
$errores = array(); // Array para almacenar errores
if (empty($categoria)) { $errores[] = 'Debe seleccionar una categoría.'; } // Validar categoría
if (empty($id)) { $errores[] = 'Debe indicar un ID numérico para el animal.'; } // Validar id
if (empty($nombre)) { $errores[] = 'El nombre no puede estar vacío.'; } // Validar nombre
if (empty($habitat)) { $errores[] = 'El hábitat no puede estar vacío.'; } // Validar hábitat

// Procesamos la imagen subida (campo 'imagen')
$imagen_url = ''; // URL/Path final que mostraremos en la página
if (isset($_FILES['imagen'])) { // Si existe el campo
    $file = $_FILES['imagen']; // Guardamos en variable local
    if ($file['error'] === UPLOAD_ERR_OK) { // Subida correcta
        // Obtenemos extensión original del archivo subido (en minúsculas)
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)); // Extensión
        // Aceptamos solo ciertas extensiones de imagen
        $ext_permitidas = array('jpg','jpeg','png','gif'); // Extensiones permitidas
        if (in_array($ext, $ext_permitidas)) { // Si es válida
            // Nombre final: ID + . + extensión (según instrucciones)
            $nombre_archivo = $id . '.' . $ext; // nombre final del archivo
            $ruta_destino = $dir_images . '/' . $nombre_archivo; // Ruta absoluta destino
            // Movemos el archivo temporal a la carpeta uploads/images
            if (move_uploaded_file($file['tmp_name'], $ruta_destino)) {
                // Guardamos la ruta relativa para mostrar la imagen en la web
                $imagen_url = 'uploads/images/' . $nombre_archivo; // Ruta relativa
            } else {
                $errores[] = 'Error al mover la imagen subida.'; // Error mover archivo
            }
        } else {
            $errores[] = 'Formato de imagen no permitido. Usa jpg, png o gif.'; // Extensión no permitida
        }
    } else {
        $errores[] = 'Error en la subida de la imagen.'; // Error general en la subida
    }
} else {
    $errores[] = 'No se ha enviado ninguna imagen.'; // No vino el campo
}

// Procesamos el PDF subido (campo 'pdf')
$pdf_url = ''; // Ruta final para el PDF
if (isset($_FILES['pdf'])) { // Si existe el campo
    $file = $_FILES['pdf']; // Guardamos variable local
    if ($file['error'] === UPLOAD_ERR_OK) { // Subida correcta
        // Obtenemos extensión
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)); // Extensión
        if ($ext === 'pdf') { // Solo aceptamos PDF
            // Nombre final: ID + .pdf
            $nombre_pdf = $id . '.pdf'; // Nombre del pdf
            $ruta_destino = $dir_pdfs . '/' . $nombre_pdf; // Ruta absoluta destino
            if (move_uploaded_file($file['tmp_name'], $ruta_destino)) {
                // Guardamos ruta relativa para enlace
                $pdf_url = 'uploads/pdfs/' . $nombre_pdf; // Ruta relativa
            } else {
                $errores[] = 'Error al mover el PDF subido.'; // Error mover pdf
            }
        } else {
            $errores[] = 'El archivo PDF no tiene la extensión .pdf.'; // Extensión inválida
        }
    } else {
        $errores[] = 'Error en la subida del PDF.'; // Error general en la subida
    }
} else {
    $errores[] = 'No se ha enviado ningún PDF.'; // No vino el campo
}

// Si hay errores, los mostramos
if (!empty($errores)) {
    echo '<h2>Se han encontrado errores</h2>'; // Título
    echo '<ul>'; // Lista de errores
    foreach ($errores as $e) {
        echo '<li>' . htmlspecialchars($e) . '</li>'; // Mostrar cada error
    }
    echo '</ul>'; // Fin de la lista
    echo '<p><a href="/register-animal.php">Volver al formulario</a></p>'; // Enlace para volver
    require_once __DIR__ . '/../includes/footer.php'; // Footer
    exit; // Salimos para no mostrar más
}

// Si todo está correcto, mostramos los datos recibidos en formato similar a animal.php
echo '<h2>Animal registrado (mostrado, no guardado)</h2>'; // Aviso: no se guarda en datos.php
echo '<p><strong>ID:</strong> ' . htmlspecialchars($id) . '</p>'; // Mostrar id
echo '<p><strong>Nombre:</strong> ' . htmlspecialchars($nombre) . '</p>'; // Mostrar nombre
echo '<p><strong>Hábitat:</strong> ' . htmlspecialchars($habitat) . '</p>'; // Mostrar hábitat

// Características: procesamos la cadena separada por comas
if (!empty($caracteristicas_raw)) {
    $arr = explode(',', $caracteristicas_raw); // Separar por comas
    echo '<h3>Características</h3>'; // Título
    echo '<ul>'; // Lista
    foreach ($arr as $c) {
        echo '<li>' . htmlspecialchars(trim($c)) . '</li>'; // Cada característica limpiada
    }
    echo '</ul>'; // Fin lista
}

// Mostramos la imagen subida (si existe ruta)
if (!empty($imagen_url)) {
    echo '<h3>Imagen subida</h3>'; // Título
    echo '<img src="' . htmlspecialchars($imagen_url) . '" alt="' . htmlspecialchars($nombre) . '">'; // Imagen
}

// Enlace al PDF subido
if (!empty($pdf_url)) {
    echo '<p><a href="' . htmlspecialchars($pdf_url) . '" target="_blank" rel="noopener">Ver PDF subido</a></p>'; // Enlace PDF
}

// Enlace volver al inicio o registrar otro
echo '<p><a href="/index.php">Volver al inicio</a> | <a href="/register-animal.php">Registrar otro animal</a></p>'; // Enlaces de navegación

// Incluimos footer
require_once __DIR__ . '/../includes/footer.php'; // Footer
?>
