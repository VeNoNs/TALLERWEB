<?php
session_start(); 

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    echo "Usuario no autenticado.";
    exit; 
}

// Cierre de sesión
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

// Establecer la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "colegio";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del docente autenticado desde la sesión
$id_docente = $_SESSION['user_id'];

$sql = "SELECT nombres, apellido_paterno, apellido_materno FROM Docentes WHERE id_docente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_docente);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre = $row['nombres'];
    $apellidoPaterno = $row['apellido_paterno'];
    $apellidoMaterno = $row['apellido_materno'];
} else {
    $nombre = "Nombre del Docente";
    $apellidoPaterno = "";
    $apellidoMaterno = "";
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Docente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .cardVideo {
            background-color: #D0DCD3;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 500px;
        }

        .action-card {
            background-color: #ffc107;
            color: black;
            padding: 20px;
            height: 150px;
            width: 50%;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }


        .empty-space {
            height: 20px;
        }

        .footer {
            padding: 20px;
            background-color: #f8f9fa;
            text-align: center;
        }

        .icon-img {
            width: 200px;
            /* Ajusta según tus necesidades */
            height: 200px;
            background-color: #cccccc;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-img img {
            max-width: 100px;
            max-height: 100px;
        }

        .nav-link {
            padding: 0.5rem 1rem; 
            border-radius: 0.25rem; 
            width: 120px; 
            text-align: center; 
            white-space: nowrap; 
            overflow: hidden; 
            text-overflow: ellipsis; 
            color: #FFFFFF;
        }
        .nav-link.active {
            background-color: #ffc107;
            color: #000 !important;
        }
        .navbar-nav.ml-auto {
            margin-left: 0%;
        }
        .nav-link.border-white {
            border: 1px solid #FFFFFF;
        }
        .navbar-brand img {
            height: 50px; /* Ajusta el tamaño según tus necesidades */
            width: 120px;
        }
    </style>
</head>

<body>
<header>
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #003366;">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="../images/logo.png" alt="Logo"> 
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="iniciodocente.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cursos.html">Cursos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="reclamosdocente.php">Reclamos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="soportedocente.php">Soporte</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link border-white" href="iniciodocente.php?logout=true">Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-4">
        <div class="row mt-4 align-items-center">
            <!-- Columna para Cards de Acción y Saludo -->
            <div class="col-md-6">
                <h2>Bienvenido</h2>
                <h2><?php echo "$nombre $apellidoPaterno $apellidoMaterno"; ?></h2>
                <div class="d-flex flex-column align-items-start mb-2">
                    <a href="cursos.html" class="action-card">Cursos</a>
                </div>
                <div class="d-flex flex-column align-items-end mb-2">
                    <a href="reclamosdocente.php" class="action-card">Historial de Reclamos</a>
                </div>
                <div class="d-flex flex-column align-items-start">
                    <a href="soportedocente.php" class="action-card">Soporte</a>
                </div>
            </div>

            <!-- Columna para el Video -->
            <div class="col-md-6 d-flex justify-content-center align-items-center" style="min-height: 100%;">
                <div class="cardVideo" style="width: 100%; max-width: 500px;">
                    <video class="card-img-top" controls style="width: 100%; height: auto;">
                        <source src="../images/mainvideo.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 TallerWeb. Todos los derechos reservados Grupo 4.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
