<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leer Datos PHP</title>
    <link rel="stylesheet" href="css/stylesheet.css">
</head>

<body>
    <section class="contenedor">
        <h1>Leer Datos:</h1>
        <form action="filtroTodos.php">
            <h3>Ver todos los alumnos ==> <button type="submit">Ver</button> </h3>
        </form>


        <h2>Filtros</h2>
        <form action="filtroNombre.php" method="GET">
            <h4>Por nombre: <input type="text" name="nombre" id="nombreAlumno"></input> <button type="submit">ver</button> </h4>
        </form>
        <form action="filtroEdad.php" method="GET">
            <h4>Por edad > a: <input type="text" name="edad" id="edadAlumno"></input> <button type="submit">ver</button> </h4>
        </form>
        <form action="filtroPromociona.php" method="GET">
            <h4>Por promociona: <input type="text" name="promociona" id="prmocionaAlumno"></input> <button type="submit">ver</button> </h4>
        </form>
    </section>
</body>

</html>