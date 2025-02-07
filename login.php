<?php

include("conexion.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = mysqli_real_escape_string($conexion, $_POST["user"]);
    $passwd = mysqli_real_escape_string($conexion, $_POST["passwd"]);

    $query = "SELECT passwd FROM cuentas WHERE user = '$user'";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $datos = mysqli_fetch_assoc($resultado);
        $passwdTemp = $datos["contrasena"];

        if (password_verify($passwd, $passwdTemp)) {
            //Condicional para enviar a pagina de admin o normal
            header("Location: inicio.php");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    
    <div class="contenedor">
        <form action="inicio.php" method="POST">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" name="user" placeholder="Usuario" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="passwd" placeholder="Contraseña" required>
                <i class='bx bxs-lock-alt' ></i>
            </div>  

            <div class="olvido-contra">
                <label><input type="checkbox"> Recuerdame</label>
                <a href="">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit" class="btn">Login</button>

            <?php if ($error): 
                echo "<p style='color: red;'><?= $error ?></p>";
            endif; 
            ?>

        </form>
    </div>

</body>
</html>