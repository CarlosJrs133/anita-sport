<?php
/*
===========================================
ANITA SPORT
Archivo: dashboard.php
Descripción: Página principal del panel administrativo

SPRINT 6 - MODIFICACIONES:
✔ Se agregaron estadísticas de pedidos por estado.
✔ Se mantienen los conteos generales del sistema.
===========================================
*/

// Iniciamos la sesión
session_start();

// Protegemos el dashboard
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

// Conectamos con la base de datos
include "../config/conexion.php";

// ===========================================
// CONTEOS GENERALES DEL SISTEMA
// ===========================================

$totalServicios = $conexion->query("SELECT COUNT(*) AS total FROM servicios")->fetch_assoc()["total"];
$totalGaleria = $conexion->query("SELECT COUNT(*) AS total FROM galeria")->fetch_assoc()["total"];
$totalPedidos = $conexion->query("SELECT COUNT(*) AS total FROM pedidos")->fetch_assoc()["total"];
$totalUsuarios = $conexion->query("SELECT COUNT(*) AS total FROM usuarios")->fetch_assoc()["total"];

// ===========================================
// SPRINT 6 - MODIFICACIÓN 01
// Conteos de pedidos por estado
// AQUÍ VA LA PARTE PHP DE LAS ESTADÍSTICAS.
// ===========================================

$pedidosPendientes = $conexion->query("SELECT COUNT(*) AS total FROM pedidos WHERE estado = 'Pendiente'")->fetch_assoc()["total"];
$pedidosProceso = $conexion->query("SELECT COUNT(*) AS total FROM pedidos WHERE estado = 'En proceso'")->fetch_assoc()["total"];
$pedidosEntregados = $conexion->query("SELECT COUNT(*) AS total FROM pedidos WHERE estado = 'Entregado'")->fetch_assoc()["total"];
$pedidosCancelados = $conexion->query("SELECT COUNT(*) AS total FROM pedidos WHERE estado = 'Cancelado'")->fetch_assoc()["total"];

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

            <!-- Tarjetas generales -->
            <div class="row">

                <div class="col-md-3 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">
                            <i class="bi bi-scissors fs-1 text-danger"></i>
                            <h5 class="mt-3">Servicios</h5>
                            <h2><?php echo $totalServicios; ?></h2>
                            <a href="servicios/listar.php" class="btn btn-outline-danger btn-sm">
                                Ver servicios
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">
                            <i class="bi bi-images fs-1 text-danger"></i>
                            <h5 class="mt-3">Galería</h5>
                            <h2><?php echo $totalGaleria; ?></h2>
                            <a href="galeria/listar.php" class="btn btn-outline-danger btn-sm">
                                Ver galería
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">
                            <i class="bi bi-box-seam fs-1 text-danger"></i>
                            <h5 class="mt-3">Pedidos</h5>
                            <h2><?php echo $totalPedidos; ?></h2>
                            <a href="pedidos/listar.php" class="btn btn-outline-danger btn-sm">
                                Ver pedidos
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">
                            <i class="bi bi-people fs-1 text-danger"></i>
                            <h5 class="mt-3">Usuarios</h5>
                            <h2><?php echo $totalUsuarios; ?></h2>
                            <a href="usuarios/listar.php" class="btn btn-outline-danger btn-sm">
                                Ver usuarios
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ===========================================
                 SPRINT 6 - MODIFICACIÓN 02
                 AQUÍ VA LA SECCIÓN HTML DE ESTADOS
            ============================================ -->

            <h4 class="fw-bold mt-5 mb-3">
                Estado de Pedidos
            </h4>

            <div class="row">

                <div class="col-md-3 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">
                            <span class="badge bg-warning text-dark mb-2">Pendiente</span>
                            <h2><?php echo $pedidosPendientes; ?></h2>
                            <p class="text-muted mb-0">Pedidos pendientes</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">
                            <span class="badge bg-primary mb-2">En proceso</span>
                            <h2><?php echo $pedidosProceso; ?></h2>
                            <p class="text-muted mb-0">Pedidos en producción</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">
                            <span class="badge bg-success mb-2">Entregado</span>
                            <h2><?php echo $pedidosEntregados; ?></h2>
                            <p class="text-muted mb-0">Pedidos entregados</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">
                            <span class="badge bg-danger mb-2">Cancelado</span>
                            <h2><?php echo $pedidosCancelados; ?></h2>
                            <p class="text-muted mb-0">Pedidos cancelados</p>
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