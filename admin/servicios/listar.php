<?php
/*
=========================================================
PROYECTO : ANITA SPORT ERP
MÓDULO   : SERVICIOS
ARCHIVO  : listar.php

FUNCIÓN:
Muestra el listado completo de servicios registrados.

HISTORIAL DE MODIFICACIONES:
[01/07/2026]
SPRINT 7 - MODIFICACIÓN 07
✔ Se agregó la clase "tabla-dinamica" para integrar DataTables.
✔ Se eliminó código duplicado del archivo.
✔ Se usa el header y footer del panel administrativo.
=========================================================
*/

// Iniciamos la sesión del administrador
session_start();

// Si no hay sesión activa, redirigimos al login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit();
}

// Conectamos con la base de datos
include "../../config/conexion.php";

// Consultamos todos los servicios
$servicios = $conexion->query("SELECT * FROM servicios ORDER BY id DESC");

// Incluimos el header del panel administrativo
// Aquí se cargan Bootstrap, Bootstrap Icons y DataTables CSS
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
                    Servicios
                </h2>

                <a href="agregar.php" class="btn btn-danger">
                    Agregar servicio
                </a>

            </div>

            <div class="card shadow border-0">

                <div class="card-body">

                    <!-- SPRINT 7 - MODIFICACIÓN 07
                         La clase "tabla-dinamica" activa DataTables:
                         buscador, paginación, ordenamiento y exportación.
                    -->
                    <table class="table table-bordered table-hover align-middle tabla-dinamica">

                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th width="180">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php while ($servicio = $servicios->fetch_assoc()) { ?>

                                <tr>
                                    <td><?php echo $servicio["id"]; ?></td>

                                    <td><?php echo $servicio["titulo"]; ?></td>

                                    <td><?php echo $servicio["descripcion"]; ?></td>

                                    <td>
                                        <?php if ($servicio["estado"] == 1) { ?>
                                            <span class="badge bg-success">Activo</span>
                                        <?php } else { ?>
                                            <span class="badge bg-secondary">Inactivo</span>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <a href="editar.php?id=<?php echo $servicio["id"]; ?>" class="btn btn-warning btn-sm">
                                            Editar
                                        </a>

                                        <a 
                                            href="eliminar.php?id=<?php echo $servicio["id"]; ?>" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Estás seguro de eliminar este servicio?');">
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
// Aquí se cargan Bootstrap JS y DataTables JS
include "../includes/footer.php";
?>