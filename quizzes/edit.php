<?php
require_once '../config/db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'instructor') {
    header('Location: ../auth/login.php');
    exit();
}

if (!isset($_GET['quiz_id'])) {
    header('Location: list.php');
    exit();
}

$id = $_GET['quiz_id'];

$stmt = $pdo->prepare("SELECT * FROM quizzes WHERE quiz_id = ?");
$stmt->execute([$id]);
$quiz = $stmt->fetch();

if (!$quiz) {
    echo "Cuestionario no encontrado.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("UPDATE quizzes SET title = ?, description = ? WHERE quiz_id = ?");
    $stmt->execute([$title, $description, $id]);

    header("Location: list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Editar Cuestionario</title>
    <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
    <div class="container">
        <h2>Editar Cuestionario</h2>
        <form method="POST" class="form">
            <label for="title">Título:</label><br>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($quiz['title']) ?>" required><br><br>

            <label for="description">Descripción:</label><br>
            <textarea id="description" name="description" rows="4"><?= htmlspecialchars($quiz['description']) ?></textarea><br><br>

            <button type="submit" class="btn">Guardar</button>
        </form>

        <p>
          <a href="add_questions.php?quiz_id=<?= $id ?>" class="btn-secondary">Editar preguntas</a>
        </p>

        <p><a href="list.php">← Volver a la lista de cuestionarios</a></p>
    </div>
</body>
</html>
