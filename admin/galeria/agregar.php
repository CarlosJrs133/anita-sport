<?php
/*
===========================================
ANITA SPORT
MÓDULO: GALERÍA
Archivo: agregar.php

FUNCIÓN:
Permite subir una imagen al servidor
y registrar sus datos en la base de datos.
===========================================
*/

// Iniciamos sesión
session_start();

// Si no hay usuario logueado, volvemos al login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit();
}

// Conectamos con la base de datos
include "../../config/conexion.php";

// Variables para mostrar mensajes
$error = "";
$exito = "";

// Verificamos si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recibimos datos del formulario
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $estado = $_POST["estado"];

    // Recibimos la imagen
    $imagen = $_FILES["imagen"]["name"];
    $temporal = $_FILES["imagen"]["tmp_name"];

    // Validamos campos obligatorios
    if ($titulo == "" || $imagen == "") {
        $error = "El título y la imagen son obligatorios.";
    } else {

        // Creamos un nombre único para evitar que se repitan imágenes
        $nombreImagen = time() . "_" . $imagen;

        // Ruta donde se guardará la imagen
        $rutaDestino = "../uploads/" . $nombreImagen;

        // Movemos la imagen desde la carpeta temporal hacia uploads
        if (move_uploaded_file($temporal, $rutaDestino)) {

            // Guardamos los datos en la base de datos
            $sql = "INSERT INTO galeria (titulo, descripcion, imagen, estado)
                    VALUES (?, ?, ?, ?)";

            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sssi", $titulo, $descripcion, $nombreImagen, $estado);

            if ($stmt->execute()) {
                $exito = "Imagen agregada correctamente.";
            } else {
                $error = "Error al guardar en la base de datos.";
            }

        } else {
            $error = "Error al subir la imagen.";
        }
    }
}

// Incluimos el encabezado del panel
include "../includes/header.php";
?>

<div class="d-flex">

    <!-- Menú lateral -->
    <?php include "../includes/sidebar.php"; ?>

    <div class="flex-grow-1">

        <!-- Barra superior -->
        <?php include "../includes/topbar.php"; ?>

        <div class="container py-4">

            <div class="card shadow border-0">

                <div class="card-body p-4">

                    <h2 class="fw-bold mb-4">
                        Agregar Imagen
                    </h2>

                    <!-- Mensaje de error -->
                    <?php if ($error != "") { ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php } ?>

                    <!-- Mensaje de éxito -->
                    <?php if ($exito != "") { ?>
                        <div class="alert alert-success">
                            <?php echo $exito; ?>
                        </div>
                    <?php } ?>

                    <!-- Formulario para subir imagen -->
                    <form method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label class="form-label">Título</label>
                            <input type="text" name="titulo" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="4"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Imagen</label>
                            <input type="file" name="imagen" class="form-control" accept="image/*" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Estado</label>
                            <select name="estado" class="form-select">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-danger">
                            Guardar Imagen
                        </button>

                        <a href="listar.php" class="btn btn-secondary">
                            Volver
                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php
// Incluimos cierre del panel
include "../includes/footer.php";
?>