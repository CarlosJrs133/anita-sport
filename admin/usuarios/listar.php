<?php
/*
=========================================================
PROYECTO : ANITA SPORT ERP
MÓDULO   : USUARIOS
ARCHIVO  : listar.php

FUNCIÓN:
Muestra todos los usuarios registrados en el sistema.

HISTORIAL:
[01/07/2026]
SPRINT 8 - MEJORA 01
✔ Se mejoró la visualización del rol.
✔ admin se muestra como Administrador.
✔ editor se muestra como Editor.
✔ Se mantiene DataTables.
=========================================================
*/

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit();
}

include "../../config/conexion.php";

$usuarios = $conexion->query("SELECT * FROM usuarios ORDER BY id DESC");

include "../includes/header.php";
?>

<div class="d-flex">

    <?php include "../includes/sidebar.php"; ?>

    <div class="flex-grow-1">

        <?php include "../includes/topbar.php"; ?>

        <main class="p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h2 class="fw-bold">Usuarios</h2>

                <a href="agregar.php" class="btn btn-danger">
                    Agregar usuario
                </a>

            </div>

            <div class="card shadow border-0">

                <div class="card-body">

                    <table class="table table-bordered table-hover align-middle tabla-dinamica">

                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php while ($usuario = $usuarios->fetch_assoc()) { ?>

                                <tr>

                                    <td><?php echo $usuario["id"]; ?></td>

                                    <td><?php echo $usuario["nombre"]; ?></td>

                                    <td><?php echo $usuario["correo"]; ?></td>

                                    <td>
                                        <!-- ===========================================
                                             SPRINT 8 - MEJORA 01
                                             Mostramos el rol con texto más claro.
                                        =========================================== -->

                                        <?php if ($usuario["rol"] == "admin") { ?>

                                            <span class="badge bg-danger">
                                                Administrador
                                            </span>

                                        <?php } elseif ($usuario["rol"] == "editor") { ?>

                                            <span class="badge bg-primary">
                                                Editor
                                            </span>

                                        <?php } else { ?>

                                            <span class="badge bg-secondary">
                                                Sin rol
                                            </span>

                                        <?php } ?>
                                    </td>

                                    <td>

                                        <a href="editar.php?id=<?php echo $usuario["id"]; ?>" class="btn btn-warning btn-sm">
                                            Editar
                                        </a>

                                        <?php if ($usuario["id"] != $_SESSION["usuario_id"]) { ?>

                                            <a 
                                                href="eliminar.php?id=<?php echo $usuario["id"]; ?>" 
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Estás seguro de eliminar este usuario?');">
                                                Eliminar
                                            </a>

                                        <?php } else { ?>

                                            <span class="badge bg-secondary">
                                                Usuario actual
                                            </span>

                                        <?php } ?>

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

<?php include "../includes/footer.php"; ?>