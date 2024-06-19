<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
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
                            <a class="nav-link active" aria-current="page" href="inicioalumno.html">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cursosalumnos.html">Cursos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="notasalumnos.html">Notas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="reclamos.html">Reclamos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="soporte.html">Soporte</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link border-white" href="#">Cerrar Sesión</a>
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
                <?php
                // Establecer la conexión a la base de datos
                $servername = "localhost";
                $username = "root";
                $password = "daniel10";
                $database = "colegio";

                // Crear conexión
                $conn = new mysqli($servername, $username, $password, $database);

                // Verificar la conexión
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                // Consulta SQL para obtener el nombre y apellido del alumno con ID 1
                $sql = "SELECT nombre, apellido_paterno FROM Alumnos WHERE id_estudiante = 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Obtener los datos del alumno
                    $row = $result->fetch_assoc();
                    $nombre = $row['nombre'];
                    $apellido = $row['apellido_paterno'];

                    // Mostrar el nombre y apellido del alumno
                    echo "<h2>$nombre $apellido</h2>";
                } else {
                    // Si no se encuentra el alumno con ID 1, puedes manejarlo como prefieras
                    echo "<h2>Nombre del Alumno</h2>";
                }

                // Cerrar la conexión
                $conn->close();
                ?>
                <div class="d-flex flex-column align-items-start mb-2">
                    <a href="cursosalumnos.html" class="action-card">Cursos</a>
                </div>
                <div class="d-flex flex-column align-items-end mb-2">
                    <a href="reclamos.php" class="action-card">Historial de Reclamos</a>
                </div>
                <div class="d-flex flex-column align-items-start">
                    <a href="soporte.html" class="action-card">Soporte</a>
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