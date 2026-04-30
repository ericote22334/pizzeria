<?php
session_start();
include("conexion.php");

$id_sucursal = $_SESSION['id_sucursal'];

// AGREGAR PRODUCTO
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $stock_actual = $_POST['stock'];
    $unidad = $_POST['unidad'];

    $sql = "INSERT INTO ingredientes (nombre, stock_actual, unidad, id_sucursal) 
            VALUES ('$nombre', '$stock_actual', '$unidad', '$id_sucursal')";

    mysqli_query($conexion, $sql);

    header("Location: ../agregar-producto.php");
    exit();
}
?>