<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opciones - Alumnos</title>
    <!-- Link al CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
</head>
<body>
    <div class="container mt-5">
        <h1>Opciones de Lectura de Datos</h1>
        
        <!-- Sección Leer Datos -->
        <div class="card my-4">
            <div class="card-header">
                <h3>Leer Datos</h3>
            </div>
            <div class="card-body">
                <!-- Botón Alumnos -->
                <div class="mb-3">
                    <a href="filtroTodos.php" class="btn btn-primary">Alumnos</a>
                </div>
                
                <!-- Formulario Ver Alumnos -->
                <form action="leerFiltro.php" method="POST">
                    <div class="mb-3">
                        <label for="nombreAlumno" class="form-label">Ver alumnos cuyo nombre sea:</label>
                        <input type="text" class="form-control" id="nombreAlumno" name="nombre" placeholder="Introduce el nombre del alumno" required>
                    </div>
                    <button type="submit" class="btn btn-success">Ver</button>
                </form>
                <!-- Formulario Ver Edad -->
                <form action="leerFiltro.php" method="POST">
                    <div class="mb-3">
                        <label for="edadAlumno" class="form-label">Ver alumnos cuya edad sea:</label>
                        <input type="text" class="form-control" id="edadAlumno" name="edad" placeholder="Introduce la edad del alumno" required>
                    </div>
                    <button type="submit" class="btn btn-success">Ver</button>
                </form>
                <!-- Formulario Ver Curso -->
                <form action="leerFiltro.php" method="POST">
                    <div class="mb-3">
                        <label for="cursoAlumno" class="form-label">Ver alumnos cuyo curso sea:</label>
                        <input type="text" class="form-control" id="cursoAlumno" name="curso" placeholder="Introduce el curso del alumno" required>
                    </div>
                    <button type="submit" class="btn btn-success">Ver</button>
                </form>
                <!-- Formulario Ver Promociona -->
                <form action="leerFiltro.php" method="POST">
                    <div class="mb-3">
                        <label for="promocionaAlumno" class="form-label">Ver alumnos por promociona:</label>
                        <br />
                        <select name="promociona" id="promocionaAlumno">
                            <option disabled selected>Selecciona una opcion</option>
                            <option value="0">No</option>
                            <option value="1">Si</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Ver</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>