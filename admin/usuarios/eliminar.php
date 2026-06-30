<?php
/*
=========================================================
PROYECTO : ANITA SPORT ERP
MÓDULO   : USUARIOS
ARCHIVO  : eliminar.php

FUNCIÓN:
Elimina un usuario del sistema.

SPRINT 8 - MODIFICACIÓN 03
✔ Se agregó eliminación de usuarios.
✔ Se evita eliminar el usuario actualmente logueado.
=========================================================
*/

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit();
}

include "../../config/conexion.php";

$id = $_GET["id"];

// Evitamos que el administrador se elimine a sí mismo
if ($id == $_SESSION["usuario_id"]) {
    header("Location: listar.php");
    exit();
}

$sql = "DELETE FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: listar.php");
exit();
?>