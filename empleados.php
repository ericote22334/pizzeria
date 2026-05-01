<?php
session_start();
include("Backend/conexion.php");

if (!isset($_SESSION['id_sucursal'])) {
    header("Location: guardar_sucursal.php");
    exit();
}

// FILTRO (opcional)
$filtro = "";

if (!empty($_GET['sucursal'])) {
    $id = (int) $_GET['sucursal']; // evita errores
    $filtro = "WHERE us.id_sucursal = $id";
}

// TRAER EMPLEADOS + SUCURSAL
$sql = "SELECT u.id_usuario, u.usuario, u.rol, s.nombre AS nombre_sucursal
        FROM usuarios u
        INNER JOIN usuario_sucursal us ON u.id_usuario = us.id_usuario
        INNER JOIN sucursales s ON us.id_sucursal = s.id_sucursal
        $filtro
        ORDER BY s.nombre";

$resultado = mysqli_query($conexion, $sql);

// TRAER SUCURSALES PARA FILTRO
$sqlSuc = "SELECT * FROM sucursales";
$sucursales = mysqli_query($conexion, $sqlSuc);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión de Empleados</title>
<link rel="stylesheet" href="Estilos/agregar-empleados.css">
</head>

<body>

<h1>Gestión de Empleados</h1>

<a href="panel-admin.php" class="btn-volver">🔙 Volver</a>
<!-- 🔎 FILTRO POR SUCURSAL -->
<form method="GET">
    <select name="sucursal">
        <option value="">Todas las sucursales</option>
        <?php while($s = mysqli_fetch_assoc($sucursales)) { ?>
            <option value="<?= $s['id_sucursal'] ?>">
                <?= $s['nombre'] ?>
            </option>
        <?php } ?>
    </select>
    <button type="submit">Filtrar</button>
</form>

<hr>

<!-- ➕ FORMULARIO -->
<form method="POST" action="Backend/agregar_empleado.php">
    <input type="text" name="usuario" placeholder="Usuario" required>
    <input type="password" name="contrasena" placeholder="Contraseña" required>

    <select name="rol" required>
        <option value="">Seleccionar rol</option>
        <option value="admin">Admin</option>
        <option value="empleado">Empleado</option>
    </select>

    <select name="id_sucursal" required>
        <?php
        $suc = mysqli_query($conexion, "SELECT * FROM sucursales");
        while($row = mysqli_fetch_assoc($suc)) {
        ?>
            <option value="<?= $row['id_sucursal'] ?>">
                <?= $row['nombre'] ?>
            </option>
        <?php } ?>
    </select>

    <button type="submit">Guardar</button>
</form>

<hr>

<!-- 📋 TABLA -->
<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Usuario</th>
    <th>Rol</th>
    <th>Sucursal</th>
    <th>Acciones</th>
</tr>

<?php while($row = mysqli_fetch_assoc($resultado)) { ?>
<tr>
    <td><?= $row['id_usuario'] ?></td>
    <td><?= $row['usuario'] ?></td>
    <td><?= $row['rol'] ?></td>
    <td><?= $row['nombre_sucursal'] ?></td>
    <td>
        <a href="Backend/modificar_empleado.php?id=<?= $row['id_usuario'] ?>">
            <button>Editar</button>
        </a>

        <a href="Backend/eliminar_empleado.php?id=<?= $row['id_usuario'] ?>"
           onclick="return confirm('¿Eliminar empleado?')">
            <button>Eliminar</button>
        </a>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>