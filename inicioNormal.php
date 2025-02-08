<?php

session_start();
include('conexion.php');

$nombre = $_SESSION["nombre"];

$query = "SELECT DATE_FORMAT(CURRENT_DATE, '%d-%m-%Y') AS dia_actual;";
$resultado = mysqli_query($conexion, $query);
$datos = mysqli_fetch_assoc($resultado);

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css">
    <link rel="stylesheet" href="css/style.css">
    </head>
<body>

    <div class="contenedor">

        <aside class="sidebar">
            <h2>Global Inc.</h2>
            <ul>
                <li><i class="ri-dashboard-line"></i> Dashboard</li>
                <li><i class="ri-user-line"></i> Clientes</li>
                <li><i class="ri-cash-line"></i> Ventas</li>
            </ul>
        </aside>

        <main class="contenido-principal">
            <header>
                <h1>Bienvenid@ <?php echo htmlspecialchars($nombre); ?></h1>
                <p><?php echo $datos["dia_actual"] ?></p>
            </header>

            <section class="stats">
                <div class="card">
                    <h3>Ventas Totales</h3>
                    <p>25200</p>
                </div>
                <div class="card">
                    <h3>Nº de Clientes</h3>
                    <p>123141</p>
                </div>
                <div class="card">
                    <h3>Ganancias Totales</h3>
                    <p>$10,865</p>
                </div>
            </section>

            <section class="orders">
                <h2>Ventas Recientes</h2>
                <table>
                    <tr>
                        <th>Producto</th>
                        <th>ID Venta</th>
                        <th>Pago</th>
                        <th>Monto</th>
                    </tr>
                    <tr>
                        <td>Google Pixel</td>
                        <td>858687</td>
                        <td>Transferencia</td>
                        <td>523 €</td>
                    </tr>
                    <tr>
                        <td>Iphone 15 pro</td>
                        <td>122322</td>
                        <td>Efectivo</td>
                        <td>1642 €</td>
                    </tr>
                    <tr>
                        <td>Samsung Galaxy S21</td>
                        <td>455645</td>
                        <td>Tarjeta</td>
                        <td>1300 €</td>
                    </tr>
                </table>
            </section>

            <section class="tasks">
                <h2>Tareas</h2>
                <button class="add-task">+ Añadir Tarea</button>
            </section>
        </main>
    </div>
<script src="src/script.js"></script>
    
</body>
</html>