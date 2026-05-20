<?php
$conexion = mysqli_connect("localhost", "if0_41978539", "6DJE6ns9gy3", "pizzeria");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>