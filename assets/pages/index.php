<?php
session_start();

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "letterlove1000";
$dbname = "Colegio";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Manejar el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para verificar el usuario en Docentes
    $sql = "SELECT id_docente AS id, email, 'docente' AS role FROM Docentes WHERE email = ? AND contraseña = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Consulta para verificar el usuario en Alumnos
        $sql = "SELECT id_estudiante AS id, email, 'alumno' AS role FROM Alumnos WHERE email = ? AND dni = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
    }

    if ($result->num_rows > 0) {
        // Obtener datos del usuario
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];

        // Redirigir según el rol del usuario
        if ($user['role'] == 'alumno') {
            header("Location: inicioalumno.html");
        } else if ($user['role'] == 'docente') {
            header("Location: iniciodocente.html");
        }
        exit();
    } else {
        $error = "Email o contraseña incorrectos";
    }

    $stmt->close();
}

// Manejar el cierre de sesión
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: index.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"/>
    <link rel="stylesheet" href="../styles/home.css"/>
</head>
<body class="background">
<?php if (!isset($_SESSION['user_id'])): ?>
    <div class="login-form">
        <form action="index.php" method="post">
            <h4 class="text-center">Login</h4>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" required aria-required="true" aria-label="Email"/>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required aria-required="true" aria-label="Contraseña"/>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe" aria-label="Recordarme"/>
                    <label class="form-check-label" for="rememberMe">Recordarme</label>
                </div>
                <a href="#" class="align-self-center">¿Necesitas ayuda?</a>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-block custom-radius" aria-label="Iniciar Sesión">Iniciar Sesión</button>
            </div>
        </form>
    </div>
<?php else: ?>
    <?php if ($_SESSION['user_role'] == 'alumno' && $_GET['section'] == 'student'): ?>
        <h1>Bienvenido, Alumno</h1>
        <p>Información específica para alumnos</p>
    <?php elseif ($_SESSION['user_role'] == 'docente' && $_GET['section'] == 'teacher'): ?>
        <h1>Bienvenido, Docente</h1>
        <p>Información específica para docentes</p>
    <?php else: ?>
        <h1>Acceso Denegado</h1>
        <p>No tienes permiso para acceder a esta sección.</p>
    <?php endif; ?>
    <a href="index.php?action=logout">Cerrar sesión</a>
<?php endif; ?>
</body>
</html>