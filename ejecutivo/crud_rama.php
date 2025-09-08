<?php
require_once '../includes/conexion.php';
require_once 'inc/funciones.php';

// Procesar operaciones CRUD
$mensaje = '';
$error = '';

// Crear nuevo registro
if (isset($_POST['crear'])) {
    $nombre_rama = sanitizar($_POST['nombre_rama']);
    $nivel_rama = sanitizar($_POST['nivel_rama']);
    $ciclo_rama = sanitizar($_POST['ciclo_rama']);
    $modalidad_rama = sanitizar($_POST['modalidad_rama']);
    
    $sql = "INSERT INTO rama (nombre_rama, nivel_rama, ciclo_rama, modalidad_rama) 
            VALUES ('$nombre_rama', '$nivel_rama', '$ciclo_rama', '$modalidad_rama')";
    
    if ($conn->query($sql) === TRUE) {
        $mensaje = "Registro creado exitosamente";
    } else {
        $error = "Error al crear registro: " . $conn->error;
    }
}

// Actualizar registro existente
if (isset($_POST['actualizar'])) {
    $id_rama = sanitizar($_POST['id_rama']);
    $nombre_rama = sanitizar($_POST['nombre_rama']);
    $nivel_rama = sanitizar($_POST['nivel_rama']);
    $ciclo_rama = sanitizar($_POST['ciclo_rama']);
    $modalidad_rama = sanitizar($_POST['modalidad_rama']);
    
    $sql = "UPDATE rama SET nombre_rama='$nombre_rama', nivel_rama='$nivel_rama', 
            ciclo_rama='$ciclo_rama', modalidad_rama='$modalidad_rama' 
            WHERE id_rama=$id_rama";
    
    if ($conn->query($sql) === TRUE) {
        $mensaje = "Registro actualizado exitosamente";
    } else {
        $error = "Error al actualizar registro: " . $conn->error;
    }
}

// Eliminar registro
if (isset($_GET['eliminar'])) {
    $id_rama = sanitizar($_GET['eliminar']);
    
    $sql = "DELETE FROM rama WHERE id_rama=$id_rama";
    
    if ($conn->query($sql) === TRUE) {
        $mensaje = "Registro eliminado exitosamente";
    } else {
        $error = "Error al eliminar registro: " . $conn->error;
    }
}

// Obtener registros existentes
$result = obtenerRamas();

require_once 'inc/header.php';
?>

<h2>Gestión de Ramas Académicas</h2>

<?php
if (!empty($mensaje)) {
    echo mostrarMensaje('exito', $mensaje);
}

if (!empty($error)) {
    echo mostrarMensaje('error', $error);
}
?>

<button class="btn btn-primary" onclick="abrirModalCrear()">Agregar Nueva Rama</button>

