<?php

session_start();
include('conexion.php');

@$verificado = $_SESSION["verificado"];

if (!$verificado) {
    header("Location: login.php");
    die();
}

@$administrador = $_SESSION["admin"];

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
                <li><i class="ri-dashboard-line"></i><a 
                <?php 
                if($administrador == 1){
                    echo 'href="inicioAdmin.php"';
                } else{
                    echo 'href="inicioNormal.php"';
                }
                ?>> Dashboard</a></li>
                <?php 
                if($administrador == 1){
                    echo '<li><i class="ri-id-card-line"></i><a href="trabajadores.php"> Trabajadores</a></li>';
                }
                ?>
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
                          Agregar
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
                                    <label for="dni_cliente" >DNI Cliente: </label>
                                    <input type="text" class="form-control" id="dni_cliente" name="dni_cliente" required>
                                  </div>

                                  <div class="form-group">
                                    <label for="cod_trabajador" >ID Trabajador: </label>
                                    <input type="text" class="form-control" id="cod_trabajador" name="cod_trabajador" required>
                                  </div>

                                  <div class="form-group">
                                    <label for="cod_producto" >Producto: </label>
                                    <select id="cod_producto" name="cod_producto" required>
                                        <option value="" disabled selected>Selecciona una opcion:</option>
                                        <option value="1">Ordenador portátil</option>
                                        <option value="2">Teléfono móvil</option>
                                        <option value="3">Tablet</option>
                                        <option value="4">Auriculares Bluetooth</option>
                                    </select>
                                  </div>

                                  <div class="form-group">
                                    <label for="cod_tipo_pago" >Tipo de Pago: </label>
                                    <select id="cod_tipo_pago" name="cod_tipo_pago" required>
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
                          Eliminar
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
                                    <label for="cod_venta" >ID Venta: </label>
                                    <input type="text" class="form-control" id="cod_venta" name="cod_venta" required>
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

                    <!-- Filtro Buscar -->

                    <div>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#BuscarModal">
                          Buscar
                        </button>

                        <!-- Pop up -->

                        <div class="modal fade" id="BuscarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-body">

                                <div class="content-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Buscar Venta</h1>
                                </div>  

                                <hr>

                                <!-- Formulario -->

                                <form action="ventasF.php" method="POST">
                                    <input type="hidden" name="form_id" value="form1">

                                <div class="form-group">
                                    <label for="cod" >Código Venta: </label>
                                    <input type="text" class="form-control" id="cod" name="cod">
                                  </div>

                                  <div class="form-group">
                                    <label for="dni_cliente" >DNI Cliente: </label>
                                    <input type="text" class="form-control" id="dni_cliente" name="dni_cliente">
                                  </div>

                                  <div class="form-group">
                                    <label for="cod_trabajador" >ID Trabajador: </label>
                                    <input type="text" class="form-control" id="cod_trabajador" name="cod_trabajador">
                                  </div>

                                  <div class="form-group">
                                    <label for="cod_producto" >Producto: </label>
                                    <select id="cod_producto" name="cod_producto">
                                        <option value="" disabled selected>Selecciona una opcion:</option>
                                        <option value="1">Ordenador portátil</option>
                                        <option value="2">Teléfono móvil</option>
                                        <option value="3">Tablet</option>
                                        <option value="4">Auriculares Bluetooth</option>
                                    </select>
                                  </div>

                                  <div class="form-group">
                                    <label for="cod_tipo_pago" >Tipo de Pago: </label>
                                    <select id="cod_tipo_pago" name="cod_tipo_pago">
                                        <option value="" disabled selected>Selecciona una opcion:</option>
                                        <option value="2">Transferencia</option>
                                        <option value="1">Efectivo</option>
                                        <option value="3">Tarjeta</option>
                                    </select>
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

                </div>
            </section>

            <!-- Ventas Principal -->

            <section class="orders">
                <table>
                    <thead>
                        <th>ID Venta</th>
                        <th>Producto</th>
                        <th>Pago</th>
                        <th>Monto</th>
                        <th>Fecha de Venta</th>
                    </thead>
                    <tbody>
                        <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
                              
                              $condiciones = [];
                              $parametros = [];

                              if (isset($_POST['cod']) && !empty($_POST['cod'])) {
                                  $condiciones[] = "cod";
                                  $parametros[] = $_POST['cod'];
                              }
                              if (isset($_POST['dni_cliente']) && !empty($_POST['dni_cliente'])) {
                                  $condiciones[] = "dni_cliente";
                                  $parametros[] = $_POST['dni_cliente'];
                              }
                              if (isset($_POST['cod_trabajador']) && !empty($_POST['cod_trabajador'])) {
                                  $condiciones[] = "cod_trabajador";
                                  $parametros[] = $_POST['cod_trabajador'];
                              }
                              if (isset($_POST['cod_producto'])) {
                                  $condiciones[] = "cod_producto";
                                  $parametros[] = $_POST['cod_producto'];
                              }
                              if (isset($_POST['cod_tipo_pago'] )) {
                                  $condiciones[] = "cod_tipo_pago";
                                  $parametros[] = $_POST['cod_tipo_pago'];
                              }
                            }

                            for($i=0, $size=count($condiciones); $i < $size; $i++){
                              $query = "SELECT p.descripcion AS nombre, v.cod AS id, tp.descripcion AS tipo, v.monto AS monto, v.fecha_venta AS fecha
                                        FROM ventas AS v, tipo_pago AS tp, productos AS p, clientes AS c, trabajadores AS t
                                        WHERE v.cod_tipo_pago = tp.cod
                                        AND v.cod_producto = p.cod
                                        AND v.dni_cliente = c.dni
                                        AND v.cod_trabajador = t.cod
                                        AND v.$condiciones[$i] LIKE '$parametros[$i]';";

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