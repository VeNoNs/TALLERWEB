<?php

$servername = "localhost"; 
$username = "root";
$password = "daniel10";
$dbname = "Colegio";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT r.id_reclamo, CONCAT(a.nombre, ' ', a.apellido_paterno, ' ', a.apellido_materno) AS alumno, 
               c.nombre_curso, r.descripcion, r.fecha_reclamo, r.estado_reclamo
        FROM Reclamos r
        JOIN Alumnos a ON r.id_alumno = a.id_estudiante
        JOIN Notas n ON r.id_nota = n.id_nota
        JOIN Inscripciones i ON n.id_inscripcion = i.id_inscripciones
        JOIN Cursos c ON i.id_curso = c.id_curso";

$result = $conn->query($sql);


$reclamos = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $reclamos[] = $row;
    }
}

// Cerrar la conexión
$conn->close();
?>