<?php
include "conexion.php";

if(isset($_POST['agregar'])){
    $codigo = $_POST['codigo'];
    $cantidad = $_POST['cantidad'];

    // buscar producto
    $res = mysqli_query($conexion,
        "SELECT * FROM productos WHERE codigo_barra='$codigo'");
    $prod = mysqli_fetch_assoc($res);

    if($prod){
        $nuevo = $prod['stock'] + $cantidad;

        mysqli_query($conexion,
        "UPDATE productos SET stock=$nuevo WHERE id=".$prod['id']);

        mysqli_query($conexion,
        "INSERT INTO entradas(producto_id,cantidad)
         VALUES(".$prod['id'].",$cantidad)");
    }
}
?>

<link rel="stylesheet" href="css/dashboard.css">

<div class="dashboard">
    <h2>Registrar producto</h2>

    <form method="POST">
        <input type="text" name="codigo" placeholder="Escanear código de barras" required>
        <input type="number" name="cantidad" placeholder="Cantidad a ingresar" required>
       
         <button name="agregar">Agregar</button>
    </form>

    <br>
    <a href="dashboard.php">⬅ Volver</a>

</form>
</div>
