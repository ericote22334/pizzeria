<?php
session_start();
include("conexion.php");

$id_sucursal = $_SESSION['id_sucursal'];
$id = $_GET['id'];

$sql = "DELETE FROM menu 
        WHERE id_producto = $id AND id_sucursal = $id_sucursal";

mysqli_query($conexion, $sql);

header("Location: ../Menu.php");
exit();