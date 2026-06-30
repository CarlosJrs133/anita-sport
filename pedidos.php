<?php
/*
=========================================================
PROYECTO : ANITA SPORT ERP
MÓDULO   : PEDIDOS PÚBLICOS
ARCHIVO  : pedidos.php

FUNCIÓN:
Permite que un cliente envíe una solicitud
de pedido o cotización desde la web pública.

MODIFICACIONES:
✔ Se agregó formulario público de pedidos.
✔ Se conecta con la base de datos.
✔ Se guarda el pedido en MySQL.
✔ Se muestran mensajes de éxito o error.
=========================================================
*/

// Conectamos con la base de datos
include "config/conexion.php";

// Variables para mensajes
$error = "";
$exito = "";

// Verificamos si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recibimos datos del formulario
    $nombre_cliente = $_POST["nombre_cliente"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $servicio = $_POST["servicio"];
    $cantidad = $_POST["cantidad"];
    $descripcion = $_POST["descripcion"];

    // Validamos campos obligatorios
    if ($nombre_cliente == "" || $telefono == "" || $servicio == "" || $cantidad == "" || $descripcion == "") {

        $error = "Por favor completa todos los campos obligatorios.";

    } else {

        // Insertamos el pedido en la base de datos
        $sql = "INSERT INTO pedidos 
                (nombre_cliente, telefono, correo, servicio, cantidad, descripcion)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssssis", $nombre_cliente, $telefono, $correo, $servicio, $cantidad, $descripcion);

        if ($stmt->execute()) {
            $exito = "Tu pedido fue enviado correctamente. ANITA SPORT se comunicará contigo pronto.";
        } else {
            $error = "Ocurrió un error al enviar tu pedido.";
        }
    }
}

// Incluimos cabecera pública
include "includes/header.php";

// Incluimos menú público
include "includes/navbar.php";
?>

<section class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="text-center mb-4">

                <h1 class="fw-bold">
                    Solicita tu Cotización
                </h1>

                <p class="text-muted">
                    Completa el formulario y cuéntanos qué prenda deportiva necesitas.
                </p>

            </div>

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

            <div class="card shadow border-0">

                <div class="card-body p-4">

                    <!-- Formulario público de pedido -->
                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Nombre completo *</label>
                            <input 
                                type="text" 
                                name="nombre_cliente" 
                                class="form-control" 
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Teléfono / WhatsApp *</label>
                            <input 
                                type="text" 
                                name="telefono" 
                                class="form-control" 
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Correo</label>
                            <input 
                                type="email" 
                                name="correo" 
                                class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Servicio solicitado *</label>

                            <select name="servicio" class="form-select" required>
                                <option value="">Selecciona una opción</option>
                                <option value="Uniformes deportivos">Uniformes deportivos</option>
                                <option value="Sublimados personalizados">Sublimados personalizados</option>
                                <option value="Polos deportivos">Polos deportivos</option>
                                <option value="Buzos deportivos">Buzos deportivos</option>
                                <option value="Pedido personalizado">Pedido personalizado</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cantidad *</label>
                            <input 
                                type="number" 
                                name="cantidad" 
                                class="form-control" 
                                min="1" 
                                required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Descripción del pedido *</label>
                            <textarea 
                                name="descripcion" 
                                class="form-control" 
                                rows="5" 
                                placeholder="Ejemplo: uniformes para fútbol, color rojo con negro, logo del equipo, tallas variadas..."
                                required></textarea>
                        </div>

                        <button type="submit" class="btn btn-danger w-100">
                            Enviar Pedido
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</section>

<?php
// Incluimos footer público
include "includes/footer.php";
?>