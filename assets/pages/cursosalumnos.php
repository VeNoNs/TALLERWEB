<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .course-card {
            background-color: #ffc107;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            position: relative;
        }

        .docente-img {
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

        .course-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .course-button {
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
                            <a class="nav-link" aria-current="page" href="inicioalumno.html">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="cursosalumnos.html">Cursos</a>
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

    <div class="container">
        <div class="course-container">
            <?php
            // Establecer la conexión a la base de datos
            $servername = "localhost";
            $username = "root"; 
            $password = "daniel10"; 
            $database = "Colegio";


            $conn = new mysqli($servername, $username, $password, $database);

 
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Consulta SQL para obtener los cursos del alumno con ID 1
            $student_id = 1;
            $sql = "SELECT Cursos.nombre_curso, Docentes.nombres AS nombre_docente 
                    FROM Inscripciones 
                    INNER JOIN Cursos ON Inscripciones.id_curso = Cursos.id_curso 
                    LEFT JOIN Docentes ON Cursos.id_docente = Docentes.id_docente 
                    WHERE Inscripciones.id_estudiante = $student_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                
                while ($row = $result->fetch_assoc()) {
                    $nombre_curso = $row['nombre_curso'];
                    $nombre_docente = $row['nombre_docente'];
                    ?>
                    <div class="course-card col-md-5">
                        <h3><?php echo $nombre_curso; ?></h3>
                        <p>Docente: <?php echo $nombre_docente; ?></p>
                        <button class="course-button"
                            onclick="showModal('<?php echo $nombre_curso; ?>', '<?php echo $nombre_docente; ?>')">Revisar
                            Curso</button>
                        <div class="docente-img">Imagen docente</div>
                    </div>
                <?php
                }
            } else {
                
                echo "<p>No se encontraron cursos para este alumno.</p>";
            }

            
            $conn->close();
            ?>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="courseModalLabel">Detalles del Curso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 id="courseName"></h4>
                    <p id="courseTeacher"></p>
                    <div class="row">
                        <div class="col-8">
                            <p><strong>Evaluaciones</strong></p>
                        </div>
                        <div class="col-2">
                            <p><strong>Nota</strong></p>
                        </div>
                        <div class="col-2">
                            <p><strong>Acciones</strong></p>
                        </div>
                    </div>
                    <div id="evaluationsContainer">
                        <!-- Evaluations will be inserted here dynamically -->
                    </div>
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
            function showModal(courseName, courseTeacher) {
                document.getElementById('courseName').textContent = courseName;
                document.getElementById('courseTeacher').textContent = `Docente: ${courseTeacher}`;

                // Sample data for evaluations
                const evaluations = [
                    { name: 'Evaluación 1', grade: '85' },
                    { name: 'Evaluación 2', grade: '90' },
                    { name: 'Evaluación 3', grade: '78' },
                    { name: 'Nota Final', grade: '50' },
                ];

                const evaluationsContainer = document.getElementById('evaluationsContainer');
                evaluationsContainer.innerHTML = '';

                evaluations.forEach(evaluation => {
                    const evaluationRow = document.createElement('div');
                    evaluationRow.classList.add('row', 'mb-2');

                    const evalName = document.createElement('div');
                    evalName.classList.add('col-8');
                    evalName.textContent = evaluation.name;

                    const evalGrade = document.createElement('div');
                    evalGrade.classList.add('col-2');
                    evalGrade.textContent = evaluation.grade;

                    const evalAction = document.createElement('div');
                    evalAction.classList.add('col-2');
                    const claimButton = document.createElement('button');
                    claimButton.classList.add('btn', 'btn-warning', 'btn-sm');
                    claimButton.textContent = 'Reclamar';
                    claimButton.onclick = function () {
                        window.location.href = 'soporte.html';
                    };
                    evalAction.appendChild(claimButton);

                    evaluationRow.appendChild(evalName);
                    evaluationRow.appendChild(evalGrade);
                    evaluationRow.appendChild(evalAction);

                    evaluationsContainer.appendChild(evaluationRow);
                });

                const courseModal = new bootstrap.Modal(document.getElementById('courseModal'));
                courseModal.show();
            }
        </script>
    </body>
</body>

</html>
