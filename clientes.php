<?php

session_start();
include('conexion.php');

@$verificado = $_SESSION["verificado"];

if (!$verificado) {
    header("Location: login.php");
    die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "Estoy dentro de post";
    if (isset($_POST['form_id'])) {
        $form_id = $_POST['form_id'];

        if ($form_id == 'form1') {
            if (isset($_POST['dni']) && !empty($_POST['dni'])) {
                $dni = $_POST['dni'];
            
                if (isset($_POST['nombre']) && !empty($_POST['nombre'])) {
                    $nombre = $_POST['nombre'];
                
                    if (isset($_POST['apellido']) && !empty($_POST['apellido'])) {
                        $apellido = $_POST['apellido'];
                    
                        if (isset($_POST['telefono']) && !empty($_POST['telefono'])) {
                            $telefono = $_POST['telefono'];
                        
                            if (isset($_POST['zona']) && !empty($_POST['zona'])) {
                                $zona = $_POST['zona'];

                            $sql = "INSERT INTO clientes (dni, nombre, apellido, telefono, zona) VALUES ('$dni', '$nombre', '$apellido', '$telefono', $zona) ;";
                            $resultado = mysqli_query($conexion, $sql);
                         
                            }
                        }
                    }
                }
            }
        } elseif ($form_id == 'form2') {
            if (isset($_POST['dni']) && !empty($_POST['dni'])) {
                $dni = $_POST['dni'];

                $sql = "DELETE FROM clientes WHERE dni = '$dni';";
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

@$administrador = $_SESSION["admin"];

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
                <h1>Area Clientes</h1>
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

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AgregarCModal">
                          Agregar Cliente
                        </button>

                        <!-- Pop up -->

                        <div class="modal fade" id="AgregarCModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-body">

                                <div class="content-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Cliente</h1>
                                </div>  

                                <hr>

                                <!-- Formulario -->

                                <form action="" method="POST">
                                    <input type="hidden" name="form_id" value="form1">
                                  <div class="form-group">
                                    <label for="dni" >DNI: </label>
                                    <input type="text" class="form-control" id="dni" name="dni" required>
                                  </div>

                                  <div class="form-group">
                                    <label for="nombre" >Nombre: </label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                  </div>

                                  <div class="form-group">
                                    <label for="apellido" ">Apellido: </label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                                  </div>

                                  <div class="form-group">
                                    <label for="telefono" ">Telefono: </label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                                  </div>

                                  <div class="form-group">
                                    <label for="zona" >Zona: </label>
                                    <select id="zona" name="zona" required>
                                        <option value="" disabled selected>Selecciona una opcion:</option>
                                        <option value="1">Sevilla</option>
                                        <option value="2">Córdoba</option>
                                        <option value="3">Granada</option>
                                        <option value="4">Huelva</option>
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
                    
                    <!-- Eliminar Venta -->

                    <div>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EliminarCModal">
                          Eliminar Cliente
                        </button>

                        <!-- Pop up -->

                        <div class="modal fade" id="EliminarCModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-body">

                                <div class="content-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar Cliente</h1>
                                </div>  

                                <hr>

                                <!-- Formulario -->

                                <form action="" method="POST">
                                    <input type="hidden" name="form_id" value="form2">
                                  <div class="form-group">
                                    <label for="dni" >DNI: </label>
                                    <input type="text" class="form-control" id="dni" name="dni" required>
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
                <h2>Clientes Totales: <?php
                            $query = "SELECT COUNT(*) AS clientes_totales FROM clientes;";
                            $resultado = mysqli_query($conexion, $query);
                            $datos = mysqli_fetch_assoc($resultado);

                            echo $datos["clientes_totales"] 
                        ?></h2>
                <table>
                    <thead>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Fecha de Registro</th>
                        <th>Zona</th>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT c.dni AS dni, CONCAT(c.nombre,' ',c.apellido) AS nombre, c.telefono AS telefono, c.fecha_alta AS fecha, z.descripcion AS zona
                                        FROM clientes AS c, zonas AS z
                                        WHERE c.zona = z.cod
                                        ORDER BY nombre ASC";
                            $resultado = mysqli_query($conexion, $query);
                            while ($row = mysqli_fetch_assoc($resultado)){
                                echo "<tr>
                                        <td>" . $row['dni'] . "</td>
                                        <td>" . $row['nombre'] . "</td>
                                        <td>" . $row['telefono'] . "</td>
                                        <td>" . $row['fecha'] . "</td>
                                        <td>" . $row['zona'] . "</td>
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