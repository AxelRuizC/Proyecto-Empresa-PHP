<?php

session_start();
include('conexion.php');

@$verificado = $_SESSION["verificado"];

if (!$verificado) {
    header("Location: login.php");
    die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['form_id'])) {
        $form_id = $_POST['form_id'];

        if ($form_id == 'form1') {
            if (isset($_POST['descripcion']) && !empty($_POST['descripcion'])) {
                $descripcion = $_POST['descripcion'];
            
                if (isset($_POST['cantidad']) && !empty($_POST['cantidad'])) {
                    $cantidad = $_POST['cantidad'];
                    
                    $sql = "INSERT INTO productos (descripcion, cantidad) VALUES ('$descripcion', '$cantidad') ;";
                    
                    $resultado = mysqli_query($conexion, $sql);

                }
              
            }
        } elseif ($form_id == 'form2') {
            if (isset($_POST['cod']) && !empty($_POST['cod'])) {
                $cod = $_POST['cod'];

                $sql = "DELETE FROM productos WHERE cod = '$cod';";
                $resultado = mysqli_query($conexion, $sql);
                
                $sql = "ALTER TABLE productos AUTO_INCREMENT = 1;";
                $resultado = mysqli_query($conexion, $sql);
            }
        }
        elseif ($form_id == 'form3') {
            if (isset($_POST['cod']) && !empty($_POST['cod'])) {
              $codPrincip = $_POST['cod'];
  
              if (isset($_POST['descripcion'])  && !empty($_POST['descripcion'])) {
                $condiciones[] = "descripcion";
                $parametros[] = $_POST['descripcion'];
              }
              if (isset($_POST['cantidad'])  && !empty($_POST['cantidad'])) {
                $condiciones[] = "cantidad";
                $parametros[] = $_POST['cantidad'];
              }

              for($i=0, $size=count($condiciones); $i < $size; $i++){
                $query = "UPDATE productos SET $condiciones[$i] = '$parametros[$i]' WHERE cod LIKE $codPrincip;";

                $resultado = mysqli_query($conexion, $query);
              }
            }
        }
    }

    ?>
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="refresh"
    content="0.2;URL=?">
    <?php
}

@$administrador = $_SESSION["administer"];

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
                    echo '<li><i class="ri-store-line"></i><a href="productos.php"> Productos</a></li>';
                }
                ?>
                <li><i class="ri-user-line"></i><a href="clientes.php"> Clientes</a></li>
                <li><i class="ri-cash-line"></i><a href="ventas.php"> Ventas</a></li>
                <li><i class="ri-shut-down-line"></i><a href="logout.php"> Cerrar Sesión</a></li>
            </ul>
        </aside>

        <main class="contenido-principal">
            <header>
                <h1>Area Productos</h1>
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
                
                    <!-- Agregar Producto -->
                
                    <div>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AgregarPModal">
                          Agregar
                        </button>

                        <!-- Pop up -->

                        <div class="modal fade" id="AgregarPModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content modal-contentS">
                              <div class="modal-body">

                                <div class="content-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Producto</h1>
                                </div>  

                                <hr>

                                <!-- Formulario -->

                                <form action="" method="POST">
                                    <input type="hidden" name="form_id" value="form1">
                                  <div class="form-group">
                                    <label for="descripcion" >Nombre del Producto: </label>
                                    <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                                  </div>

                                  <div class="form-group">
                                    <label for="cantidad" >Cantidad Disponible: </label>
                                    <input type="number" class="form-control" id="cantidad" name="cantidad" required>
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
                    
                    <!-- Eliminar Producto -->

                    <div>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EliminarPModal">
                          Eliminar
                        </button>

                        <!-- Pop up -->

                        <div class="modal fade" id="EliminarPModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-body">

                                <div class="content-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar Producto</h1>
                                </div>  

                                <hr>

                                <!-- Formulario -->

                                <form action="" method="POST">
                                    <input type="hidden" name="form_id" value="form2">
                                  <div class="form-group">
                                    <label for="cod" >Código del Producto </label>
                                    <input type="text" class="form-control" id="cod" name="cod" required>
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

                    <!-- Modificar Producto -->

                    <div>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModPModal">
                          Modificar
                        </button>

                        <!-- Pop up -->

                        <div class="modal fade" id="ModPModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content modal-contentM">
                              <div class="modal-body">

                                <div class="content-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar Producto</h1>
                                </div>  

                                <hr>

                                <!-- Formulario -->

                                <form action="" method="POST">
                                <input type="hidden" name="form_id" value="form3">

                                <div class="form-group">
                                    <label for="cod" >Código del Producto: </label>
                                    <input type="number" class="form-control" id="cod" name="cod" required>
                                  </div>

                                  <div class="form-group">
                                    <label for="descripcion" >Nombre del Producto: </label>
                                    <input type="text" class="form-control" id="descripcion" name="descripcion">
                                  </div>

                                  <div class="form-group">
                                    <label for="cantidad" >Cantidad: </label>
                                    <input type="number" class="form-control" id="cantidad" name="cantidad">
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

            <!-- Tabla Principal -->

            <section class="orders">
                <h2>Productos Totales: <?php
                            $query = "SELECT COUNT(*) AS productos_totales FROM productos;";
                            $resultado = mysqli_query($conexion, $query);
                            $datos = mysqli_fetch_assoc($resultado);

                            echo $datos["productos_totales"] 
                        ?></h2>
                <table>
                    <thead>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Cantidad Disponible</th>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT p.cod AS codigo, p.descripcion AS nombre, p.cantidad AS cantidad
                                        FROM productos AS p
                                        ORDER BY cod ASC";
                            $resultado = mysqli_query($conexion, $query);
                            while ($row = mysqli_fetch_assoc($resultado)){
                                echo "<tr>
                                        <td>" . $row['codigo'] . "</td>
                                        <td>" . $row['nombre'] . "</td>
                                        <td>" . $row['cantidad'] . "</td>
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