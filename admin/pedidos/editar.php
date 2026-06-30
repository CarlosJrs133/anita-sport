<?php
/*
=========================================================
PROYECTO : ANITA SPORT ERP
MÓDULO   : PEDIDOS
ARCHIVO  : editar.php

FUNCIÓN:
Permite modificar la información de un pedido
registrado por un cliente.

SPRINT 6 - MODIFICACIÓN 07:
✔ Se recibe el ID del pedido por URL.
✔ Se cargan los datos actuales del pedido.
✔ Se permite editar cliente, teléfono, correo,
  servicio, cantidad, descripción y estado.
✔ Se actualiza la información en MySQL.
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

// Recibimos el ID del pedido
$id = $_GET["id"];

// Buscamos el pedido actual
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

// Si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recibimos los datos modificados
    $nombre_cliente = $_POST["nombre_cliente"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $servicio = $_POST["servicio"];
    $cantidad = $_POST["cantidad"];
    $descripcion = $_POST["descripcion"];
    $estado = $_POST["estado"];

    // Actualizamos el pedido en la base de datos
    $sql = "UPDATE pedidos 
            SET nombre_cliente = ?, telefono = ?, correo = ?, servicio = ?, cantidad = ?, descripcion = ?, estado = ?
            WHERE id = ?";

    $stmt = $conexion->prepare($sql);

    // Tipos:
    // s = texto
    // i = número entero
    $stmt->bind_param(
        "ssssissi",
        $nombre_cliente,
        $telefono,
        $correo,
        $servicio,
        $cantidad,
        $descripcion,
        $estado,
        $id
    );

    // Si se actualiza correctamente, volvemos al listado
    if ($stmt->execute()) {
        header("Location: listar.php");
        exit();
    }
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
                        Editar Pedido #<?php echo $pedido["id"]; ?>
                    </h2>

                    <!-- Formulario de edición -->
                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Nombre del cliente</label>
                            <input
                                type="text"
                                name="nombre_cliente"
                                class="form-control"
                                value="<?php echo $pedido["nombre_cliente"]; ?>"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input
                                type="text"
                                name="telefono"
                                class="form-control"
                                value="<?php echo $pedido["telefono"]; ?>"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Correo</label>
                            <input
                                type="email"
                                name="correo"
                                class="form-control"
                                value="<?php echo $pedido["correo"]; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Servicio</label>
                            <input
                                type="text"
                                name="servicio"
                                class="form-control"
                                value="<?php echo $pedido["servicio"]; ?>"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cantidad</label>
                            <input
                                type="number"
                                name="cantidad"
                                class="form-control"
                                value="<?php echo $pedido["cantidad"]; ?>"
                                min="1"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea
                                name="descripcion"
                                class="form-control"
                                rows="5"
                                required><?php echo $pedido["descripcion"]; ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Estado</label>

                            <select name="estado" class="form-select">

                                <option value="Pendiente" <?php if ($pedido["estado"] == "Pendiente") echo "selected"; ?>>
                                    Pendiente
                                </option>

                                <option value="En proceso" <?php if ($pedido["estado"] == "En proceso") echo "selected"; ?>>
                                    En proceso
                                </option>

                                <option value="Entregado" <?php if ($pedido["estado"] == "Entregado") echo "selected"; ?>>
                                    Entregado
                                </option>

                                <option value="Cancelado" <?php if ($pedido["estado"] == "Cancelado") echo "selected"; ?>>
                                    Cancelado
                                </option>

                            </select>
                        </div>

                        <button type="submit" class="btn btn-danger">
                            Actualizar Pedido
                        </button>

                        <a href="listar.php" class="btn btn-secondary">
                            Cancelar
                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>