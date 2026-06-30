<?php
/*
=========================================================
PROYECTO : ANITA SPORT ERP
MÓDULO   : GALERÍA
ARCHIVO  : eliminar.php

FUNCIÓN:
Elimina una imagen de la base de datos.

MODIFICACIONES:
✔ Se recibe el ID por URL.
✔ Se elimina el registro de MySQL.
✔ Se redirige al listado.
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

// Recibimos el ID por URL
$id = $_GET["id"];

// Eliminamos el registro
$sql = "DELETE FROM galeria WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

// Volvemos al listado
header("Location: listar.php");
exit();
?>