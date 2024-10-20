## Instrucciones de Configuración

### Crear la Base de Datos
Ejecuta el siguiente script SQL para crear la base de datos y las tablas necesarias:

sql
CREATE DATABASE taller8_db;

USE taller8_db;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL
);

CREATE TABLE libros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    autor VARCHAR(100) NOT NULL,
    isbn VARCHAR(20) NOT NULL UNIQUE,
    anio_publicacion YEAR NOT NULL,
    cantidad INT NOT NULL DEFAULT 1
);

CREATE TABLE prestamos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    libro_id INT NOT NULL,
    fecha_prestamo DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_devolucion DATETIME DEFAULT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (libro_id) REFERENCES libros(id) ON DELETE CASCADE
);

## Registra los datos
lo puede de hacer de manera manual en las paginas o usar esto 
INSERT INTO usuarios (nombre, email) VALUES
('Ana García', 'ana@example.com'),
('Carlos Rodríguez', 'carlos@example.com'),
('Elena Martínez', 'elena@example.com'),
('David López', 'david@example.com');

INSERT INTO libros (titulo, autor, isbn, anio_publicacion, cantidad) VALUES
('Cien años de soledad', 'Gabriel García Márquez', '978-3-16-148410-0', 1967, 5),
('Don Quijote de la Mancha', 'Miguel de Cervantes', '978-0-14-243723-0', 1605, 3),
('Orgullo y prejuicio', 'Jane Austen', '978-0-19-953556-9', 1813, 4),
('El amor en los tiempos del cólera', 'Gabriel García Márquez', '978-0-06-088328-7', 1985, 2),
('1984', 'George Orwell', '978-0-452-28423-4', 1949, 6),
('La metamorfosis', 'Franz Kafka', '978-0-14-029600-2', 1915, 7),
('El gran Gatsby', 'F. Scott Fitzgerald', '978-0-7432-7356-5', 1925, 5),
('Moby Dick', 'Herman Melville', '978-0-14-243724-7', 1851, 3),
('Crimen y castigo', 'Fiódor Dostoyevski', '978-0-14-305814-4', 1866, 4),
('El principito', 'Antoine de Saint-Exupéry', '978-3-16-148410-0', 1943, 10);


## Descripción de Archivos
-config.php: Este archivo contiene las funciones necesarias para conectar a la base de datos. Es crucial para cualquier interacción con la base de datos, ya que se encarga de establecer la conexión.
-index.php: Aca se mostrara la parte visual. las entrada de los datos y los resultados.
-libros.php: Este archivo incluye las funciones que permiten gestionar los libros en el sistema. Esto abarca la registrar nuevos libros, la consulta de libros existentes y la eliminación de libros que ya no son necesarios.
-prestamos.php: En este archivo se manejan todas las operaciones relacionadas con los préstamos de libros. Permite registrar nuevos préstamos, listar los préstamos existentes y gestionar la devolución de libros.
-usuarios.php: Este archivo se encarga de las operaciones relacionadas con los usuarios del sistema. Permite registrar nuevos usuarios, listar los usuarios existentes y gestionar la información de los mismos.

## Comparacion con mi experiencia 
Al trabajar en este proyecto, noté que usar pdo fue una experiencia más fluida y cómoda en comparación con MySQLi. pdo tiene una sintaxis más clara y me permitió gestionar mejor las conexiones y los errores, gracias a su manejo de excepciones. Además, me gustó la flexibilidad que ofrece, ya que puedo usarlo con diferentes bases de datos si es necesario en el futuro. Aunque MySQLi también es funcional, sentí que su enfoque está más limitado a MySQL y su manejo de errores era mas complicado. 
En general, pdo me pareció más adecuado para proyectos en los que la seguridad y la flexibilidad son importantes.