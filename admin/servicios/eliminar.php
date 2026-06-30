<?php
/*
=========================================================
PROYECTO : ANITA SPORT ERP
MÓDULO   : SERVICIOS
ARCHIVO  : eliminar.php

FUNCIÓN:
Elimina un servicio registrado en el sistema.

SPRINT 7 - CORRECCIÓN:
✔ Se valida sesión.
✔ Se recibe el ID por URL.
✔ Se elimina el servicio de MySQL.
✔ Se redirige nuevamente al listado.
=========================================================
*/

// Iniciamos sesión
session_start();

// Si no hay sesión, volvemos al login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit();
}

// Conectamos con la base de datos
include "../../config/conexion.php";

// Verificamos que venga el ID del servicio
if (!isset($_GET["id"])) {
    header("Location: listar.php");
    exit();
}

// Guardamos el ID recibido
$id = $_GET["id"];

// Eliminamos el servicio
$sql = "DELETE FROM servicios WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

// Volvemos al listado
header("Location: listar.php");
exit();
?>