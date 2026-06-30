<?php
/*
=========================================================
PROYECTO : ANITA SPORT ERP
MÓDULO   : USUARIOS
ARCHIVO  : listar.php

FUNCIÓN:
Muestra todos los usuarios registrados en el sistema.

HISTORIAL DE MODIFICACIONES:
[01/07/2026]
SPRINT 7 - MODIFICACIÓN 09
✔ Se creó el listado de usuarios.
✔ Se agregó la clase "tabla-dinamica" para DataTables.
✔ Se usa el diseño del panel administrativo.
=========================================================
*/

// Iniciamos sesión
session_start();

// Protegemos la página
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit();
}

// Conectamos con la base de datos
include "../../config/conexion.php";

// Consultamos usuarios
$usuarios = $conexion->query("SELECT * FROM usuarios ORDER BY id DESC");

// Header del panel
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

                    <!-- SPRINT 7 - MODIFICACIÓN 09
                         tabla-dinamica activa buscador,
                         paginación, ordenamiento y exportación.
                    -->
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
                                    <td><?php echo $usuario["rol"]; ?></td>

                                    <td>
                                        <a href="editar.php?id=<?php echo $usuario["id"]; ?>" class="btn btn-warning btn-sm">
                                            Editar
                                        </a>

                                        <a 
                                            href="eliminar.php?id=<?php echo $usuario["id"]; ?>" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Estás seguro de eliminar este usuario?');">
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

<?php include "../includes/footer.php"; ?>