<?php
/*
=========================================================
PROYECTO : ANITA SPORT ERP
MÓDULO   : USUARIOS
ARCHIVO  : agregar.php

FUNCIÓN:
Permite crear nuevos usuarios del sistema.

HISTORIAL:
[01/07/2026]
SPRINT 8 - MODIFICACIÓN 01
✔ Se agregó formulario para crear usuarios.
✔ Se cifra la contraseña con password_hash().

[01/07/2026]
SPRINT 8 - CORRECCIÓN 01
✔ Se corrigieron los valores del campo rol.
✔ Ahora coinciden con el ENUM de MySQL:
  - admin
  - editor
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

// Variables para mensajes
$error = "";
$exito = "";

// Verificamos si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recibimos datos del formulario
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $password = $_POST["password"];
    $rol = $_POST["rol"];

    // Validamos campos obligatorios
    if ($nombre == "" || $correo == "" || $password == "") {

        $error = "Todos los campos obligatorios deben completarse.";

    } else {

        // Ciframos la contraseña antes de guardarla
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Guardamos usuario en la base de datos
        $sql = "INSERT INTO usuarios (nombre, correo, password, rol)
                VALUES (?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $correo, $passwordHash, $rol);

        if ($stmt->execute()) {
            $exito = "Usuario agregado correctamente.";
        } else {
            $error = "Error al agregar usuario. Tal vez el correo ya existe.";
        }
    }
}

// Incluimos header del panel
include "../includes/header.php";
?>

<div class="d-flex">

    <!-- Sidebar del panel -->
    <?php include "../includes/sidebar.php"; ?>

    <div class="flex-grow-1">

        <!-- Topbar del panel -->
        <?php include "../includes/topbar.php"; ?>

        <main class="p-4">

            <div class="card shadow border-0">

                <div class="card-body p-4">

                    <h2 class="fw-bold mb-4">
                        Agregar Usuario
                    </h2>

                    <!-- Mensaje de error -->
                    <?php if ($error != "") { ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php } ?>

                    <!-- Mensaje de éxito -->
                    <?php if ($exito != "") { ?>
                        <div class="alert alert-success">
                            <?php echo $exito; ?>
                        </div>
                    <?php } ?>

                    <!-- Formulario para crear usuario -->
                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input
                                type="text"
                                name="nombre"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Correo</label>
                            <input
                                type="email"
                                name="correo"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Rol</label>

                            <!--
                            ===========================================
                            SPRINT 8 - CORRECCIÓN 01
                            Los valores deben coincidir exactamente
                            con el ENUM de la base de datos:
                            enum('admin','editor')
                            ===========================================
                            -->
                            <select name="rol" class="form-select">
                                <option value="admin">Administrador</option>
                                <option value="editor">Editor</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-danger">
                            Guardar Usuario
                        </button>

                        <a href="listar.php" class="btn btn-secondary">
                            Volver
                        </a>

                    </form>

                </div>

            </div>

        </main>

    </div>

</div>

<?php
// Incluimos footer del panel
include "../includes/footer.php";
?>