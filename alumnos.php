<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Alumnos - ABM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<div class="container mt-4">
    <h1 class="mb-4">Lista de Alumnos</h1>
    <a href="index.php" class="btn btn-outline-secondary mb-3">← Volver al Inicio</a>

    <?php
    $conn = new mysqli("localhost", "root", "", "escueladb");
    if ($conn->connect_error) {
        die('<div class="alert alert-danger">Error de conexión: ' . $conn->connect_error . '</div>');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insertar'])) {
        $dni = trim($_POST['dni']);
        $legajo = trim($_POST['legajo']);
        $curso = trim($_POST['curso']);

        if (empty($dni) || empty($legajo) || empty($curso)) {
            echo '<div class="alert alert-danger">Por favor, ingresa todos los valores.</div>';
        } elseif (!is_numeric($dni) || !is_numeric($legajo)) {
            echo '<div class="alert alert-warning">DNI y Legajo deben ser números.</div>';
        } else {
            $sql_insert = "INSERT INTO persona (dni, n_legajo, curso) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql_insert);
            if ($stmt === false) {
                echo '<div class="alert alert-danger">Error en prepare(): ' . $conn->error . '</div>';
            } else {
                $stmt->bind_param("sss", $dni, $legajo, $curso);
                if ($stmt->execute()) {
                    echo '<div class="alert alert-success">Datos insertados correctamente.</div>';
                } else {
                    echo '<div class="alert alert-danger">Error al insertar los datos: ' . $stmt->error . '</div>';
                }
                $stmt->close();
            }
        }
    }

    $sql = "SELECT pk_alumno, n_legajo, dni, curso FROM persona ORDER BY pk_alumno DESC";
    $resultado = $conn->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        echo '<table class="table table-striped table-bordered mt-4">';
        echo '<thead class="table-dark">';
        echo '<tr><th>ID</th><th>Legajo</th><th>DNI</th><th>Curso</th></tr>';
        echo '</thead><tbody>';
        while ($fila = $resultado->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($fila["pk_alumno"]) . '</td>';
            echo '<td>' . htmlspecialchars($fila["n_legajo"]) . '</td>';
            echo '<td>' . htmlspecialchars($fila["dni"]) . '</td>';
            echo '<td>' . htmlspecialchars($fila["curso"]) . '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    } else {
        echo '<div class="alert alert-info">No se encontraron alumnos registrados.</div>';
    }

    $conn->close();
    ?>

    <hr class="mt-5" />

    <div class="mt-4">
        <h2>Ingresar Nuevo Alumno</h2>
        <form action="alumnos.php" method="POST">
            <div class="mb-3">
                <label for="dni" class="form-label">DNI</label>
                <input type="text" class="form-control" id="dni" name="dni" placeholder="Ingrese el DNI" required />
            </div>

            <div class="mb-3">
                <label for="legajo" class="form-label">Legajo</label>
                <input type="text" class="form-control" id="legajo" name="legajo" placeholder="Ingrese el Legajo" required />
            </div>

            <div class="mb-3">
                <label for="curso" class="form-label">Curso</label>
                <input type="text" class="form-control" id="curso" name="curso" placeholder="Ingrese el Curso" required />
            </div>

            <button type="submit" name="insertar" class="btn btn-primary">Insertar Datos</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
