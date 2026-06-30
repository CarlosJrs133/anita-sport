<?php
/*
=========================================================
PROYECTO : ANITA SPORT ERP
MÓDULO   : PEDIDOS
ARCHIVO  : cambiar_estado.php

FUNCIÓN:
Actualiza el estado de un pedido desde el panel.

SPRINT 6 - MODIFICACIÓN 04:
✔ Recibe el ID del pedido.
✔ Recibe el nuevo estado.
✔ Actualiza la base de datos.
✔ Redirige al listado de pedidos.
=========================================================
*/

// Iniciamos sesión para validar que el usuario esté logueado
session_start();

// Si no hay sesión activa, enviamos al login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit();
}

// Conectamos con la base de datos
include "../../config/conexion.php";

// Recibimos el ID del pedido desde el formulario
$id = $_POST["id"];

// Recibimos el nuevo estado seleccionado
$estado = $_POST["estado"];

// Preparamos la consulta para actualizar el estado
$sql = "UPDATE pedidos SET estado = ? WHERE id = ?";

// Preparamos la consulta de forma segura
$stmt = $conexion->prepare($sql);

// Enlazamos los datos:
// s = string para estado
// i = integer para id
$stmt->bind_param("si", $estado, $id);

// Ejecutamos la actualización
$stmt->execute();

// Volvemos al listado de pedidos
header("Location: listar.php");
exit();
?>