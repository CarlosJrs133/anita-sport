<?php
/*
=========================================================
PROYECTO : ANITA SPORT ERP
MÓDULO   : PEDIDOS
ARCHIVO  : eliminar.php

FUNCIÓN:
Elimina un pedido registrado en el sistema.

SPRINT 6 - MODIFICACIÓN 09:
✔ Se recibe el ID del pedido por URL.
✔ Se verifica que exista el pedido.
✔ Se elimina de la base de datos.
✔ Se redirige al listado de pedidos.
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

// Verificamos si llegó el ID por URL
if (!isset($_GET["id"])) {
    header("Location: listar.php");
    exit();
}

// Recibimos el ID del pedido
$id = $_GET["id"];

// Eliminamos el pedido de la base de datos
$sql = "DELETE FROM pedidos WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

// Volvemos al listado
header("Location: listar.php");
exit();
?>