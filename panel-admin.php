<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="Estilos/panel-admin.css">
</head>

<body>
<header>
    <h1>Sistema de gestion de la pizzeria</h1>
</header>

<?php
include("Backend/conexion.php");

$id_usuario = $_SESSION['user_id'];
$rol = $_SESSION['rol'];

// Si es superadmin → ver todas
if ($rol == 'admin') {
    $sql = "SELECT * FROM sucursales";
} else {
    $sql = "SELECT s.* FROM sucursales s
            INNER JOIN usuario_sucursal us ON s.id_sucursal = us.id_sucursal
            WHERE us.id_usuario = $id_usuario";
}

$resultado = mysqli_query($conexion, $sql);
?>

<form method="POST" action="Backend/guardar_sucursal.php">
    <select name="sucursal">
        <?php while($fila = mysqli_fetch_assoc($resultado)) { ?>
            <option value="<?php echo $fila['id_sucursal']; ?>">
                <?php echo $fila['nombre']; ?>
            </option>
        <?php } ?>
    </select>

    <button type="submit">Entrar</button>
</form>


<!-- Mostrar sucursal actual-->
<?php

$id_sucursal = $_SESSION['id_sucursal'];
$sql = "SELECT nombre FROM sucursales WHERE id_sucursal = $id_sucursal";
$res = mysqli_query($conexion, $sql);
$sucursal = mysqli_fetch_assoc($res);
?>

<h3>Sucursal: <?= $sucursal['nombre'] ?></h3>



<!-- BOTONES ARRIBA -->
<div class="top-buttons">
     <button onclick="location.href='index copy.html'" class="btn-cerrar">
        Cerrar Sesión
    </button>

    <button onclick="abrirMenu()" class="btn-color">Color</button>

    <div id="colores" class="colores">
        <div class="c" onclick="cambiar('blue')" style="background:blue;"></div>
        <div class="c" onclick="cambiar('red')" style="background:red;"></div>
        <div class="c" onclick="cambiar('green')" style="background:green;"></div>
        <div class="c" onclick="cambiar('orange')" style="background:orange;"></div>
        <div class="c" onclick="cambiar('purple')" style="background:purple;"></div>
        <div class="c" onclick="cambiar('pink')" style="background:pink;"></div>
        <div class="c" onclick="cambiar('yellow')" style="background:yellow;"></div>
        <div class="c" onclick="cambiar('brown')" style="background:brown;"></div>
        <div class="c" onclick="cambiar('gray')" style="background:gray;"></div>
        <div class="c" onclick="cambiar('black')" style="background:black;"></div>
    </div>

   
</div>

<main>

    <!-- LOGO -->
    <div class="logo-panel">
        <img src="Captura de pantalla 2026-03-18 182924 copy.png">
    </div>

    <section class="dashboard">

        <div class="card">
            <h2>Venta al publico💰</h2>
            <p>Gestion de la venta al publico.</p>
            <button onclick="location.href='venta_publico.html'">Ir</button>
        </div>

        <div class="card">
            <h2>Personal👤</h2>
            <p>Administracion de los empleados.</p>
            <button onclick="location.href='personal.html'">Ir</button>
        </div>

        <div class="card">
            <h2>Stock📦</h2>
            <p>Gestion del stock.</p>
            <button onclick="location.href='agregar-producto.php'">Ir</button>
        </div>

         <div class="card">
            <h2>Menu📦</h2>
            <p>Gestion del stock.</p>
            <button onclick="location.href='Menu.html'">Ir</button>
        
        
      
    </section>
</main>


<!-- JS -->
<script>
function abrirMenu(){
let menu = document.getElementById("colores");

if(menu.style.display == "block"){
menu.style.display = "none";
}else{
menu.style.display = "block";
}
}

function cambiar(color){
document.body.style.background = color;
}
</script>

</body>
</html>