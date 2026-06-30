<?php
/*
===========================================
ANITA SPORT
MÓDULO: GALERÍA
Archivo: listar.php

FUNCIÓN:
Mostrar todas las imágenes registradas
en la base de datos.
===========================================
*/

// Iniciar sesión
session_start();

// Verificar si el usuario inició sesión
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit();
}

// Conexión a la base de datos
include "../../config/conexion.php";

// Obtener todas las imágenes
$sql = "SELECT * FROM galeria ORDER BY id DESC";
$galeria = $conexion->query($sql);

// Encabezado HTML
include "../includes/header.php";
?>

<div class="d-flex">

    <!-- Menú lateral -->
    <?php include "../includes/sidebar.php"; ?>

    <div class="flex-grow-1">

        <!-- Barra superior -->
        <?php include "../includes/topbar.php"; ?>

        <div class="container py-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h2>Galería</h2>

                <a href="agregar.php" class="btn btn-danger">
                    + Agregar Imagen
                </a>

            </div>

            <div class="card shadow">

                <div class="card-body">

                    <table class="table table-hover">

                        <thead class="table-dark">

                            <tr>

                                <th>ID</th>
                                <th>Título</th>
                                <th>Imagen</th>
                                <th>Estado</th>
                                <th>Acciones</th>

                            </tr>

                        </thead>

                        <tbody>

                        <?php while($fila = $galeria->fetch_assoc()){ ?>

                            <tr>

                                <td><?= $fila["id"] ?></td>

                                <td><?= $fila["titulo"] ?></td>

                                <td>

                                    <?php if($fila["imagen"] != ""){ ?>

                                        <img
                                            src="../uploads/<?= $fila["imagen"] ?>"
                                            width="90">

                                    <?php } ?>

                                </td>

                                <td>

                                    <?php
                                    echo $fila["estado"] == 1
                                    ? "Activo"
                                    : "Inactivo";
                                    ?>

                                </td>

                                <td>

                                    <a href="editar.php?id=<?= $fila["id"] ?>" class="btn btn-warning btn-sm">
                                        Editar
                                    </a>

                                    <a href="eliminar.php?id=<?= $fila["id"] ?>" class="btn btn-danger btn-sm">
                                        Eliminar
                                    </a>

                                </td>

                            </tr>

                        <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>