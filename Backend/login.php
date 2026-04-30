<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta
    $sql = "SELECT * FROM usuarios 
            WHERE usuario = '$usuario' 
            AND contrasena = '$contrasena'";

    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);

        // Guardar sesión
        $_SESSION['user_id'] = $fila['id_usuario'];
        $_SESSION['rol'] = $fila['rol'];

        // redireccion segun el rol
        if ($fila['rol'] == 'admin') {
            header("Location: ../panel-admin.php");
        } else if ($fila['rol'] == 'empleado') {
            header("Location: ../panel-cajero.php");
        }
        exit();

    } else {
        echo "Usuario o contraseña incorrectos";
    }
}
?>