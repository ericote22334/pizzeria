<?php
session_start();
include("Backend/conexion.php");

// VALIDAR LOGIN
if (!isset($_SESSION['user_id'])) {
    header("Location: index copy.html");
    exit();
}

$id_usuario = $_SESSION['user_id'];
$rol = $_SESSION['rol'];

// TRAER SUCURSALES SEGÚN ROL
if ($rol == 'admin') {
    $sql = "SELECT * FROM sucursales";
} else {
    $sql = "SELECT s.* FROM sucursales s
            INNER JOIN usuario_sucursal us 
            ON s.id_sucursal = us.id_sucursal
            WHERE us.id_usuario = $id_usuario";
}

$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Seleccionar Sucursal</title>

<style>
body {
    font-family: Arial;
    background: #f4f4f4;
    text-align: center;
    margin-top: 100px;
}

select, button {
    padding: 10px;
    font-size: 16px;
}
</style>

</head>

<body>

<h2>Seleccionar Sucursal</h2>

<form method="POST" action="Backend/guardar_sucursal.php">

    <select name="id_sucursal" required>
        <?php while($fila = mysqli_fetch_assoc($resultado)) { ?>
            <option value="<?= $fila['id_sucursal'] ?>">
                <?= $fila['nombre'] ?>
            </option>
        <?php } ?>
    </select>

    <br><br>

    <button type="submit">Ingresar</button>

</form>

</body>
</html>