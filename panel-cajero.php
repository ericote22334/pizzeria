<?php
session_start();
include("Backend/conexion.php");

// VALIDAR LOGIN
if (!isset($_SESSION['user_id'])) {
    header("Location: logout.php");
    exit();
}

$id_usuario = $_SESSION['user_id'];
$rol = $_SESSION['rol'];

// 🔥 ASIGNAR SUCURSAL AUTOMÁTICAMENTE SI NO EXISTE
if (!isset($_SESSION['id_sucursal'])) {

    if ($rol == 'admin') {
        $sql = "SELECT id_sucursal FROM sucursales LIMIT 1";
    } else {
        $sql = "SELECT id_sucursal FROM usuario_sucursal 
                WHERE id_usuario = $id_usuario LIMIT 1";
    }

    $res = mysqli_query($conexion, $sql);
    $fila = mysqli_fetch_assoc($res);

    $_SESSION['id_sucursal'] = $fila['id_sucursal'];
}


// DEFINIR VARIABLE
$id_sucursal = (int) $_SESSION['id_sucursal'];


// TRAER MENU POR SUCURSAL
$sql = "SELECT * FROM menu WHERE id_sucursal = $id_sucursal";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panel de Cajero</title>

<link rel="stylesheet" href="Estilos/panel-cajero.css">
</head>

<body>

<header class="header">
    🍕 Pizzería - Panel de Cajero

    <div class="top-buttons">

        <?php if ($rol == 'admin') { ?>
            <button onclick="location.href='panel-admin.php'">
                Volver al Admin
            </button>
        <?php } ?>

        <button onclick="location.href='Index copy.html'" class="btn-cerrar">
            Cerrar sesión
        </button>
    </div>
</header>

<div class="container">
    <!-- MENÚ DINÁMICO -->
    <div class="menu">
        <h2>Menú</h2>

        <?php while ($row = mysqli_fetch_assoc($resultado)) { ?>
            <div class="pizza">
                <span>
                    <?= $row['nombre'] ?> - $<?= $row['precio'] ?>
                </span>

                <button onclick="agregar('<?= $row['nombre'] ?>', <?= $row['precio'] ?>)">
                    Agregar
                </button>
            </div>
        <?php } ?>

    </div>

    <!-- PEDIDO -->
    <div class="pedido">
        <h2>Pedido</h2>

        <ul id="listaPedido"></ul>

        <div class="total">
            Total: $<span id="total">0</span>
        </div>

        <button onclick="limpiar()">Limpiar pedido</button>

        <!-- FORM PARA PDF -->
        <form method="POST" action="Backend/guardar_pedido.php">
            <input type="hidden" name="pedido" id="pedidoInput">
            <input type="hidden" name="total" id="totalInput">

            <button type="submit">Finalizar y generar PDF</button>
        </form>

    </div>

</div>

<script>
let total = 0;
let pedido = [];

function agregar(nombre, precio) {
    const lista = document.getElementById("listaPedido");

    const item = document.createElement("li");
    item.textContent = `${nombre} - $${precio}`;
    lista.appendChild(item);

    total += precio;
    document.getElementById("total").textContent = total;

    pedido.push({ nombre, precio });

    actualizarInputs();
}

function limpiar() {
    document.getElementById("listaPedido").innerHTML = "";
    total = 0;
    pedido = [];

    document.getElementById("total").textContent = total;
    actualizarInputs();
}

function actualizarInputs() {
    document.getElementById("pedidoInput").value = JSON.stringify(pedido);
    document.getElementById("totalInput").value = total;
}
</script>

</body>
</html>