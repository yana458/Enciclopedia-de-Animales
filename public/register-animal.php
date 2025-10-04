<?php // Abrimos PHP
// Título de la página
$titulo_pagina = 'Registrar Nuevo Animal'; // Título

// Incluimos header
require_once __DIR__ . '/../includes/header.php'; // Header

// Incluimos datos para generar el select de categorías
require_once __DIR__ . '/../data/datos.php'; // Datos (para el select)
?>

<!-- Formulario HTML: enviará por POST a process-animal.php y permite subida de archivos -->
<h2>Registrar Nuevo Animal</h2> <!-- Título del formulario -->

<form action="/process-animal.php" method="post" enctype="multipart/form-data"> <!-- Formulario -->
    <div class="form-group"> <!-- Grupo: categoría -->
        <label for="categoria">Categoría</label> <!-- Label -->
        <select name="categoria" id="categoria" required> <!-- Select dinámico de categorías -->
            <option value="">-- Selecciona una categoría --</option> <!-- Opción por defecto -->
            <?php
            // Recorremos $categorias para llenar el select
            if (isset($categorias) && is_array($categorias)) {
                foreach ($categorias as $c) {
                    $c_id = isset($c['id']) ? $c['id'] : ''; // ID
                    $c_nombre = isset($c['nombre']) ? $c['nombre'] : 'Categoría sin nombre'; // Nombre
                    echo '<option value="' . htmlspecialchars($c_id) . '">' . htmlspecialchars($c_nombre) . '</option>'; // Opción por categoría
                }
            }
            ?>
        </select>
    </div>

    <div class="form-group"> <!-- Grupo: id del animal -->
        <label for="id">ID del animal (número)</label> <!-- Label -->
        <input type="number" name="id" id="id" required> <!-- Input numérico para el ID -->
    </div>

    <div class="form-group"> <!-- Grupo: nombre -->
        <label for="nombre">Nombre</label> <!-- Label -->
        <input type="text" name="nombre" id="nombre" required> <!-- Input texto -->
    </div>

    <div class="form-group"> <!-- Grupo: hábitat -->
        <label for="habitat">Hábitat</label> <!-- Label -->
        <input type="text" name="habitat" id="habitat" required> <!-- Input texto -->
    </div>

    <div class="form-group"> <!-- Grupo: características -->
        <label for="caracteristicas">Características (separadas por comas)</label> <!-- Label -->
        <textarea name="caracteristicas" id="caracteristicas" rows="4" placeholder="Característica 1, Característica 2"></textarea> <!-- Textarea -->
    </div>

    <div class="form-group"> <!-- Grupo: imagen -->
        <label for="imagen">Imagen (archivo)</label> <!-- Label -->
        <input type="file" name="imagen" id="imagen" accept="image/*" required> <!-- Input file para imagen -->
    </div>

    <div class="form-group"> <!-- Grupo: PDF -->
        <label for="pdf">PDF con descripción</label> <!-- Label -->
        <input type="file" name="pdf" id="pdf" accept="application/pdf" required> <!-- Input file para PDF -->
    </div>

    <button type="submit">Registrar animal</button> <!-- Botón de envío -->
</form>

<?php
// Incluimos footer al final
require_once __DIR__ . '/../includes/footer.php'; // Footer
?>
