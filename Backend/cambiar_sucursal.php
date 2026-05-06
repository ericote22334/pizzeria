<?php
session_start();
include("conexion.php");

$id_usuario = $_SESSION['user_id'];
$id_sucursal = $_POST['id_sucursal'];
$rol = $_SESSION['rol'];

// VALIDAR
if ($rol == 'admin') {
    $_SESSION['id_sucursal'] = $id_sucursal;
} else {
    $sql = "SELECT * FROM usuario_sucursal 
            WHERE id_usuario = $id_usuario 
            AND id_sucursal = $id_sucursal";

    $res = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($res) > 0) {
        $_SESSION['id_sucursal'] = $id_sucursal;
    }
}

header("Location: ../panel-cajero.php");
exit();