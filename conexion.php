<?php
$conexion = new mysqli("localhost","root","","ferreteria");

if ($conexion->connect_error) {
    die("Error de conexión");
}
?>
