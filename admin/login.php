<?php
/*
===========================================
ANITA SPORT
Archivo: login.php
Descripción: Pantalla de acceso al panel administrativo
===========================================
*/

session_start();

// Conectamos con la base de datos
include "../config/conexion.php";

// Variable para mostrar errores
$error = "";

// Verificamos si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recibimos datos del formulario
    $correo = $_POST["correo"];
    $password = $_POST["password"];

    // Buscamos el usuario por correo
    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();

    $resultado = $stmt->get_result();

    // Si existe el usuario
    if ($resultado->num_rows == 1) {

        $usuario = $resultado->fetch_assoc();

        // Verificamos contraseña cifrada
        if (password_verify($password, $usuario["password"])) {

            // Creamos sesión
            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["usuario_nombre"] = $usuario["nombre"];
            $_SESSION["usuario_rol"] = $usuario["rol"];

            // Enviamos al dashboard
            header("Location: dashboard.php");
            exit();

        } else {
            $error = "Contraseña incorrecta";
        }

    } else {
        $error = "Correo no encontrado";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ANITA SPORT</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-md-5">

            <div class="card shadow border-0">

                <div class="card-body p-5">

                    <h2 class="text-center fw-bold mb-2">
                        ANITA SPORT
                    </h2>

                    <p class="text-center text-muted mb-4">
                        Panel Administrativo
                    </p>

                    <!-- Mostramos error si el correo o contraseña son incorrectos -->
                    <?php if ($error != "") { ?>
                        <div class="alert alert-danger text-center">
                            <?php echo $error; ?>
                        </div>
                    <?php } ?>

                    <!-- Formulario de login -->
                    <form action="" method="POST">

                        <div class="mb-3">
                            <label class="form-label">Correo</label>

                            <input
                                type="email"
                                name="correo"
                                class="form-control"
                                placeholder="Ingrese su correo"
                                required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Contraseña</label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Ingrese su contraseña"
                                required>
                        </div>

                        <button type="submit" class="btn btn-danger w-100">
                            Ingresar
                        </button>

                    </form>

                    <div class="text-center mt-3">
                        <a href="../index.php" class="text-decoration-none">
                            Volver a la web
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>