<?php
// server/obtener_rama.php

// LIMPIAR CUALQUIER SALIDA ANTICIPADA
if (ob_get_length()) ob_clean();

// HEADERS PRIMERO, ANTES DE CUALQUIER SALIDA
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

// INCLUIR ARCHIVOS DESPUÉS DE LOS HEADERS
// require_once '/opt/lampp/htdocs/template_sicam-master/includes/conexion.php';

require_once '../../includes/conexion.php';

// VERIFICAR SI HAY ERRORES DE CONEXIÓN
if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode(['error' => 'Error de conexión a la base de datos']));
}

// VERIFICAR SI SE PROPORCIONÓ ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400);
    die(json_encode(['error' => 'ID no proporcionado']));
}

// SANITIZAR Y VALIDAR EL ID
$id = intval($_GET['id']);
if ($id <= 0) {
    http_response_code(400);
    die(json_encode(['error' => 'ID no válido']));
}

try {
    // OBTENER LOS DATOS
    $stmt = $conn->prepare("SELECT * FROM rama WHERE id_rama = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $rama = $result->fetch_assoc();
        echo json_encode($rama);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Rama no encontrada']);
    }
    
    $stmt->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor: ' . $e->getMessage()]);
}

$conn->close();
exit(); // ASEGURAR QUE NO HAY MÁS SALIDA
?>