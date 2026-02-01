<?php
include "conexion.php";

if (isset($_POST['guardar'])) {

    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $precio = $_POST['precio'];
    $stock  = $_POST['stock'];

    // evitar duplicados
    $verificar = mysqli_query(
        $conexion,
        "SELECT * FROM productos WHERE codigo_barra='$codigo'"
    );

    if (mysqli_num_rows($verificar) == 0) {
        mysqli_query(
            $conexion,
            "INSERT INTO productos(nombre,codigo_barra,precio,stock)
             VALUES('$nombre','$codigo','$precio','$stock')"
        );
    }

    // redirigir para evitar duplicados
    header("Location: productos.php");
    exit;
}
?>

<link rel="stylesheet" href="css/dashboard.css">

<div class="dashboard">
    <h2>Registrar producto</h2>

    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="codigo" placeholder="Código de barras" required>
        <input type="number" name="precio" placeholder="Precio" required>
        <input type="number" name="stock" placeholder="Stock inicial" required>

        <button name="guardar">Guardar</button>
    </form>

    <br>
    <a href="dashboard.php">⬅ Volver</a>
</div>
