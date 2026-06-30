<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit();
}

include "../../config/conexion.php";

$servicios = $conexion->query("SELECT * FROM servicios ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Servicios | ANITA SPORT</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold">ANITA SPORT | Servicios</span>

        <a href="../dashboard.php" class="btn btn-outline-light btn-sm">
            Volver al dashboard
        </a>
    </div>
</nav>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Servicios</h2>

        <a href="agregar.php" class="btn btn-danger">
            Agregar servicio
        </a>
    </div>

    <div class="card shadow border-0">
        <div class="card-body">

            <table class="table table-bordered table-hover align-middle">
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

                                <a href="eliminar.php?id=<?php echo $servicio["id"]; ?>" class="btn btn-danger btn-sm">
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

</body>
</html>