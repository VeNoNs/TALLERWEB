<?php
session_start(); 

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    echo "Usuario no autenticado.";
    exit; 
}

// Conectar a la base de datos 
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

// Consultar los cursos asignados al docente actual
$sql = "SELECT id_curso, nombre_curso FROM Cursos WHERE id_docente = ?";
$stmt = $conn->prepare($sql);

// Verificar si la preparación fue exitosa
if ($stmt === false) {
    echo "Error en la preparación de la consulta: " . $conn->error;
} else {
    // Vincular parámetro y ejecutar la consulta
    $stmt->bind_param("i", $id_docente);
    $stmt->execute();

    // Obtener resultados de la consulta
    $result = $stmt->get_result();

    // Crear un array para almacenar los cursos
    $cursos = [];
    while ($row = $result->fetch_assoc()) {
        $cursos[] = $row;
    }

    // Cerrar la declaración
    $stmt->close();
}

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id_curso = $_POST['curso'];
    $tema = $_POST['tema'];
    $descripcion = $_POST['descripcion'];
    $solicitar_llamada = isset($_POST['llamada']) ? 1 : 0; // 1 si está marcado, 0 si no

    // Establecer la fecha actual
    $fecha_reclamo = date('Y-m-d');
    $estado_reclamo = "Pendiente"; // Estado inicial del reclamo

    // Preparar la consulta SQL para insertar el reclamo en la base de datos
    $sql = "INSERT INTO reclamos_docente (id_curso, id_docente, descripcion, fecha_reclamo, estado_reclamo) VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "Error en la preparación de la consulta: " . $conn->error;
    } else {
        // Vincular parámetros y ejecutar la consulta
        $stmt->bind_param("iisss", $id_curso, $id_docente, $descripcion, $fecha_reclamo, $estado_reclamo);

        if ($stmt->execute()) {
           
        } else {
           $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    }

    // Cerrar la conexión
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soporte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .question-container {
            text-align: left;
            padding: 5px;
            width: 100%;
        }

        .btn-yellow-no-border {
            background-color: #ffdd57;
            border: none;
            padding: 10px 20px;
            color: black;
            cursor: pointer;
            border-radius: 10px;
        }

        .button-container {
            text-align: center;
            padding: 10px;
            width: 100%;
        }

        .btn-no-background {
            background-color: transparent;
            border: none;
            color: #2c37d6
        }

        #user-input {
            width: 100%;
            height: 10%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            resize: none;
            background-color: #ffdd57;
        }

        .custom-select {
            width: 100%;
            background-color: #ffdd57;
            border: none;
            padding: 2px;
            font-weight: 400;
            line-height: 1.5;
            color: #000000;
            text-align: center;
            border-radius: 5px;
        }

        .action-card {
            background-color: #ffdd57;
            color: black;
            padding: 10px;
            min-height: 20px;
            /* Altura mínima para evitar que se reduzca demasiado */
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 10px;
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
                            <a class="nav-link" aria-current="page" href="iniciodocente.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cursos.html">Cursos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="reclamosdocente.php">Reclamos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="soportedocente.php">Soporte</a>
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
            <!-- Columna para solicitud -->
            <div class="col-md-6">
                <h2>¿Con qué necesitas ayuda?</h2>
                <form action="soportedocente.php" method="POST">
                    <div class="d-flex flex-column align-items-start mb-2">
                        <div class="action-card">
                            <p><b>Seleccionar Curso</b></p>
                            <select class="custom-select" name="curso" aria-label="Selecciona una opción">
                                <?php foreach ($cursos as $curso): ?>
                                    <option value="<?= $curso['id_curso'] ?>"><?= $curso['nombre_curso'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <h2>¿Con qué área tiene problemas?</h2>
                    <div class="d-flex flex-column align-items-start">
                        <div class="action-card">
                            <textarea id="user-input" name="tema" rows="1" placeholder="Tema" width=200% height=100px></textarea>
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-start">
                        <div class="action-card">
                            <textarea id="user-input" name="descripcion" rows="4"
                                placeholder="Describe tu problema con el mayor detalle posible. Por favor provee cualquier dirección de correo electrónico específica."
                                width=200% height=100px></textarea>
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-start">
                        <button class="btn-no-background" type="button">Adjuntar archivos (opcional)</button>
                    </div>
                    <div>
                        <input type="checkbox" name="llamada"> ¿Solicitar una llamada de regreso?
                    </div>
                    <div class="button-container">
                        <button class="btn-yellow-no-border" type="submit">Crear un ticket</button>
                    </div>
                </form>
            </div>

            <!-- Columna para preguntas frecuentes -->
            <div class="col-md-6">
                <h2>Preguntas frecuentes</h2>
                <details class="question-container">
                    <summary class="btn-no-background">¿Por qué no puedo ingresar a mi cuenta?</summary>
                    <p>Puede haber varias razones por las cuales no puedes acceder a tu cuenta, como un error de nombre
                        de usuario o contraseña, problemas técnicos en el sistema de inicio de sesión, o incluso una
                        cuenta bloqueada. Te recomendamos verificar la información de inicio de sesión y, si persisten
                        los problemas, contactar al soporte técnico para obtener ayuda adicional.</p>
                </details>
                <details class="question-container">
                    <summary class="btn-no-background">¿Cómo puedo comunicarme con un tutor?</summary>
                    <p>Para comunicarte con un tutor, generalmente puedes utilizar las plataformas de comunicación
                        proporcionadas por tu institución educativa, como correo electrónico. También puedes consultar
                        directamente con la institución para obtener información específica sobre cómo contactar a los
                        tutores.</p>
                </details>
                <details class="question-container">
                    <summary class="btn-no-background">¿Qué pasa si no pago la pensión?</summary>
                    <p>El pago de la pensión es importante para mantener tu situación académica y tener acceso a los
                        servicios y recursos de la institución educativa. Si no pagas la pensión, es posible que se te
                        niegue el acceso a clases, exámenes o actividades académicas, y eventualmente podrías enfrentar
                        medidas adicionales, como la suspensión de matrícula. Te recomendamos comunicarte con los
                        departamentos financieros o administrativos de tu institución para conocer las políticas
                        específicas relacionadas con el pago de la pensión.</p>
                </details>
                <details class="question-container">
                    <summary class="btn-no-background">¿Por qué no puedo visualizar mis notas?</summary>
                    <p>La indisponibilidad para visualizar tus notas puede deberse a problemas técnicos en el sistema de
                        gestión de calificaciones o a que las notas aún no han sido publicadas por tus profesores. Te
                        sugerimos esperar un tiempo y verificar nuevamente más tarde. Si el problema persiste, puedes
                        contactar al departamento académico correspondiente para obtener asistencia.</p>
                </details>
                <details class="question-container">
                    <summary class="btn-no-background">¿Cuándo suben notas los docentes?</summary>
                    <p>La publicación de notas por parte de los docentes puede variar según el cronograma académico de
                        cada curso. Algunos profesores pueden publicar las notas al finalizar cada evaluación o módulo,
                        mientras que otros pueden hacerlo al finalizar el período académico. Te recomendamos consultar
                        con tus profesores o revisar el calendario académico de tu asignatura para conocer las fechas
                        específicas de publicación de notas.</p>
                </details>
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
