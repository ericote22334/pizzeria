<?php
session_start();
include("conexion.php");

// UPDATE
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $usuario = $_POST['usuario'];
    $rol = $_POST['rol'];
    $id_sucursal = $_POST['id_sucursal'];

    mysqli_query($conexion, "UPDATE usuarios 
        SET usuario='$usuario', rol='$rol' 
        WHERE id_usuario=$id");

    mysqli_query($conexion, "UPDATE usuario_sucursal 
        SET id_sucursal=$id_sucursal 
        WHERE id_usuario=$id");

    header("Location: ../empleados.php");
    exit();
}

// GET DATOS
$id = $_GET['id'];

$usuario = mysqli_fetch_assoc(mysqli_query($conexion,
    "SELECT * FROM usuarios WHERE id_usuario = $id"));

$sucursal = mysqli_fetch_assoc(mysqli_query($conexion,
    "SELECT * FROM usuario_sucursal WHERE id_usuario = $id"));

// TRAER TODAS LAS SUCURSALES
$sucursales = mysqli_query($conexion, "SELECT * FROM sucursales");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Empleado</title>
<a href="../empleados.php" class="btn-volver">⬅ Volver</a>

<style>
body {
    font-family: Arial;
    background: #f4f4f4;
}

.container {
    width: 400px;
    margin: 50px auto;
    background: white;
    padding: 20px;
    border-radius: 10px;
}

h2 {
    text-align: center;
}

label {
    font-weight: bold;
}

input, select {
    width: 100%;
    padding: 8px;
    margin: 8px 0 15px;
}

button {
    width: 100%;
    padding: 10px;
    background: #2ecc71;
    border: none;
    color: white;
    font-weight: bold;
    cursor: pointer;
}

button:hover {
    background: #27ae60;
}
.btn-volver {
  position: fixed;
  top: 20px;
  left: 20px;
  z-index: 1000;

  text-decoration: none;
  background: #fff;
  padding: 8px 16px;
  border-radius: 8px;
  border: 1px solid #ccc;
  color: #000;
  font-size: 14px;

  transition: 0.2s;
}
</style>

</head>
<body>

<div class="container">

<h2>✏️ Editar Empleado</h2>

<form method="POST">
    <input type="hidden" name="id" value="<?= $id ?>">

    <!-- USUARIO -->
    <label>Nombre de usuario:</label>
    <input type="text" name="usuario" value="<?= $usuario['usuario'] ?>">

    <!-- ROL -->
    <label>Rol:</label>
    <select name="rol">
        <option value="admin" <?= ($usuario['rol'] == 'admin') ? 'selected' : '' ?>>Admin</option>
        <option value="empleado" <?= ($usuario['rol'] == 'empleado') ? 'selected' : '' ?>>empleado</option>
    </select>

    <!-- SUCURSAL -->
    <label>Sucursal:</label>
    <select name="id_sucursal">
        <?php while($s = mysqli_fetch_assoc($sucursales)) { ?>
            <option value="<?= $s['id_sucursal'] ?>"
                <?= ($s['id_sucursal'] == $sucursal['id_sucursal']) ? 'selected' : '' ?>>
                <?= $s['nombre'] ?>
            </option>
        <?php } ?>
    </select>

    <button type="submit">Guardar cambios</button>
</form>

</div>

</body>
</html>