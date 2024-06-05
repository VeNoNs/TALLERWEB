<?php
$servername = "localhost";
$username = "root";
$password = "daniel10";
$database = "Colegio";

// Crear una conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


$id_alumno = 1;

// Consulta SQL para obtener las calificaciones del alumno
$sql = "SELECT materia, primer_bimestre, segundo_bimestre, tercer_bimestre, cuarto_bimestre, promedio_final FROM calificaciones WHERE id_alumno = $id_alumno";

$result = $conn->query($sql);


if ($result->num_rows > 0) {
    
    $calificaciones = array();

    
    while ($row = $result->fetch_assoc()) {
        
        $calificaciones[] = $row;
    }
} else {
    echo "No se encontraron calificaciones para el alumno con ID: $id_alumno";
}

// Cerrar la conexión
$conn->close();
?>