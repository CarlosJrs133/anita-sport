<?php
/*
===========================================
ANITA SPORT
Archivo: dashboard.php
Descripción: Página principal del panel administrativo
===========================================
*/

// Iniciamos la sesión para poder leer los datos del usuario logueado
session_start();

// Si no existe sesión, mandamos al usuario al login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

// Conectamos con la base de datos
include "../config/conexion.php";

// Contamos cuántos servicios hay registrados
$totalServicios = $conexion->query("SELECT COUNT(*) AS total FROM servicios")->fetch_assoc()["total"];

// Contamos cuántas imágenes hay en la galería
$totalGaleria = $conexion->query("SELECT COUNT(*) AS total FROM galeria")->fetch_assoc()["total"];

// Contamos cuántos pedidos hay registrados
$totalPedidos = $conexion->query("SELECT COUNT(*) AS total FROM pedidos")->fetch_assoc()["total"];

// Contamos cuántos usuarios hay registrados
$totalUsuarios = $conexion->query("SELECT COUNT(*) AS total FROM usuarios")->fetch_assoc()["total"];

// Incluimos el encabezado HTML del panel
include "includes/header.php";
?>

<!-- Contenedor general del panel -->
<div class="d-flex">

    <!-- Menú lateral izquierdo -->
    <?php include "includes/sidebar.php"; ?>

    <!-- Contenido principal -->
    <div class="flex-grow-1">

        <!-- Barra superior -->
        <?php include "includes/topbar.php"; ?>

        <!-- Área de contenido -->
        <main class="p-4">

            <!-- Título del dashboard -->
            <h2 class="fw-bold mb-4">
                Dashboard
            </h2>

            <!-- Fila de tarjetas estadísticas -->
            <div class="row">

                <!-- Tarjeta Servicios -->
                <div class="col-md-3 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">

                            <i class="bi bi-scissors fs-1 text-danger"></i>

                            <h5 class="mt-3">
                                Servicios
                            </h5>

                            <h2>
                                <?php echo $totalServicios; ?>
                            </h2>

                            <a href="servicios/listar.php" class="btn btn-outline-danger btn-sm">
                                Ver servicios
                            </a>

                        </div>
                    </div>
                </div>

                <!-- Tarjeta Galería -->
                <div class="col-md-3 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">

                            <i class="bi bi-images fs-1 text-danger"></i>

                            <h5 class="mt-3">
                                Galería
                            </h5>

                            <h2>
                                <?php echo $totalGaleria; ?>
                            </h2>

                            <a href="galeria/listar.php" class="btn btn-outline-danger btn-sm">
                                Ver galería
                            </a>

                        </div>
                    </div>
                </div>

                <!-- Tarjeta Pedidos -->
                <div class="col-md-3 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">

                            <i class="bi bi-box-seam fs-1 text-danger"></i>

                            <h5 class="mt-3">
                                Pedidos
                            </h5>

                            <h2>
                                <?php echo $totalPedidos; ?>
                            </h2>

                            <a href="pedidos/listar.php" class="btn btn-outline-danger btn-sm">
                                Ver pedidos
                            </a>

                        </div>
                    </div>
                </div>

                <!-- Tarjeta Usuarios -->
                <div class="col-md-3 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">

                            <i class="bi bi-people fs-1 text-danger"></i>

                            <h5 class="mt-3">
                                Usuarios
                            </h5>

                            <h2>
                                <?php echo $totalUsuarios; ?>
                            </h2>

                            <a href="usuarios/listar.php" class="btn btn-outline-danger btn-sm">
                                Ver usuarios
                            </a>

                        </div>
                    </div>
                </div>

            </div>

        </main>

    </div>

</div>

<?php
// Incluimos los scripts y cierre del HTML
include "includes/footer.php";
?>