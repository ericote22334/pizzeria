<?php
session_start();
include("conexion.php");

$id_sucursal = $_SESSION['id_sucursal'];

// ACTUALIZAR
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $stock = $_POST['stock'];
    $unidad = $_POST['unidad'];

    $sql = "UPDATE ingredientes 
            SET nombre='$nombre', stock_actual='$stock', unidad='$unidad' 
            WHERE id_ingrediente=$id AND id_sucursal=$id_sucursal";

    mysqli_query($conexion, $sql);

    header("Location: ../agregar-producto.php");
    exit();
}

// OBTENER DATOS
$id = $_GET['id'];

$sql = "SELECT * FROM ingredientes 
        WHERE id_ingrediente = $id AND id_sucursal = $id_sucursal";

$resultado = mysqli_query($conexion, $sql);
$row = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
</head>
<body>

<h2>Editar Producto</h2>

<form method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id_ingrediente']; ?>">

    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>"><br><br>

    <label>Stock:</label><br>
    <input type="number" name="stock" value="<?php echo $row['stock_actual']; ?>"><br><br>

    <label>Unidad:</label><br>
    <input type="text" name="unidad" value="<?php echo $row['unidad']; ?>"><br><br>

    <button type="submit">Guardar cambios</button>
</form>

</body>
</html>