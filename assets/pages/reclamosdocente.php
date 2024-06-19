
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reclamos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            margin-top: 40px;
            margin-bottom: 40px;
        }
        .table-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .footer {
            padding: 20px;
            background-color: #f8f9fa;
            text-align: center;
        }
        .icon-img {
            width: 200px;
            height: 200px;
            background-color: #FFFFFF;
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
        table thead th {
            background-color: #ffc107;
            color: #000;
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
                            <a class="nav-link" aria-current="page" href="iniciodocente.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cursos.html">Cursos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="reclamosdocente.php">Reclamos</a>
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

    <div class="container table-container">
        <h2>HISTORIAL DE RECLAMOS</h2>
        
        <?php
        session_start(); // Iniciar o reanudar la sesión
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

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

        // Consulta SQL para obtener los reclamos del docente logueado
        $id_docente = $_SESSION['user_id'];
        $sql = "SELECT rd.id_reclamo, c.nombre_curso, rd.descripcion, rd.fecha_reclamo, rd.estado_reclamo
                FROM reclamos_docente rd
                INNER JOIN cursos c ON rd.id_curso = c.id_curso
                WHERE rd.id_docente = $id_docente";

        $result = $conn->query($sql);

        if ($result === false) {
            echo "Error en la consulta: " . $conn->error;
        } elseif ($result->num_rows > 0) {
            // Mostrar los resultados en una tabla
            echo "<table class='table table-striped'>
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>CURSO</th>
                            <th>ASUNTO</th>
                            <th>FECHA</th>
                            <th>ESTADO</th>
                        </tr>
                    </thead>
                    <tbody>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['id_reclamo'] . "</td>
                        <td>" . $row['nombre_curso'] . "</td>
                        <td>" . $row['descripcion'] . "</td>
                        <td>" . $row['fecha_reclamo'] . "</td>
                        <td>" . $row['estado_reclamo'] . "</td>
                      </tr>";
            }
            
            echo "</tbody></table>";
        } else {
            echo "No hay reclamos para mostrar.";
        }

        // Cerrar conexión
        $conn->close();
        ?>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 TallerWeb. Todos los derechos reservados Grupo 4.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
