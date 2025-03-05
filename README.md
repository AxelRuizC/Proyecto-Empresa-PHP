# Proyecto Empresa 

# 1.- Creacion de Base de Datos - Global Inc

Este proyecto utiliza una base de datos para gestionar una empresa (clientes, trabajadores, productos y ventas).

#### 📜 Código para la creacion de la Base de Datos global_inc
```sql
CREATE DATABASE global_inc;
USE global_inc;
```


## 📌 Tablas y Estructura

### 🔹 `Tabla zonas`
Clasificación de zonas geográficas.

| Campo       | Tipo         | Descripción |
|------------|-------------|-------------|
| `cod`      | INT(2)       | Clave Primaria. |
| `descripcion` | VARCHAR(20) | Nombre de la zona. |

#### 📜 Código para la creacion de la Tabla zonas
```sql
CREATE TABLE zonas (
  cod int(2) PRIMARY KEY,
  descripcion varchar(20) DEFAULT NULL
);
```


### 🔹 `Tabla clientes`
Almacena la información de los clientes registrados en el sistema.

| Campo       | Tipo         | Descripción                            |
|------------|-------------|----------------------------------------|
| `dni`      | VARCHAR(9)  | Clave Primaria. |
| `nombre`   | VARCHAR(50) | Nombre del cliente. |
| `apellido` | VARCHAR(50) | Apellido del cliente. |
| `telefono` | INT(9)      | Número de teléfono. |
| `fecha_alta` | DATE      | Fecha de registro (por defecto, fecha actual). |
| `zona`     | INT(2)      | Clave Foranea de la tabla zonas. |

#### 📜 Código para la creacion de la Tabla clientes
```sql
CREATE TABLE clientes (
  dni varchar(9) PRIMARY KEY,
  nombre varchar(50) NOT NULL,
  apellido varchar(50) NOT NULL,
  telefono int(9) DEFAULT NULL,
  fecha_alta date DEFAULT curdate(),
  zona int(2),
  FOREIGN KEY (zona) REFERENCES zonas(cod) ON DELETE SET NULL ON UPDATE CASCADE
);
```


### 🔹 `Tabla trabajadores`
Guarda la información de los empleados de la empresa.

| Campo      | Tipo         | Descripción |
|-----------|-------------|-------------|
| `cod`     | INT(3)       | Clave primaria. |
| `dni`     | VARCHAR(9)   | DNI del trabajador. |
| `nombre`  | VARCHAR(50)  | Nombre del trabajador. |
| `apellido` | VARCHAR(50) | Apellido del trabajador. |
| `admin`   | TINYINT(1)   | Indica si el trabajador tiene rol de administrador (1 = sí, 0 = no). |

#### 📜 Código para la creacion de la Tabla trabajadores
```sql
CREATE TABLE trabajadores (
    cod INT(3) AUTO_INCREMENT PRIMARY KEY,
    dni VARCHAR(9),
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    admin TINYINT(1) NOT NULL DEFAULT 0
);
```


### 🔹 `Tabla correocorp`
Contiene credenciales de acceso para correos corporativos.

| Campo         | Tipo         | Descripción |
|--------------|-------------|-------------|
| `cod_trabajador` | INT(3) | Identificador del trabajador asociado. |
| `user`       | VARCHAR(50) | Nombre de usuario del correo. |
| `passwd`     | VARCHAR(12) | Contraseña del correo. |

#### 📜 Código para la creacion de la Tabla correocorp
```sql
CREATE TABLE correoCorp (
    cod_trabajador INT(3),
    user VARCHAR(50),
    passwd VARCHAR(12),
    PRIMARY KEY (cod_trabajador, user),
    FOREIGN KEY (cod_trabajador) REFERENCES trabajadores(cod) ON DELETE CASCADE ON UPDATE CASCADE
);
```


### 🔹 `Tabla productos`
Lista los productos disponibles en el sistema.

| Campo        | Tipo         | Descripción |
|-------------|-------------|-------------|
| `cod`       | INT(3)       | Clave primaria. |
| `descripcion` | VARCHAR(50) | Descripción del producto. |
| `cantidad`  | INT(5)       | Stock disponible del producto. |

#### 📜 Código para la creacion de la Tabla productos
```sql
CREATE TABLE productos (
    cod INT(3) AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(50),
    cantidad INT(5)
);
```


### 🔹 `Tabla tipo_pago`
Define los tipos de pago aceptados.

| Campo        | Tipo         | Descripción |
|-------------|-------------|-------------|
| `cod`       | INT(2)       | Clave primaria. |
| `descripcion` | VARCHAR(20) | Nombre del método de pago. |

#### 📜 Código para la creacion de la Tabla tipo_pago
```sql
CREATE TABLE tipo_pago (
  cod int(2) PRIMARY KEY,
  descripcion varchar(20) DEFAULT NULL
);
```


### 🔹 `Tabla ventas`
Registra las transacciones realizadas en la empresa.

