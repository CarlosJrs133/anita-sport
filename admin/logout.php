<?php
session_start();

// Cerramos todas las variables de sesión
session_unset();

// Destruimos la sesión
session_destroy();

// Volvemos al login
header("Location: login.php");
exit();
?>