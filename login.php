<?php

session_start();
include("conexion.php");

$error = "";
$verificado = "FALSE";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = mysqli_real_escape_string($conexion, $_POST["user"]);
    $passwd = mysqli_real_escape_string($conexion, $_POST["passwd"]);

    $query = "SELECT passwd FROM correocorp WHERE user = '$user'";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $datos = mysqli_fetch_assoc($resultado);
        $passwdTemp = $datos["passwd"];
        $passwdMD5 = md5($passwd);

        if ($passwdMD5 == $passwdTemp) {

            $query = "SELECT t.* 
                        FROM correocorp AS c, trabajadores AS t 
                        WHERE c.cod_trabajador = t.cod AND c.user = '$user'";
            $resultado = mysqli_query($conexion, $query);
            $datos = mysqli_fetch_assoc($resultado);
            $verificado = "TRUE";

            $_SESSION["nombre"] = $datos["nombre"];
            $_SESSION["admin"] = $datos["admin"];
            $_SESSION['user'] = $user;
            $_SESSION["verificado"] = $verificado;

            if(isset($_POST['recordar'])) {
                setcookie('user', $user, time() + (86400 * 30));
            }

            if($datos["admin"] == 1){
                header("Location: inicioAdmin.php");
                die();
            } elseif($datos["admin"] == 0){
                header("Location: inicioNormal.php");
                die();
            } else{
                $error = "Sin puesto asignado";
            }
            
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}

if(isset($_COOKIE['user'])){
    $_SESSION['user'] = $_COOKIE['user'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body>
    
    <div class="contenedor">
        <form action="" method="POST">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" name="user" placeholder="Usuario" required>
                <i class="bx bxs-user"></i>
            </div>
            <div class="input-box">
                <input type="password" name="passwd" placeholder="Contraseña" required>
                <i class="bx bxs-lock-alt" ></i>
            </div>  

            <div class="olvido-contra">
                <label><input type="checkbox" name="recordar"> Mantener mi sesion abierta</label>
            </div>

            <button type="submit" class="btn">Login</button>

            <?php if ($error): ?>
                <p style='color: red;'><?php echo $error; ?></p>
            <?php endif; ?>

        </form>
    </div>

</body>
</html>