| Campo         | Tipo         | Descripción |
|--------------|-------------|-------------|
| `cod`        | INT(10)      | Clave primaria. |
| `dni_cliente` | VARCHAR(9)  | Cliente que realizó la compra. |
| `cod_trabajador` | INT(3)   | Trabajador que gestionó la venta. |
| `cod_producto` | INT(3)     | Producto vendido. |
| `cod_tipo_pago` | INT(10)   | Tipo de pago utilizado. |
| `monto`      | DECIMAL(10,2) | Monto total de la venta. |
| `fecha_venta` | DATE        | Fecha de la transacción (por defecto, fecha actual). |

#### 📜 Código para la creacion de la Tabla tipo_pago
```sql
CREATE TABLE ventas (
    cod INT(10) AUTO_INCREMENT PRIMARY KEY,
    dni_cliente VARCHAR(9),
    cod_trabajador INT(3),
    cod_producto INT(3),
    cod_tipo_pago INT(10),
    monto DECIMAL(10,2),
    fecha_venta DATE DEFAULT CURDATE(),
    FOREIGN KEY (dni_cliente) REFERENCES clientes(dni) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (cod_trabajador) REFERENCES trabajadores(cod) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (cod_producto) REFERENCES productos(cod) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (cod_tipo_pago) REFERENCES tipo_pago(cod) ON DELETE SET NULL ON UPDATE CASCADE
);
```


# 2.- Configuración de Conexión a la Base de Datos
El archivo `conexion.php` es el encargado de establecer la conexión con la base de datos.

### 📜 Código de `conexion.php`
```php
<?php
// Variables de conexión
$servidor = "localhost:3306"; // Nombre del servidor (por defecto localhost)
$usuario = "root";       // Usuario (por defecto root en XAMPP)
$contrasena = "";        // Contraseña (por defecto vacío en XAMPP)
$nombre_base_datos = "global_inc"; // Nombre de la base de datos

// Establecer la conexión
$conexion = mysqli_connect($servidor, $usuario, $contrasena, $nombre_base_datos);

// Verificar si la conexión fue exitosa
if (!$conexion) {
    die("Error de conexión al servidor MySQL: " . mysqli_connect_error());
}

// Verificar si la base de datos se ha seleccionado correctamente
if (!mysqli_select_db($conexion, $nombre_base_datos)) {
    die("Error al seleccionar la base de datos: " . mysqli_error($conexion));
}
?>
```

### ⚠️ Advertencias
- Este archivo usa `mysqli_connect()` para establecer la conexión.
- Si usas otro entorno, revisa que el usuario y contraseña sean correctos.


# 3.- Sistema de Autenticación y Login (login.php)

Este archivo maneja la **autenticación** de los usuarios:
- **Verifica** las credenciales ingresadas.
- **Inicia** la sesión si los datos son correctos.
- Redirige al usuario al panel correcto (admin o normal) según sus privilegios.

### Funciones
- **Formulario de inicio de sesión**: Campos para usuario y contraseña.
- **Verificación de credenciales**: Consulta en la base de datos para validar usuario.
- **Redirección** según rol: Admin vs. usuario normal.

### 📜 Código para la validacion de datos
```php
<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = mysqli_real_escape_string($conexion, $_POST["user"]);
    $passwd = mysqli_real_escape_string($conexion, $_POST["passwd"]);

    $query = "SELECT passwd FROM correocorp WHERE user = '$user'";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $datos = mysqli_fetch_assoc($resultado);
        $passwdTemp = $datos["passwd"];
        $passwdMD5 = md5($passwd);

        if ($passwdMD5 == $passwdTemp) {

            $query = "SELECT t.* 
                        FROM correocorp AS c, trabajadores AS t 
                        WHERE c.cod_trabajador = t.cod AND c.user = '$user'";
            $resultado = mysqli_query($conexion, $query);
            $datos = mysqli_fetch_assoc($resultado);
            $verificado = "TRUE";

            if($datos["administer"] == 1){
                header("Location: inicioAdmin.php");
                die();
            } elseif($datos["administer"] == 0){
                header("Location: inicioNormal.php");
                die();
            } else{
                $error = "Sin puesto asignado";
            }
            
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>
```


# 4.- Página de Inicio (Administrador y Normal)

Despues de realizar la autenticacion del login, dependiendo del tipo de trabajador que es te redirige a una interfaz u otra, ambas comparten la misma estructura pero la interfaz del administrador permite operar en los trabajadores en general, mientras que los normales solo operan sobre los clientes y las ventas.

Este archivo corresponde a la **pantalla o interfaz de inicio**:
- Suele mostrar **estadísticas**, **enlaces**, y otras funcionalidades.
- Puede validar la **sesión** del usuario para verificar que realmente tenga privilegios.


# 5.- Interfaz de Trabajadores (trabajadores.php)

Este archivo administra los **trabajadores o empleados** dentro del sistema:
- **Listado de trabajadores**: Muestra la información básica de los empleados.
- **Agregar trabajador**: Inserta un registro con los datos del empleado.
- **Editar trabajador**: Permite actualizar los datos.
- **Eliminar trabajador**: Da de baja a un empleado.

