<?php
// Definimos el título de la página
$titulo_pagina = "Inicio - Enciclopedia de Animales";

// Incluimos cabecera
include '../includes/header.php';

// Importamos los datos
require_once '../data/datos.php';
?>

    <h2>Categorías de Animales</h2>
    <ul>
        <?php foreach ($categorias as $categoria): ?>
            <li>
                <a href="category.php?id=<?php echo (int)$categoria['id']; ?>">
                    <?php echo htmlspecialchars($categoria['nombre'], ENT_QUOTES, 'UTF-8'); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>



<?php 
// Incluimos el footer
include '../includes/header.php'; 
?>