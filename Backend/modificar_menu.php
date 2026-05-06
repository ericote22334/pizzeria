<?php
session_start();
include("conexion.php");

$id_sucursal = $_SESSION['id_sucursal'];

// UPDATE
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $tipo = $_POST['tipo'];

    $sql = "UPDATE menu 
            SET nombre='$nombre', descripcion='$descripcion', precio='$precio', tipo='$tipo'
            WHERE id_producto=$id AND id_sucursal=$id_sucursal";

    mysqli_query($conexion, $sql);

    header("Location: ../Menu.php");
    exit();
}

// GET DATOS
$id = $_GET['id'];

$sql = "SELECT * FROM menu 
        WHERE id_producto=$id AND id_sucursal=$id_sucursal";

$resultado = mysqli_query($conexion, $sql);
$row = mysqli_fetch_assoc($resultado);
?>

<h2>Editar Producto</h2>

<form method="POST">
<input type="hidden" name="id" value="<?= $row['id_producto'] ?>">

<label>Nombre</label>
<input type="text" name="nombre" value="<?= $row['nombre'] ?>">

<label>Descripción</label>
<input type="text" name="descripcion" value="<?= $row['descripcion'] ?>">

<label>Tipo</label>
<select name="tipo">
    <option <?= ($row['tipo']=='Pizza')?'selected':'' ?>>Pizza</option>
    <option <?= ($row['tipo']=='Bebida')?'selected':'' ?>>Bebida</option>
</select>

<label>Precio</label>
<input type="number" name="precio" value="<?= $row['precio'] ?>">

<button type="submit">Guardar</button>
</form>