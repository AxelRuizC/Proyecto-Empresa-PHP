<?php

session_start();
include('conexion.php');

@$verificado = $_SESSION["verificado"];

if (!$verificado) {
    header("Location: login.php");
    die();
}

$nombre = $_SESSION["nombre"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Compruebo que entrado en introducir.php por llamada POST
    echo "Estoy dentro de post";
    if (isset($_POST['form_id'])) {
        $form_id = $_POST['form_id'];

        if ($form_id == 'form1') {
            if (isset($_POST['id_cliente']) && !empty($_POST['id_cliente'])) {
                $id_cliente = $_POST['id_cliente'];
            
                if (isset($_POST['id_trabajador']) && !empty($_POST['id_trabajador'])) {
                    $id_trabajador = $_POST['id_trabajador'];
                
                    if (isset($_POST['nombre']) && !empty($_POST['nombre'])) {
                        $nombre = $_POST['nombre'];
                    
                        if (isset($_POST['id_tipo_pago']) && !empty($_POST['id_tipo_pago'])) {
                            $id_tipo_pago = $_POST['id_tipo_pago'];
                        
                            if (isset($_POST['monto']) && !empty($_POST['monto'])) {
                                $monto = $_POST['monto'];
                            
                                $sql = "INSERT INTO ventas (id_cliente, id_trabajador, nombre, id_tipo_pago, monto) VALUES ('$id_cliente', '$id_trabajador', '$nombre', '$id_tipo_pago', '$monto') ;";
                                $resultado = mysqli_query($conexion, $sql);

                            }
                        }
                    }
                }
            }
        } elseif ($form_id == 'form2') {
            if (isset($_POST['id_venta']) && !empty($_POST['id_venta'])) {
                $id_venta = $_POST['id_venta'];

                $sql = "DELETE FROM ventas WHERE id_venta = '$id_venta';";
                $resultado = mysqli_query($conexion, $sql);
                
                $sql = "ALTER TABLE ventas AUTO_INCREMENT = 1;";
                $resultado = mysqli_query($conexion, $sql);
            }
        }
    }

    ?>
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="refresh"
    content="0.2;URL=?">
    <?php
}


/* if (isset($_GET['form_id'])) {
    $form_id = $_GET['form_id'];

    if ($form_id == 'form1') {
        // Procesar el formulario 1
        echo "Formulario 1 enviado: " . htmlspecialchars($_GET['fname']) . " " . htmlspecialchars($_GET['lname']);
    } elseif ($form_id == 'form2') {
        // Procesar el formulario 2
        echo "Formulario 2 enviado: " . htmlspecialchars($_GET['email']);
    } elseif ($form_id == 'form3') {
        // Procesar el formulario 3
        echo "Formulario 3 enviado: " . htmlspecialchars($_GET['age']);
    }
} else {
    echo "No se envió ningún formulario.";
}
*/


?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    </head>
<body>

    <div class="contenedor">

        <aside class="sidebar">
            <img src="src/logo.png" alt="logo de la empresa" class="logo-empresa">
            <h2>Global Inc.</h2>
            <ul>
                <li><i class="ri-dashboard-line"></i><a href="inicioNormal.php"> Dashboard</a></li>
                <li><i class="ri-user-line"></i><a href="clientes.php"> Clientes</a></li>
                <li><i class="ri-cash-line"></i><a href="ventas.php"> Ventas</a></li>
            </ul>
        </aside>

        <main class="contenido-principal">
            <header>
                <h1>Area Ventas</h1>
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
                <div class="acciones">   
                
                    <!-- Agregar Venta -->
                
                    <div>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AgregarModal">
                          Agregar Venta
                        </button>

                        <!-- Pop up -->

                        <div class="modal fade" id="AgregarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-body">

                                <div class="content-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Venta</h1>
                                </div>  

                                <hr>

                                <!-- Formulario -->

                                <form action="" method="POST">
                                    <input type="hidden" name="form_id" value="form1">
                                  <div class="form-group">
                                    <label for="id_cliente" >ID Cliente: </label>
                                    <input type="text" class="form-control" id="id_cliente" name="id_cliente" required>
                                  </div>

                                  <div class="form-group">
                                    <label for="id_trabajador" >ID Trabajador: </label>
                                    <input type="text" class="form-control" id="id_trabajador" name="id_trabajador" required>
                                  </div>

                                  <div class="form-group">
                                    <label for="nombre" ">Producto: </label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                  </div>

                                  <div class="form-group">
                                    <label for="id_tipo_pago" >Tipo de Pago: </label>
                                    <select id="id_tipo_pago" name="id_tipo_pago" required>
                                        <option value="" disabled selected>Selecciona una opcion:</option>
                                        <option value="1">Transferencia</option>
                                        <option value="2">Efectivo</option>
                                        <option value="3">Tarjeta</option>
                                    </select>
                                  </div>

                                  <div class="form-group">
                                    <label for="monto" class="col-form-label">Monto:</label>
                                    <input type="number" class="form-control" id="monto" name="monto" min="50" step="0.05" required>
                                  </div>

                                  <div class="modal-footer">
                                    <button type="reset" class="btn btn-secondary" data-bs-reset="modal">Resetear</button>
                                    <button type="submit" class="btn btn-primary" data-bs-reset="modal">Aceptar</button>
                                    </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>   
                    
                    <!-- Eliminar Venta -->

                    <div>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EliminarModal">
                          Eliminar Venta
                        </button>

                        <!-- Pop up -->

                        <div class="modal fade" id="EliminarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-body">

                                <div class="content-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar Venta</h1>
                                </div>  

                                <hr>

                                <!-- Formulario -->

                                <form action="" method="POST">
                                    <input type="hidden" name="form_id" value="form2">
                                  <div class="form-group">
                                    <label for="id_cliente" >ID Venta: </label>
                                    <input type="text" class="form-control" id="id_venta" name="id_venta" required>
                                  </div>

                                  <div class="modal-footer">
                                    <button type="reset" class="btn btn-secondary" data-bs-reset="modal">Resetear</button>
                                    <button type="submit" class="btn btn-primary">Aceptar</button>
                                    </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>

                </div>
            </section>

            <!-- Ventas Principal -->

            <section class="orders">
                <h2>Ventas Totales: <?php
                            $query = "SELECT COUNT(*) AS ventas_totales FROM ventas;";
                            $resultado = mysqli_query($conexion, $query);
                            $datos = mysqli_fetch_assoc($resultado);

                            echo $datos["ventas_totales"] 
                        ?></h2>
                <table>
                    <thead>
                        <th>ID Venta</th>
                        <th>Producto</th>
                        <th>Pago</th>
                        <th>Monto</th>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT v.nombre AS nombre, v.id_venta AS id, tp.nombre AS tipo, v.monto AS monto, v.fecha AS fecha
                                        FROM ventas AS v, tipo_pago AS tp
                                        WHERE v.id_tipo_pago = tp.id
                                        ORDER BY id DESC";
                            $resultado = mysqli_query($conexion, $query);
                            while ($row = mysqli_fetch_assoc($resultado)){
                                echo "<tr>
                                        <td>" . $row['id'] . "</td>
                                        <td>" . $row['nombre'] . "</td>
                                        <td>" . $row['tipo'] . "</td>
                                        <td>" . $row['monto'] . " €</td>
                                        <td>" . $row['fecha'] . "</td>
                                    </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
</body>
</html>