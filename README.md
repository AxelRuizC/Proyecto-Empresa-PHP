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


## 2.- Configuración de Conexión a la Base de Datos
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


## 3.- Creacion del interfaz Login para inicio de sesion.

