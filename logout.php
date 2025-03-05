<?php
session_start();


@$userName = $_SESSION["nombre"].$_SESSION["apellido"];
$ultimo_inicio = $_SESSION["ultimo_inicio"];
$ultimoLogin = "ultimo_inicio_".$userName;
$dateCookie  = $ultimo_inicio;
setcookie($ultimoLogin, $dateCookie, time() + (86400 * 30), "/");

unset($_SESSION['verificado']);

header("Location: login.php");

?>