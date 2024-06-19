<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "colegio";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM alumnos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .student-card {
            background-color: #ffc107;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            position: relative;
        }

        .student-img {
            width: 100px;
            height: 100px;
            background-color: #0000ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            position: absolute;
            right: -50px;
            top: 50%;
            transform: translateY(-50%);
            text-align: center;
        }

        .student-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .student-button {
            background-color: #8b4513;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .container {
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .footer {
            padding: 20px;
            background-color: #f8f9fa;
            text-align: center;
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
            height: 50px;
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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="inicio.html">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="alumnos.html">Alumnos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="notas.html">Notas</a>
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

    <div class="container">
        <div class="student-container">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="student-card col-md-5">';
                    echo '<h3>' . $row["nombre"] . '</h3>';
                    echo '<p>Curso: ' . $row["curso"] . '</p>';
                    echo '<button class="student-button" onclick="showModal(\'' . $row["nombre"] . '\', \'' . $row["curso"] . '\', \'' . addslashes($row["evaluaciones"]) . '\')">Ver Detalles</button>';
                    echo '<div class="student-img"><img src="' . $row["imagen"] . '" alt="Imagen de ' . $row["nombre"] . '"></div>';
                    echo '</div>';
                }
            } else {
                echo "No hay alumnos registrados.";
            }
            $conn->close();
            ?>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentModalLabel">Detalles del Alumno</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 id="studentName"></h4>
                    <p><strong>Curso:</strong> <span id="studentCourse"></span></p>
                    <p><strong>Evaluaciones:</strong></p>
                    <ul id="evaluationList"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Exportar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Tu Compañía. Todos los derechos reservados Grupo 4.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function showModal(name, course, evaluations) {
            document.getElementById('studentName').textContent = name;
            document.getElementById('studentCourse').textContent = course;

            const evaluationList = document.getElementById('evaluationList');
            evaluationList.innerHTML = '';

            const evals = evaluations.split(',');
            evals.forEach(evaluation => {
                const evaluationItem = document.createElement('li');
                evaluationItem.textContent = evaluation;
                evaluationList.appendChild(evaluationItem);
            });

            const studentModal = new bootstrap.Modal(document.getElementById('studentModal'));
            studentModal.show();
        }
    </script>
</body>

</html>
