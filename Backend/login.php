<?php
session_start();
include("conexion.php"); // conexión a la base

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta a la base
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contraseña = '$contrasena'";
    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);

        // Guardar sesión
        $_SESSION['user_id'] = $fila['id_usuario'];
        $_SESSION['rol'] = $fila['rol'];

        // Redirigir según rol
        if ($fila['rol'] == 'admin') {
            header("Location: ../panel-admin.html");
        } else {
            header("Location: ../panel-cajero.html");
        }
        exit();

    } else {
        echo "Usuario o contraseña incorrectos";
    }
}
?>