### 📜 Código de funcionamiento de los formularios:
```php
<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['form_id'])) {
        $form_id = $_POST['form_id'];

        if ($form_id == 'form1') {
            if (isset($_POST['dni']) && !empty($_POST['dni'])) {
                $dni = $_POST['dni'];
            
                if (isset($_POST['nombre']) && !empty($_POST['nombre'])) {
                    $nombre = $_POST['nombre'];
                
                    if (isset($_POST['apellido']) && !empty($_POST['apellido'])) {
                        $apellido = $_POST['apellido'];
                    
                        if (isset($_POST['administer'])) {
                            $administer = $_POST['administer'];

                            $sql = "INSERT INTO trabajadores (dni, nombre, apellido, administer) VALUES ('$dni', '$nombre', '$apellido', '$administer') ;";
                            $resultado = mysqli_query($conexion, $sql);
                         
                        }
                    }
                }
            }
        } elseif ($form_id == 'form2') {
            if (isset($_POST['cod']) && !empty($_POST['cod'])) {
                $cod = $_POST['cod'];

                $sql = "DELETE FROM trabajadores WHERE cod = '$cod';";
                $resultado = mysqli_query($conexion, $sql);
                
                $sql = "ALTER TABLE trabajadores AUTO_INCREMENT = 1;";
                $resultado = mysqli_query($conexion, $sql);
            }
        }
        elseif ($form_id == 'form3') {
            if (isset($_POST['dni']) && !empty($_POST['dni'])) {
              $codPrincip = $_POST['dni'];
  
              if (isset($_POST['nombre']) && !empty($_POST['nombre'])) {
                $condiciones[] = "nombre";
                $parametros[] = $_POST['nombre'];
              }
              if (isset($_POST['apellido']) && !empty($_POST['apellido'])) {
                  $condiciones[] = "apellido";
                  $parametros[] = $_POST['apellido'];
              }
              if (isset($_POST['telefono'])) {
                  $condiciones[] = "telefono";
                  $parametros[] = $_POST['telefono'];
              }
              if (isset($_POST['administer'])) {
                $condiciones[] = "administer";
                $parametros[] = $_POST['administer'];
            }
  
              for($i=0, $size=count($condiciones); $i < $size; $i++){
                $query = "UPDATE trabajadores SET $condiciones[$i] = '$parametros[$i]' WHERE dni LIKE '$codPrincip';";
  
                $resultado = mysqli_query($conexion, $query);
              }
            }
        }
    }
}
?>
```
Como se puede ver dependiendo del `$form_id` que se mande es que realizara una consulta u otra.


# 6.- Interfaz de Productos (productos.php)

Este archivo se encarga de la **gestión de productos**:
- **Creación y registro** de nuevos productos.
- **Lectura** y muestra de productos existentes en inventario.
- **Actualización** de información de un producto ya existente.
- **Eliminación** de un producto específico de la base de datos.

### 📌 Nota:
Esta interfaz trata de igual manera los formularios que la interfaz de trabajadores. 


# 7.- Interfaz de Clientes (clientes.php)

Este archivo gestiona los datos almacenados de los **clientes**:
- **Creación y registro** de nuevos clientes.
- **Lectura** y visualización de la información de los clientes existentes.
- **Actualización** de registros de clientes existentes.
- **Eliminación** de un registro de cliente.

### 📌 Nota:
Esta interfaz trata de igual manera los formularios que la interfaz de trabajadores. 


# 8.- Interfaz de Ventas (ventas.php)

Este archivo controla la **gestión de ventas**:
- **Creación y registro** de nuevas ventas.
- **Lectura** de ventas existentes, con detalles de productos, fechas, clientes, etc.
- **Busqueda** de ventas especificas mediante un filtro.
- **Actualización** en caso de errores o devoluciones.
- **Eliminación** de registros si procede.

### 📌 Nota:
Esta interfaz trata de igual manera los formularios que la interfaz de trabajadores. 


# 9.- Logout Script

Este script se encarga de **cerrar la sesión** del usuario y **redirigirlo** a la página de inicio de sesión (`login.php`).

## Descripción
1. **Elimina** la variable `$_SESSION['verificado']`, que generalmente indica que el usuario estaba autenticado.
2. **Redirige** inmediatamente a `login.php` para forzar que el usuario vuelva a autenticarse o mostrar el formulario de ingreso.
3. **Establece** la cookie la cual nos va a servir para saber el ultimo inicio de sesion de la cuenta.

## 📜 Código
```php
<?php
session_start();


@$userName = $_SESSION["nombre"].$_SESSION["apellido"];
$ultimo_inicio = $_SESSION["ultimo_inicio"];
$ultimoLogin = "ultimo_inicio_".$userName;
$dateCookie  = $ultimo_inicio;
setcookie($ultimoLogin, $dateCookie, time() + (86400 * 30), "/");

unset($_SESSION['verificado']);

header("Location: login.php");

?>
```

### ⚠️ Advertencias:
  - Asegurarse de tener la sesión iniciada previamente en la aplicación.
  - Verificar la existencia del archivo `login.php` para redirigir al usuario.






