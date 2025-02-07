<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Estudiantes filtrado por nombre</title>
    
    <!-- Link al CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<?php
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['user']) && !empty($_POST['user']) && isset($_POST['passwd']) && !empty($_POST['passwd'])){
        $user = $_POST['user'];
        $query = "SELECT tipo FROM empleados WHERE user LIKE '$user';";
    } else{
        echo "<div class='container mt-4'>
                        <h2>Datos proporcionados incorrectos</h2>
            </div>";
    }

    $resultado = mysqli_query($conexion, $query);

    if($resultado == "admin"){
        //Pagina Admin
        header("Location: opciones.php"); //Intento de redireccion
        die();
    } elseif($resultado == "normal"){
        //Pagina Empleado
    } 


}    
?>
