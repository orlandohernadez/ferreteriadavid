<?php
include "conexion.php";

if(isset($_POST['registrar'])){
    $usuario = $_POST['usuario'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // evitar usuarios repetidos
    $verificar = mysqli_query($conexion,
        "SELECT * FROM usuarios WHERE usuario='$usuario'");

    if(mysqli_num_rows($verificar)==0){
        mysqli_query($conexion,
            "INSERT INTO usuarios(usuario,password)
             VALUES('$usuario','$pass')");
        header("Location: login.php");
    } else {
        $error = "El usuario ya existe";
    }
}
?>

<link rel="stylesheet" href="css/estilo.css">

<div class="contenedor">
    <form method="POST">
        <h2>Registro</h2>

        <?php 
        if(isset($error)) 
            echo "<p style='color:red;text-align:center'>$error</p>";
        ?>

        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>

        <button name="registrar">Registrar</button>

        <p style="text-align:center;margin-top:10px;">
            <a href="login.php">Volver al login</a>
        </p>
    </form>
</div>
