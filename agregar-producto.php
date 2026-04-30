<?php
session_start();
include("Backend/conexion.php");


$id_sucursal = $_SESSION['id_sucursal'];

// TRAER PRODUCTOS DE LA SUCURSAL
$sql = "SELECT * FROM ingredientes WHERE id_sucursal = $id_sucursal";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="Estilos/agregar-productos.css">
</head>
<body>

<a href="panel-admin.php"><button>⬅ Volver</button></a>

<h2>Agregar Producto</h2>

<!-- FORMULARIO -->
<form method="POST" action="Backend/agregar_producto.php">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" required><br><br>

    <label>Stock actual:</label><br>
    <input type="number" name="stock" required><br><br>

    <label>Unidad:</label><br>
    <input type="text" name="unidad" required><br><br>

    <button type="submit">Guardar</button>
</form>

<hr>

<h2>Lista de Productos</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Nombre</th>
        <th>Stock</th>
        <th>Unidad</th>
        <th>Acciones</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($resultado)) { ?>
    <tr>
        <td><?php echo $row['nombre']; ?></td>
        <td><?php echo $row['stock_actual']; ?></td>
        <td><?php echo $row['unidad']; ?></td>
        <td>
            <!-- EDITAR -->
            <a href="Backend/modificar_ingredientes.php?id=<?php echo $row['id_ingrediente']; ?>">
                <button>Editar</button>
            </a>

            <!-- ELIMINAR -->
            <a href="Backend/eliminar_ingredientes.php?id=<?php echo $row['id_ingrediente']; ?>" 
               onclick="return confirm('¿Eliminar producto?')">
                <button>Eliminar</button>
            </a>
        </td>
    </tr>
    <?php } ?>

</table>

</body>
</html>