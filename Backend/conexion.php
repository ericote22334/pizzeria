<?php
$user="root";
$pass="";
$server="localhost";
$db="pizzeria";
$conexion=mysqli_connect($server,$user,$pass) or die("error al conectar a la base de datos".mysql_error());
mysqli_select_db($conexion,$db);

if($conexion->connect_error) {
    die("Connection failed: ".$conexion->connect_error);
}
?>