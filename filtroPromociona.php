<?php
include('conexion.php');
$query = "SELECT id, nombre, edad, curso, promociona FROM alumnos";
$resultado = mysqli_query($conexion, $query);

echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Edad</th>
            <th>Curso</th>
            <th>Promociona</th>
        </tr>";

// Recorrer cada fila de resultados y mostrarla
while ($row = mysqli_fetch_assoc($resultado)) {
        if($row['promociona'] == $_POST["promociona"]){
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['nombre'] . "</td>
                    <td>" . $row['edad'] . "</td>
                    <td>" . $row['curso'] . "</td>
                    <td>" . $row['promociona'] . "</td>
            </tr>";
        }
}

// Cerrar la tabla HTML
echo "</table>";

?>