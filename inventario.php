<?php
// 1. Conexión a la base de datos
$servidor = "localhost";
$usuario = "root"; 
$contrasena = ""; 
$base_datos = "ferreteria";

$conexion = new mysqli($servidor, $usuario, $contrasena, $base_datos);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// 2. Consulta
$sql = "SELECT * FROM productos";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario de Ferretería</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Inventario de Productos</h1>

    <?php
    if ($resultado->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Código Barra</th><th>Precio</th><th>Stock</th><th>Acción</th></tr>";
        
        // 3. Mostrar datos
        while($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $fila["id"] . "</td>";
            echo "<td>" . $fila["nombre"] . "</td>";
            echo "<td>" . $fila["codigo_barra"] . "</td>";
            echo "<td>" . $fila["precio"] . "</td>";
            echo "<td>" . $fila["stock"] . "</td>";
            // CORREGIDO: Se cambió $row por $fila y se escaparon las comillas correctamente
            echo "<td><button onclick=\"descargarEtiqueta('" . $fila['codigo_barra'] . "', '" . $fila['nombre'] . "')\">Generar Código</button></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 resultados en la tabla productos.";
    }
    
    $conexion->close();
    ?>

    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

    <script>
        function descargarEtiqueta(codigo, nombre) {
            const ventana = window.open('', '_blank', 'width=400,height=300');
            
            ventana.document.write(`
                <html>
                    <body style="text-align:center; font-family:Arial;">
                        <h2 style="margin-bottom:0;">Ferretería - Inventario</h2>
                        <p style="margin-top:0;">${nombre}</p>
                        <svg id="barcode"></svg>
                        <br><br>
                        <button onclick="window.print()">IMPRIMIR / GUARDAR PDF</button>
                        
                        <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"><\/script>
                        <script>
                            // Pequeño delay para asegurar que la librería cargó
                            setTimeout(function() {
                                JsBarcode("#barcode", "${codigo}", {
                                    format: "CODE128",
                                    displayValue: true,
                                    fontSize: 20,
                                    lineColor: "#000",
                                    width: 2,
                                    height: 50
                                });
                            }, 100);
                        <\/script>
                    </body>
                </html>
            `);
            ventana.document.close();
        }
    </script>
</body>
</html>