<?php
/*
=========================================================
PROYECTO : ANITA SPORT ERP
MÓDULO   : PEDIDOS
ARCHIVO  : listar.php

FUNCIÓN:
Muestra todos los pedidos o cotizaciones
registradas por los clientes.

MODIFICACIONES:
✔ Se conecta con la base de datos.
✔ Se listan todos los pedidos.
✔ Se muestra el estado de cada pedido.
✔ Se protege la página con sesión.
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

// Consultamos todos los pedidos, del más reciente al más antiguo
$sql = "SELECT * FROM pedidos ORDER BY id DESC";
$pedidos = $conexion->query($sql);

// Incluimos el encabezado del panel administrativo
include "../includes/header.php";
?>

<div class="d-flex">

    <!-- Menú lateral del panel -->
    <?php include "../includes/sidebar.php"; ?>

    <div class="flex-grow-1">

        <!-- Barra superior del panel -->
        <?php include "../includes/topbar.php"; ?>

        <!-- Contenido principal -->
        <div class="container py-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h2 class="fw-bold">
                    Pedidos / Cotizaciones
                </h2>

            </div>

            <div class="card shadow border-0">

                <div class="card-body">

                    <table class="table table-hover table-bordered align-middle">

                        <thead class="table-dark">

                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Teléfono</th>
                                <th>Servicio</th>
                                <th>Cantidad</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php while ($pedido = $pedidos->fetch_assoc()) { ?>

                                <tr>

                                    <td>
                                        <?php echo $pedido["id"]; ?>
                                    </td>

                                    <td>
                                        <?php echo $pedido["nombre_cliente"]; ?>
                                    </td>

                                    <td>
                                        <?php echo $pedido["telefono"]; ?>
                                    </td>

                                    <td>
                                        <?php echo $pedido["servicio"]; ?>
                                    </td>

                                    <td>
                                        <?php echo $pedido["cantidad"]; ?>
                                    </td>

                                    <td>
                                        <?php if ($pedido["estado"] == "Pendiente") { ?>

                                            <span class="badge bg-warning text-dark">
                                                Pendiente
                                            </span>

                                        <?php } elseif ($pedido["estado"] == "En proceso") { ?>

                                            <span class="badge bg-primary">
                                                En proceso
                                            </span>

                                        <?php } elseif ($pedido["estado"] == "Entregado") { ?>

                                            <span class="badge bg-success">
                                                Entregado
                                            </span>

                                        <?php } else { ?>

                                            <span class="badge bg-danger">
                                                Cancelado
                                            </span>

                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?php echo $pedido["fecha_pedido"]; ?>
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

<?php
// Cerramos el HTML del panel
include "../includes/footer.php";
?>