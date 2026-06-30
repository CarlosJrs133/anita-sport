<?php
/*
=========================================================
PROYECTO : ANITA SPORT ERP
MÓDULO   : USUARIOS
ARCHIVO  : editar.php

FUNCIÓN:
Permite editar nombre, correo, rol y opcionalmente
la contraseña de un usuario.

HISTORIAL:
[01/07/2026]
SPRINT 8 - MODIFICACIÓN 02
✔ Se agregó edición de usuarios.
✔ La contraseña solo cambia si se escribe una nueva.

[01/07/2026]
SPRINT 8 - CORRECCIÓN 02
✔ Se corrigieron los valores del rol:
  admin / editor.
=========================================================
*/

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit();
}

include "../../config/conexion.php";

$id = $_GET["id"];

$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

if (!$usuario) {
    header("Location: listar.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $rol = $_POST["rol"];
    $password = $_POST["password"];

    if ($password != "") {

        // Ciframos nueva contraseña
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE usuarios 
                SET nombre = ?, correo = ?, password = ?, rol = ?
                WHERE id = ?";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $correo, $passwordHash, $rol, $id);

    } else {

        // Mantenemos la contraseña anterior
        $sql = "UPDATE usuarios 
                SET nombre = ?, correo = ?, rol = ?
                WHERE id = ?";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $correo, $rol, $id);
    }

    if ($stmt->execute()) {
        header("Location: listar.php");
        exit();
    }
}

include "../includes/header.php";
?>

<div class="d-flex">

    <?php include "../includes/sidebar.php"; ?>

    <div class="flex-grow-1">

        <?php include "../includes/topbar.php"; ?>

        <main class="p-4">

            <div class="card shadow border-0">

                <div class="card-body p-4">

                    <h2 class="fw-bold mb-4">Editar Usuario</h2>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input
                                type="text"
                                name="nombre"
                                class="form-control"
                                value="<?php echo $usuario["nombre"]; ?>"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Correo</label>
                            <input
                                type="email"
                                name="correo"
                                class="form-control"
                                value="<?php echo $usuario["correo"]; ?>"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nueva contraseña</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Déjalo vacío si no deseas cambiarla">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Rol</label>

                            <!-- Los values deben coincidir con MySQL: admin / editor -->
                            <select name="rol" class="form-select">

                                <option value="admin" <?php if ($usuario["rol"] == "admin") echo "selected"; ?>>
                                    Administrador
                                </option>

                                <option value="editor" <?php if ($usuario["rol"] == "editor") echo "selected"; ?>>
                                    Editor
                                </option>

                            </select>
                        </div>

                        <button type="submit" class="btn btn-danger">
                            Actualizar Usuario
                        </button>

                        <a href="listar.php" class="btn btn-secondary">
                            Cancelar
                        </a>

                    </form>

                </div>

            </div>

        </main>

    </div>

</div>

<?php include "../includes/footer.php"; ?>