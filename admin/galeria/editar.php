<?php
/*
=========================================================
PROYECTO : ANITA SPORT ERP
MÓDULO   : GALERÍA
ARCHIVO  : editar.php

FUNCIÓN:
Permite editar título, descripción, estado e imagen
de un registro de la galería.

MODIFICACIONES:
✔ Se busca la imagen por ID.
✔ Se permite actualizar datos.
✔ Se permite cambiar imagen si el usuario sube una nueva.
✔ Se mantiene la imagen anterior si no se sube otra.
=========================================================
*/

// Iniciamos sesión
session_start();

// Protegemos la página: si no hay sesión, vuelve al login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit();
}

// Conectamos con la base de datos
include "../../config/conexion.php";

// Recibimos el ID por la URL
$id = $_GET["id"];

// Buscamos el registro actual
$sql = "SELECT * FROM galeria WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$imagenActual = $resultado->fetch_assoc();

// Si no existe el registro, volvemos al listado
if (!$imagenActual) {
    header("Location: listar.php");
    exit();
}

// Si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recibimos datos del formulario
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $estado = $_POST["estado"];

    // Por defecto mantenemos la imagen anterior
    $nombreImagen = $imagenActual["imagen"];

    // Si el usuario sube una nueva imagen
    if ($_FILES["imagen"]["name"] != "") {

        // Nombre original de la imagen
        $imagen = $_FILES["imagen"]["name"];

        // Ruta temporal
        $temporal = $_FILES["imagen"]["tmp_name"];

        // Creamos nombre único
        $nombreImagen = time() . "_" . $imagen;

        // Ruta destino
        $rutaDestino = "../uploads/" . $nombreImagen;

        // Movemos la nueva imagen a uploads
        move_uploaded_file($temporal, $rutaDestino);
    }

    // Actualizamos el registro en la base de datos
    $sql = "UPDATE galeria 
            SET titulo = ?, descripcion = ?, imagen = ?, estado = ?
            WHERE id = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssii", $titulo, $descripcion, $nombreImagen, $estado, $id);

    if ($stmt->execute()) {
        header("Location: listar.php");
        exit();
    }
}

// Incluimos el encabezado del panel
include "../includes/header.php";
?>

<div class="d-flex">

    <!-- Sidebar -->
    <?php include "../includes/sidebar.php"; ?>

    <div class="flex-grow-1">

        <!-- Topbar -->
        <?php include "../includes/topbar.php"; ?>

        <div class="container py-4">

            <div class="card shadow border-0">

                <div class="card-body p-4">

                    <h2 class="fw-bold mb-4">
                        Editar Imagen
                    </h2>

                    <form method="POST" enctype="multipart/form-data">

                        <!-- Campo título -->
                        <div class="mb-3">
                            <label class="form-label">Título</label>
                            <input 
                                type="text" 
                                name="titulo" 
                                class="form-control"
                                value="<?php echo $imagenActual["titulo"]; ?>"
                                required>
                        </div>

                        <!-- Campo descripción -->
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea 
                                name="descripcion" 
                                class="form-control" 
                                rows="4"><?php echo $imagenActual["descripcion"]; ?></textarea>
                        </div>

                        <!-- Imagen actual -->
                        <div class="mb-3">
                            <label class="form-label">Imagen actual</label><br>

                            <img 
                                src="../uploads/<?php echo $imagenActual["imagen"]; ?>" 
                                width="160"
                                class="rounded shadow">
                        </div>

                        <!-- Nueva imagen opcional -->
                        <div class="mb-3">
                            <label class="form-label">Cambiar imagen</label>
                            <input 
                                type="file" 
                                name="imagen" 
                                class="form-control"
                                accept="image/*">
                        </div>

                        <!-- Estado -->
                        <div class="mb-4">
                            <label class="form-label">Estado</label>

                            <select name="estado" class="form-select">
                                <option value="1" <?php if ($imagenActual["estado"] == 1) echo "selected"; ?>>
                                    Activo
                                </option>

                                <option value="0" <?php if ($imagenActual["estado"] == 0) echo "selected"; ?>>
                                    Inactivo
                                </option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-danger">
                            Actualizar Imagen
                        </button>

                        <a href="listar.php" class="btn btn-secondary">
                            Cancelar
                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>