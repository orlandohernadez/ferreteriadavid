<?php
include "conexion.php";

$mensaje = ""; // Variable para mostrar alertas

if(isset($_POST['vender'])){
    // Limpiamos las entradas para evitar errores y ataques básicos
    $buscar = mysqli_real_escape_string($conexion, $_POST['buscar']);
    $cantidad = intval($_POST['cantidad']);

    // Buscar por código o nombre
    $res = mysqli_query($conexion,
        "SELECT * FROM productos 
         WHERE codigo_barra='$buscar' OR nombre LIKE '%$buscar%'");

    $prod = mysqli_fetch_assoc($res);

    if($prod){
        // VALIDACIÓN DE STOCK
        if($cantidad <= $prod['stock']){
            $nuevo_stock = $prod['stock'] - $cantidad;
            $total = $cantidad * $prod['precio'];

            // Actualizar Stock
            mysqli_query($conexion, "UPDATE productos SET stock=$nuevo_stock WHERE id=".$prod['id']);

            // Registrar Venta
            mysqli_query($conexion, "INSERT INTO ventas(producto_id, cantidad, total)
                                     VALUES(".$prod['id'].", $cantidad, $total)");
            
            $mensaje = "<div class='alerta-exito'>✅ Venta realizada. Nuevo stock: $nuevo_stock</div>";
        } else {
            // ERROR: No hay suficiente stock
            $mensaje = "<div class='alerta-error'>❌ Error: Solo quedan " . $prod['stock'] . " unidades disponibles.</div>";
        }
    } else {
        $mensaje = "<div class='alerta-error'>❌ El producto no existe.</div>";
    }
}
?>

<link rel="stylesheet" href="css/dashboard.css">

<div class="dashboard">
    <h2>Registrar producto</h2>

    <?php echo $mensaje; ?>

    <form method="POST">
        <input type="text" name="buscar" placeholder="Código o nombre del producto" required>
        <input type="number" name="cantidad" placeholder="Cantidad a vender" min="1" required>
        <button name="vender" type="submit">Vender</button>
    </form>

    <br>
    <a href="dashboard.php">⬅ Volver</a>
</div>