<?php
session_start();
include "conexion.php";

if(isset($_POST['login'])){
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario'";
    $res = mysqli_query($conexion,$sql);
    $user = mysqli_fetch_assoc($res);

    if($user && password_verify($password,$user['password'])){
        $_SESSION['usuario'] = $user['usuario'];
        header("Location: dashboard.php");
    } else {
        $error = "Usuario o contraseña incorrecta";
    }
}
?>

<link rel="stylesheet" href="css/estilo.css">

<div class="contenedor">
    <form method="POST">
        <h2>Iniciar sesión</h2>

        <?php if(isset($error)) echo "<p>$error</p>"; ?>

        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>

        <button name="login">Entrar</button>
        <p style="text-align:center; margin-top:10px;">
    ¿No tienes cuenta?
    <a href="registro.php">Registrarse</a>
</p>

    </form>
</div>

</div>
