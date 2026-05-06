<?php
session_start();
include("Backend/conexion.php");

// VALIDAR SUCURSAL
if (!isset($_SESSION['id_sucursal'])) {
    header("Location: seleccionar_sucursal.php");
    exit();
}

$id_sucursal = $_SESSION['id_sucursal'];

// INSERTAR PRODUCTO
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $tipo = $_POST['tipo'];

    $sql = "INSERT INTO menu (nombre, descripcion, precio, tipo, id_sucursal)
            VALUES ('$nombre', '$descripcion', '$precio', '$tipo', '$id_sucursal')";

    mysqli_query($conexion, $sql);

    header("Location: Menu.php");
    exit();
}

// OBTENER MENU POR SUCURSAL
$sql = "SELECT * FROM menu WHERE id_sucursal = $id_sucursal";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión del Menú</title>
<link rel="stylesheet" href="Estilos/menu.css">
</head>

<body>

<header>
    <h1>🍕 Gestión del Menú</h1>

    <div class="top-buttons">
        <button onclick="location.href='panel-admin.php'">⬅ Volver</button>
        <button onclick="location.href='logout.php'">Cerrar sesión</button>
    </div>
</header>

<main>

<!-- Mostrar sucursal actual-->
<?php

$id_sucursal = $_SESSION['id_sucursal'];
$sql = "SELECT nombre FROM sucursales WHERE id_sucursal = $id_sucursal";
$res = mysqli_query($conexion, $sql);
$sucursal = mysqli_fetch_assoc($res);
?>

<h3>Sucursal: <?= $sucursal['nombre'] ?></h3>



<!-- FORMULARIO -->
<section class="form-section">

<h2>Agregar Producto</h2>

<form method="POST">

<label>Nombre</label>
<input type="text" name="nombre" required>

<label>Descripción</label>
<input type="text" name="descripcion" required>

<label>Tipo</label>
<select name="tipo">
    <option value="Pizza">Pizza</option>
    <option value="Bebida">Bebida</option>
</select>

<label>Precio</label>
<input type="number" name="precio" required>

<button type="submit">Agregar</button>
</form>

</section>

<!-- TABLA -->
<section class="tabla-section">

<h2>Menú Actual</h2>

<table border="1" cellpadding="10">
<thead>
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Descripción</th>
<th>Tipo</th>
<th>Precio</th>
<th>Acciones</th>
</tr>
</thead>

<tbody>

<?php while ($row = mysqli_fetch_assoc($resultado)) { ?>
<tr>
<td><?php echo $row['id_producto']; ?></td>
<td><?php echo $row['nombre']; ?></td>
<td><?php echo $row['descripcion']; ?></td>
<td><?php echo $row['tipo']; ?></td>
<td>$<?php echo $row['precio']; ?></td>

<td>
    <a href="Backend/modificar_menu.php?id=<?php echo $row['id_producto']; ?>">
        <button>Editar</button>
    </a>

    <a href="Backend/eliminar_menu.php?id=<?php echo $row['id_producto']; ?>"
       onclick="return confirm('¿Eliminar producto?')">
        <button>Eliminar</button>
    </a>
</td>
</tr>
<?php } ?>

</tbody>
</table>

</section>

</main>

</body>
</html>