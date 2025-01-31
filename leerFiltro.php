<?php
// Incluir el archivo de conexión (si es necesario)
include('conexion.php');
?>
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
    <div class="container mt-4">
        <h2 class="text-center mb-4">Listado de Estudiantes Filtrado</h2>

        
<?php

// Verificar si se ha enviado el formulario por POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['nombre']) && !empty($_POST['nombre'])){
            $nombre = $_POST['nombre'];
            $query = "SELECT id, nombre, edad, curso, promociona FROM alumnos WHERE nombre LIKE '$nombre';";}
        // Comprobación de la edad
        elseif (isset($_POST['edad']) && !empty($_POST['edad'])){
            $edad = $_POST['edad'];
            $query = "SELECT id, nombre, edad, curso, promociona FROM alumnos WHERE edad = '$edad';";}
        // Comprobación del curso
        elseif (isset($_POST['curso']) && !empty($_POST['curso'])) {
            $curso = $_POST['curso'];
            $query = "SELECT id, nombre, edad, curso, promociona FROM alumnos WHERE curso LIKE '$curso';";}
        // Comprobación del promociona
        elseif (isset($_POST['promociona'])) {
            $promociona = $_POST['promociona'];
            $query = "SELECT id, nombre, edad, curso, promociona FROM alumnos WHERE promociona = '$promociona';";}
        else {
                echo "<div class='container mt-4'>
                        <h2>Datos proporcionados incorrectos</h2>
                      </div>";
        }

        $resultado = mysqli_query($conexion, $query);

        // Verificar si la consulta fue exitosa
        if (mysqli_num_rows($resultado) == 0) {
            //pngo un mensaje para explicar que no se ha encontrado
            //un alumno con ese nombre.

            //Le facilito un enlace al fichero de alta de alumnos, por si quiere introducirlo.

            // Le puedo facilitar un enlace al fichero que muestra todos los alumnos.

            // Añado un boton de volver para, que vuelva a la pagina de opciones.php.
            ?>
            <div class="card-body">
                <div class="mb-3">
                    <a href="introducirDatos.php" class="btn btn-primary">Introducir alumnos</a>
                </div>

                <div class="mb-3">
                    <a href="filtroTodos.php" class="btn btn-primary">Ver alumnos</a>
                </div>

                <div class="mb-3">
                    <a href="opciones.php" class="btn btn-primary">Volver</a>
                </div>
            </div>
            <?php
        }

        // Mostrar los resultados en formato de tabla
        echo "<div class='container mt-4'>
                <h2>Resultados: </h2>
                <table class='table table-bordered table-striped'>
                    <thead class='thead-dark'>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Curso</th>
                            <th>Promociona</th>
                        </tr>
                    </thead>
                    <tbody>";

        // Recorrer cada fila de resultados y mostrarla
        while ($row = mysqli_fetch_assoc($resultado)) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['nombre'] . "</td>
                    <td>" . $row['edad'] . "</td>
                    <td>" . $row['curso'] . "</td>
                    <td>" . $row['promociona'] . "</td>
                </tr>";
        }

        echo "</tbody></table> <h1>'$promociona'</h1></div>";
    } else {
    echo "<div class='container mt-4'>
            <h2>Acceso no permitido. El formulario debe enviarse mediante POST.</h2>
          </div>";
}

?>
</body>
</html>