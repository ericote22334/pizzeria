<?php
session_start();

$_SESSION['id_sucursal'] = $_POST['sucursal'];

// Redirigir según rol
if ($_SESSION['rol'] == 'admin') {
    header("Location: ../panel-admin.php");
} else {
    header("Location: ../panel-cajero.php");
}
?>