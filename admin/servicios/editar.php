<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../login.php");
    exit();
}

include "../../config/conexion.php";

$id = $_GET["id"];

$sql = "SELECT * FROM servicios WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$servicio = $resultado->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $estado = $_POST["estado"];

    $sql = "UPDATE servicios SET titulo = ?, descripcion = ?, estado = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssii", $titulo, $descripcion, $estado, $id);

    if ($stmt->execute()) {
        header("Location: listar.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Servicio | ANITA SPORT</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold">ANITA SPORT | Editar Servicio</span>

        <a href="listar.php" class="btn btn-outline-light btn-sm">
            Volver
        </a>
    </div>
</nav>

<div class="container py-5">

    <div class="card shadow border-0">
        <div class="card-body p-4">

            <h2 class="fw-bold mb-4">Editar Servicio</h2>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input 
                        type="text" 
                        name="titulo" 
                        class="form-control" 
                        value="<?php echo $servicio["titulo"]; ?>" 
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea 
                        name="descripcion" 
                        class="form-control" 
                        rows="5" 
                        required><?php echo $servicio["descripcion"]; ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">Estado</label>

                    <select name="estado" class="form-select">
                        <option value="1" <?php if ($servicio["estado"] == 1) echo "selected"; ?>>
                            Activo
                        </option>

                        <option value="0" <?php if ($servicio["estado"] == 0) echo "selected"; ?>>
                            Inactivo
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-danger">
                    Actualizar Servicio
                </button>

                <a href="listar.php" class="btn btn-secondary">
                    Cancelar
                </a>

            </form>

        </div>
    </div>

</div>

</body>
</html>