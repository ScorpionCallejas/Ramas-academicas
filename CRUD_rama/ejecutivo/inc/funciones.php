<?php
// Función para sanitizar datos de entrada
function sanitizar($dato) {
    global $conn;
    return $conn->real_escape_string(htmlspecialchars(trim($dato)));
}

// Función para mostrar mensajes
function mostrarMensaje($tipo, $texto) {
    $clase = $tipo == 'exito' ? 'exito' : 'error';
    return "<div class='mensaje $clase'>$texto</div>";
}

// Función para obtener todas las ramas
function obtenerRamas() {
    global $conn;
    $sql = "SELECT * FROM rama ORDER BY id_rama DESC";
    $result = $conn->query($sql);
    return $result;
}

// Función para obtener una rama por ID
function obtenerRamaPorId($id) {
    global $conn;
    $id = sanitizar($id);
    $sql = "SELECT * FROM rama WHERE id_rama = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}
?>