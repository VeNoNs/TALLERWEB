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
                            <a class="nav-link" aria-current="page" href="inicioalumno.html">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cursosalumnos.html">Cursos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="notasalumnos.html">Notas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="reclamos.html">Reclamos</a>
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

    <div class="container table-container">
        <h2>HISTORIAL DE RECLAMOS</h2>
                <?php
                error_reporting(E_ALL);
                ini_set('display_errors', 1);

                $servername = "localhost";
                $username = "root";
                $password = "daniel10";
                $database = "colegio";

                $conn = new mysqli($servername, $username, $password, $database);


                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                $sql = "SELECT r.id_reclamo, d.nombres AS nombres_docente, d.apellido_paterno AS apellido_paterno_docente, d.apellido_materno AS apellido_materno_docente, c.nombre_curso, r.descripcion, r.fecha_reclamo, r.estado_reclamo
                        FROM Reclamos r
                        INNER JOIN Notas n ON r.id_nota = n.id_nota
                        INNER JOIN Inscripciones i ON n.id_inscripcion = i.id_inscripciones
                        INNER JOIN Cursos c ON i.id_curso = c.id_curso
                        INNER JOIN Docentes d ON c.id_docente = d.id_docente
                        WHERE i.id_estudiante = 1";

                $result = $conn->query($sql);


                if ($result === false) {
                    echo "Error en la consulta: " . $conn->error;
                } elseif ($result->num_rows > 0) {
                    
                    echo "<table class='table table-striped'>
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>DOCENTE</th>
                                    <th>CURSO</th>
                                    <th>ASUNTO</th>
                                    <th>FECHA</th>
                                    <th>ESTADO</th>
                                </tr>
                            </thead>
                            <tbody>";
                    
                    
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["id_reclamo"] . "</td>
                                <td>" . $row["nombres_docente"] . " " . $row["apellido_paterno_docente"] . " " . $row["apellido_materno_docente"] . "</td>
                                <td>" . $row["nombre_curso"] . "</td>
                                <td>" . $row["descripcion"] . "</td>
                                <td>" . $row["fecha_reclamo"] . "</td>
                                <td>" . $row["estado_reclamo"] . "</td>
                            </tr>";
                    }
                    
                    echo "</tbody></table>";
                } else {
                    echo "No hay reclamos para este estudiante";
                }


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
