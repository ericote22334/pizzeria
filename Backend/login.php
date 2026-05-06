<?php
session_start();
include("conexion.php");

// 🔥 LIMPIAR SESIÓN ANTERIOR (CLAVE)
session_unset();
session_destroy();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // ⚠️ (mejorable luego con prepared statements)
    $sql = "SELECT * FROM usuarios 
            WHERE usuario = '$usuario' 
            AND contrasena = '$contrasena'";

    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) > 0) {

        $fila = mysqli_fetch_assoc($resultado);

        // ✅ GUARDAR SESIÓN
        $_SESSION['user_id'] = $fila['id_usuario'];
        $_SESSION['rol'] = $fila['rol'];

        $id_usuario = $fila['id_usuario'];

        // 🔥 ASIGNAR SUCURSAL AUTOMÁTICAMENTE
        if ($fila['rol'] == 'admin') {

            $sqlSucursal = "SELECT id_sucursal FROM sucursales LIMIT 1";

        } else {

            $sqlSucursal = "SELECT id_sucursal 
                            FROM usuario_sucursal 
                            WHERE id_usuario = $id_usuario 
                            LIMIT 1";
        }

        $resSucursal = mysqli_query($conexion, $sqlSucursal);
        $sucursal = mysqli_fetch_assoc($resSucursal);

        $_SESSION['id_sucursal'] = $sucursal['id_sucursal'];

        // ✅ REDIRECCIÓN
        if ($fila['rol'] == 'admin') {
            header("Location: ../panel-admin.php");
        } else {
            header("Location: ../panel-cajero.php");
        }

        exit();

    } else {
        echo "Usuario o contraseña incorrectos";
    }
}
?>