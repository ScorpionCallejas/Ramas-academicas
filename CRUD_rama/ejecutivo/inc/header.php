<?php
include 'cabeceras.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_sistema; ?> - Gestión de Ramas</title>
    
    <!-- CSS del loader -->
    <style>
        .loader {
            border: 5px solid #f3f3f3;
            border-radius: 50%;
            border-top: 5px solid #3498db;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
            margin: 20px auto;
            display: none;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    
    <!-- Hoja de estilos principal -->
    <link rel="stylesheet" href="../ejecutivo/assets/css/estilo_rama.css">
</head>
<body>
    <div class="loader" id="loader"></div>
    <div class="container">
        <main>