<h3>Lista de Ramas</h3>
<?php if ($result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Nivel</th>
                <th>Ciclo</th>
                <th>Modalidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id_rama']; ?></td>
                <td><?php echo $row['nombre_rama']; ?></td>
                <td><?php echo ucfirst($row['nivel_rama']); ?></td>
                <td><?php echo $row['ciclo_rama']; ?></td>
                <td><?php echo ucfirst($row['modalidad_rama']); ?></td>
                <td>
                    <button class="btn btn-edit" onclick="abrirModalEditar(<?php echo $row['id_rama']; ?>)">Editar</button>
                    <button class="btn btn-delete" onclick="confirmarEliminacion(<?php echo $row['id_rama']; ?>)">Eliminar</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No hay registros en la tabla Rama.</p>
<?php endif; ?>

<!-- Modal para Crear -->
<div id="modalCrear" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Agregar Nueva Rama</h2>
            <span class="close" onclick="cerrarModal('modalCrear')">&times;</span>
        </div>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nombre_rama">Nombre:</label>
                <input type="text" id="nombre_rama" name="nombre_rama" required>
            </div>
            
            <div class="form-group">
                <label for="nivel_rama">Nivel:</label>
                <select id="nivel_rama" name="nivel_rama" required>
                    <option value="">Seleccionar nivel</option>
                    <option value="bachillerato">Bachillerato</option>
                    <option value="licenciatura">Licenciatura</option>
                    <option value="postgrado">Postgrado</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="ciclo_rama">Ciclo:</label>
                <input type="text" id="ciclo_rama" name="ciclo_rama">
            </div>
            
            <div class="form-group">
                <label for="modalidad_rama">Modalidad:</label>
                <select id="modalidad_rama" name="modalidad_rama" required>
                    <option value="">Seleccionar modalidad</option>
                    <option value="presencial">Presencial</option>
                    <option value="online">Online</option>
                </select>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn" onclick="cerrarModal('modalCrear')">Cancelar</button>
                <button type="submit" name="crear" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Editar -->
<div id="modalEditar" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Editar Rama</h2>
            <span class="close" onclick="cerrarModal('modalEditar')">&times;</span>
        </div>
        <form method="POST" action="">
            <input type="hidden" id="id_rama_editar" name="id_rama">
            <div class="form-group">
                <label for="nombre_rama_editar">Nombre:</label>
                <input type="text" id="nombre_rama_editar" name="nombre_rama" required>
            </div>
            
            <div class="form-group">
                <label for="nivel_rama_editar">Nivel:</label>
                <select id="nivel_rama_editar" name="nivel_rama" required>
                    <option value="">Seleccionar nivel</option>
                    <option value="bachillerato">Bachillerato</option>
                    <option value="licenciatura">Licenciatura</option>
                    <option value="postgrado">Postgrado</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="ciclo_rama_editar">Ciclo:</label>
                <input type="text" id="ciclo_rama_editar" name="ciclo_rama">
            </div>
            
            <div class="form-group">
                <label for="modalidad_rama_editar">Modalidad:</label>
                <select id="modalidad_rama_editar" name="modalidad_rama" required>
                    <option value="">Seleccionar modalidad</option>
                    <option value="presencial">Presencial</option>
                    <option value="online">Online</option>
                </select>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn" onclick="cerrarModal('modalEditar')">Cancelar</button>
                <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Funciones para controlar los modales
    function abrirModalCrear() {
        document.getElementById('modalCrear').style.display = 'block';
    }
    
    function abrirModalEditar(id) {
    console.log("Intentando editar ID: " + id);
    
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState === 4) {
            if (this.status === 200) {
                try {
                    // VERIFICAR SI LA RESPUESTA ES JSON VÁLIDO
                    if (this.responseText.trim() === "") {
                        throw new Error("Respuesta vacía del servidor");
                    }
                    
                    var datos = JSON.parse(this.responseText);
                    
                    // SI HAY ERROR EN LA RESPUESTA JSON
                    if (datos.error) {
                        alert("Error: " + datos.error);
                        return;
                    }
                    
                    // LLENAR EL FORMULARIO
                    document.getElementById('id_rama_editar').value = datos.id_rama;
                    document.getElementById('nombre_rama_editar').value = datos.nombre_rama;
                    document.getElementById('nivel_rama_editar').value = datos.nivel_rama;
                    document.getElementById('ciclo_rama_editar').value = datos.ciclo_rama;
                    document.getElementById('modalidad_rama_editar').value = datos.modalidad_rama;
                    
                    // MOSTRAR MODAL
                    document.getElementById('modalEditar').style.display = 'block';
                    
                } catch (e) {
                    console.error("Error parsing JSON:", e, "Response:", this.responseText);
                    alert("Error al procesar los datos. Respuesta del servidor: " + this.responseText.substring(0, 100));
                }
            } else {
                console.error("HTTP Error:", this.status, "Response:", this.responseText);
                alert("Error del servidor (Código: " + this.status + ")");
            }
        }
    };
    
    xhr.open("GET", "server/obtener_rama.php?id=" + id, true);
    xhr.send();
}
    
    function cerrarModal(idModal) {
        document.getElementById(idModal).style.display = 'none';
    }
    
    function confirmarEliminacion(id) {
        if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
            window.location.href = '?eliminar=' + id;
        }
    }
    
    // Cerrar modal al hacer clic fuera del contenido
    window.onclick = function(event) {
        var modals = document.getElementsByClassName('modal');
        for (var i = 0; i < modals.length; i++) {
            if (event.target == modals[i]) {
                modals[i].style.display = "none";
            }
        }
    }
</script>

<?php
require_once 'inc/footer.php';
$conn->close();
?>