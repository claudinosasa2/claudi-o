<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Notas - ABM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<div class="container mt-4">
    <h1 class="mb-4">Notas de los Alumnos</h1>
    <a href="index.php" class="btn btn-outline-secondary mb-3">← Volver al Inicio</a>

    <?php
    $conn = new mysqli("localhost", "root", "", "escueladb");
    if ($conn->connect_error) {
        die('<div class="alert alert-danger">Error de conexión: ' . $conn->connect_error . '</div>');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_nota'])) {
        $alumno_id = $_POST['alumno_id'] ?? null;
        $materia = trim($_POST['materia'] ?? '');
        $nota = $_POST['nota'] ?? null;

        if ($alumno_id && $materia !== '' && is_numeric($nota)) {
            $stmt = $conn->prepare("INSERT INTO notas (fk_alumno, materia, nota) VALUES (?, ?, ?)");
            if ($stmt === false) {
                echo '<div class="alert alert-danger">Error en prepare(): ' . $conn->error . '</div>';
            } else {
                $stmt->bind_param("isd", $alumno_id, $materia, $nota);
                if ($stmt->execute()) {
                    echo '<div class="alert alert-success">Nota guardada correctamente.</div>';
                } else {
                    echo '<div class="alert alert-danger">Error al guardar nota: ' . $stmt->error . '</div>';
                }
                $stmt->close();
            }
        } else {
            echo '<div class="alert alert-warning">Complete todos los campos correctamente.</div>';
        }
    }

    // Obtener alumnos para el select
    $alumnos = $conn->query("SELECT pk_alumno, dni, curso FROM persona ORDER BY pk_alumno DESC");
    ?>

    <form method="POST" action="notas.php" class="mb-5">
        <div class="mb-3">
            <label for="alumno_id" class="form-label">Alumno</label>
            <select name="alumno_id" id="alumno_id" class="form-select" required>
                <option value="">Seleccione un alumno</option>
                <?php while ($row = $alumnos->fetch_assoc()) : ?>
                    <option value="<?= htmlspecialchars($row['pk_alumno']) ?>">
                        <?= htmlspecialchars($row['dni'] . ' - ' . $row['curso']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="materia" class="form-label">Materia</label>
            <input type="text" name="materia" id="materia" class="form-control" required />
        </div>

        <div class="mb-3">
            <label for="nota" class="form-label">Nota</label>
            <input type="number" step="0.01" name="nota" id="nota" class="form-control" required />
        </div>

        <button type="submit" name="guardar_nota" class="btn btn-success">Guardar Nota</button>
    </form>

    <?php
    // Mostrar todas las notas con info del alumno
    $sql_notas = "
        SELECT n.pk_nota, p.dni, p.curso, n.materia, n.nota
        FROM notas n
        INNER JOIN persona p ON n.fk_alumno = p.pk_alumno
        ORDER BY n.pk_nota DESC
    ";

    $result_notas = $conn->query($sql_notas);

    if ($result_notas && $result_notas->num_rows > 0) {
        echo '<table class="table table-striped table-bordered">';
        echo '<thead class="table-dark">';
        echo '<tr><th>ID Nota</th><th>DNI Alumno</th><th>Curso</th><th>Materia</th><th>Nota</th></tr>';
        echo '</thead><tbody>';

        while ($nota = $result_notas->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($nota['pk_nota']) . '</td>';
            echo '<td>' . htmlspecialchars($nota['dni']) . '</td>';
            echo '<td>' . htmlspecialchars($nota['curso']) . '</td>';
            echo '<td>' . htmlspecialchars($nota['materia']) . '</td>';
            echo '<td>' . htmlspecialchars($nota['nota']) . '</td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
    } else {
        echo '<div class="alert alert-info">No hay notas registradas.</div>';
    }

    $conn->close();
    ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
