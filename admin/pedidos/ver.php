<?php
/*
=========================================================
PROYECTO : ANITA SPORT ERP
MÓDULO   : PEDIDOS
ARCHIVO  : ver.php

FUNCIÓN:
Muestra el detalle completo de un pedido.

SPRINT 6 - MODIFICACIÓN 05:
✔ Se recibe el ID del pedido por URL.
✔ Se consulta la información completa del pedido.
✔ Se muestra el detalle en una tarjeta.
✔ Se protege la página con sesión.
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

// Recibimos el ID del pedido desde la URL
$id = $_GET["id"];

// Buscamos el pedido en la base de datos
$sql = "SELECT * FROM pedidos WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$pedido = $resultado->fetch_assoc();

// Si el pedido no existe, volvemos al listado
if (!$pedido) {
    header("Location: listar.php");
    exit();
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
                        Detalle del Pedido #<?php echo $pedido["id"]; ?>
                    </h2>

                    <p><strong>Cliente:</strong> <?php echo $pedido["nombre_cliente"]; ?></p>

                    <p><strong>Teléfono:</strong> <?php echo $pedido["telefono"]; ?></p>

                    <p><strong>Correo:</strong> <?php echo $pedido["correo"]; ?></p>

                    <p><strong>Servicio:</strong> <?php echo $pedido["servicio"]; ?></p>

                    <p><strong>Cantidad:</strong> <?php echo $pedido["cantidad"]; ?></p>

                    <p><strong>Estado:</strong> <?php echo $pedido["estado"]; ?></p>

                    <p><strong>Fecha:</strong> <?php echo $pedido["fecha_pedido"]; ?></p>

                    <hr>

                    <h5 class="fw-bold">
                        Descripción del pedido
                    </h5>

                    <p>
                        <?php echo nl2br($pedido["descripcion"]); ?>
                    </p>

                    <a href="listar.php" class="btn btn-secondary">
                        Volver
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>