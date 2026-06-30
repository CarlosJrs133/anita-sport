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

                    <!-- ===========================================
     SPRINT 7 - MODIFICACIÓN 04
     Agregamos la clase "tabla-dinamica"
     para que DataTables active buscador,
     paginación, ordenamiento y exportación.
=========================================== -->

<table class="table table-hover table-bordered align-middle tabla-dinamica">

                        <thead class="table-dark">

                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Teléfono</th>
                                <th>Servicio</th>
                                <th>Cantidad</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
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

    <!-- ===========================================
         SPRINT 6 - MODIFICACIÓN 03
         REEMPLAZA EL BLOQUE ANTERIOR DE ESTADO.

         ANTES:
         Solo mostrábamos el estado con una etiqueta.

         AHORA:
         Mostramos un selector para cambiar el estado
         directamente desde el listado de pedidos.
    ============================================ -->

    <form action="cambiar_estado.php" method="POST">

        <!-- Campo oculto: guarda el ID del pedido -->
        <input
            type="hidden"
            name="id"
            value="<?php echo $pedido["id"]; ?>">

        <!-- Selector del nuevo estado del pedido -->
        <select
            name="estado"
            class="form-select form-select-sm mb-2">

            <option value="Pendiente"
                <?php if ($pedido["estado"] == "Pendiente") echo "selected"; ?>>
                Pendiente
            </option>

            <option value="En proceso"
                <?php if ($pedido["estado"] == "En proceso") echo "selected"; ?>>
                En proceso
            </option>

            <option value="Entregado"
                <?php if ($pedido["estado"] == "Entregado") echo "selected"; ?>>
                Entregado
            </option>

            <option value="Cancelado"
                <?php if ($pedido["estado"] == "Cancelado") echo "selected"; ?>>
                Cancelado
            </option>

        </select>

        <!-- Botón que envía el cambio de estado -->
        <button
            class="btn btn-danger btn-sm w-100"
            type="submit">

            Actualizar

        </button>

    </form>

</td>

                                    <td>
                                        <?php echo $pedido["fecha_pedido"]; ?>
                                    </td>
                                    <td>

    <!-- ===========================================
         SPRINT 6 - MODIFICACIÓN 06
         Botón para ver el detalle completo
         del pedido seleccionado.
    ============================================ -->

    <a href="ver.php?id=<?php echo $pedido["id"]; ?>" class="btn btn-info btn-sm">
        Ver detalle
    </a>

    <!-- SPRINT 6 - MODIFICACIÓN 08
     Botón para editar el pedido seleccionado.
-->
<a href="editar.php?id=<?php echo $pedido["id"]; ?>" class="btn btn-warning btn-sm">
    Editar
</a>

<!-- SPRINT 6 - MODIFICACIÓN 10
     Botón para eliminar el pedido seleccionado.
     confirm() muestra una alerta antes de borrar.
-->
<a 
    href="eliminar.php?id=<?php echo $pedido["id"]; ?>" 
    class="btn btn-danger btn-sm"
    onclick="return confirm('¿Estás seguro de eliminar este pedido?');">
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

    </div>

</div>

<?php
// Cerramos el HTML del panel
include "../includes/footer.php";
?>