<?php

session_start();
include('conexion.php');

$verificado = $_SESSION["verificado"];

if (!$verificado) {
    die("<h1> Acceso no permitido, debes iniciar sesion primero </h1>");
}

$nombre = $_SESSION["nombre"];


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
                <p>
                    <?php 
                        $query = "SELECT DATE_FORMAT(CURRENT_DATE, '%d-%m-%Y') AS dia_actual;";
                        $resultado = mysqli_query($conexion, $query);
                        $datos = mysqli_fetch_assoc($resultado);

                        echo $datos["dia_actual"] 
                    ?>
                </p>
            </header>

            <section class="stats">
                <div class="card">
                    <h3>Ventas Totales</h3>
                    <p>
                        <?php
                            $query = "SELECT COUNT(*) AS ventas_totales FROM ventas;";
                            $resultado = mysqli_query($conexion, $query);
                            $datos = mysqli_fetch_assoc($resultado);

                            echo $datos["ventas_totales"] 
                        ?>
                    </p>
                </div>
                <div class="card">
                    <h3>Nº de Clientes</h3>
                    <p>
                        <?php
                            $query = "SELECT COUNT(*) AS cantidad_cli FROM clientes;";
                            $resultado = mysqli_query($conexion, $query);
                            $datos = mysqli_fetch_assoc($resultado);

                            echo $datos["cantidad_cli"] 
                        ?>
                    </p>
                </div>
                <div class="card">
                    <h3>Ganancias Totales</h3>
                    <p>
                        <?php
                            $query = "SELECT SUM(monto) AS ganancia_total FROM ventas;";
                            $resultado = mysqli_query($conexion, $query);
                            $datos = mysqli_fetch_assoc($resultado);

                            echo $datos["ganancia_total"] . " €";
                        ?>
                    </p>
                </div>
            </section>

            <section class="orders">
                <h2>Ventas Recientes</h2>
                <table>
                    <thead>
                        <th>Producto</th>
                        <th>ID Venta</th>
                        <th>Pago</th>
                        <th>Monto</th>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT v.nombre AS nombre, v.id_venta AS id, tp.nombre AS tipo, v.monto AS monto 
                                        FROM ventas AS v, tipo_pago AS tp
                                        WHERE v.id_tipo_pago = tp.id
                                        ORDER BY fecha DESC
                                        LIMIT 5;";
                            $resultado = mysqli_query($conexion, $query);
                            while ($row = mysqli_fetch_assoc($resultado)){
                                echo "<tr>
                                        <td>" . $row['nombre'] . "</td>
                                        <td>" . $row['id'] . "</td>
                                        <td>" . $row['tipo'] . "</td>
                                        <td>" . $row['monto'] . " €</td>
                                    </tr>";
                            }
                        ?>
                    </tbody>
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