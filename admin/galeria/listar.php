<?php
/*
=========================================================
PROYECTO : ANITA SPORT ERP
MÓDULO   : GALERÍA
ARCHIVO  : listar.php

FUNCIÓN:
Muestra todas las imágenes registradas en la galería.

HISTORIAL DE MODIFICACIONES:
[01/07/2026]
SPRINT 7 - MODIFICACIÓN 08
✔ Se agregó la clase "tabla-dinamica" para integrar DataTables.
✔ Se mejoró la visualización del estado con badges.
✔ Se agregó confirmación antes de eliminar.
✔ Se mantiene el diseño del panel administrativo.
=========================================================
*/

// Iniciamos sesión del administrador
session_start();

// Si no hay sesión activa, redirigimos al login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit();
}

// Conectamos con la base de datos
include "../../config/conexion.php";

// Consultamos todas las imágenes de la galería
$sql = "SELECT * FROM galeria ORDER BY id DESC";
$galeria = $conexion->query($sql);

// Incluimos el header del panel administrativo
include "../includes/header.php";
?>

<div class="d-flex">

    <!-- Menú lateral del panel -->
    <?php include "../includes/sidebar.php"; ?>

    <div class="flex-grow-1">

        <!-- Barra superior del panel -->
        <?php include "../includes/topbar.php"; ?>

        <main class="p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h2 class="fw-bold">
                    Galería
                </h2>

                <a href="agregar.php" class="btn btn-danger">
                    + Agregar Imagen
                </a>

            </div>

            <div class="card shadow border-0">

                <div class="card-body">

                    <!-- SPRINT 7 - MODIFICACIÓN 08
                         La clase "tabla-dinamica" activa DataTables:
                         buscador, paginación, ordenamiento y exportación.
                    -->
                    <table class="table table-hover table-bordered align-middle tabla-dinamica">

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

                            <?php while ($fila = $galeria->fetch_assoc()) { ?>

                                <tr>
                                    <td><?php echo $fila["id"]; ?></td>

                                    <td><?php echo $fila["titulo"]; ?></td>

                                    <td>
                                        <?php if ($fila["imagen"] != "") { ?>
                                            <img
                                                src="../uploads/<?php echo $fila["imagen"]; ?>"
                                                width="90"
                                                class="rounded shadow-sm">
                                        <?php } else { ?>
                                            <span class="text-muted">Sin imagen</span>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?php if ($fila["estado"] == 1) { ?>
                                            <span class="badge bg-success">Activo</span>
                                        <?php } else { ?>
                                            <span class="badge bg-secondary">Inactivo</span>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <a href="editar.php?id=<?php echo $fila["id"]; ?>" class="btn btn-warning btn-sm">
                                            Editar
                                        </a>

                                        <a 
                                            href="eliminar.php?id=<?php echo $fila["id"]; ?>" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Estás seguro de eliminar esta imagen?');">
                                            Eliminar
                                        </a>
                                    </td>
                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </main>

    </div>

</div>

<?php
// Incluimos el footer del panel administrativo
include "../includes/footer.php";
?>