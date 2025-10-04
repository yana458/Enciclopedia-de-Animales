<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
         <?php 
            if (isset($titulo_pagina) && !empty($titulo_pagina)) {
                echo htmlspecialchars($titulo_pagina, ENT_QUOTES, 'UTF-8');
            } else {
                echo "La Enciclopedia de Animales"; 
            }
         ?>
    </title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>

    <header>
        <h1>Enciclopedia de Animales</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="register-animal.php">Registrar Nuevo Animal</a>
        </nav>
    </header>
    
<main class="container">

