<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'instructor') {
    header("Location: ../index.php");
    exit;
}

require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    $stmt = $pdo->prepare("INSERT INTO quizzes (title, description) VALUES (?, ?)");
    $stmt->execute([$title, $description]);

    $quizId = $pdo->lastInsertId();
    header("Location: add_questions.php?quiz_id=$quizId");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Cuestionario - Quiz App</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Crear nuevo cuestionario</h1>

        <form method="post" class="form">
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Descripción:</label>
            <textarea id="description" name="description" required></textarea>

            <button type="submit">Crear</button>
        </form>

        <p><a href="../index.php">← Volver al inicio</a></p>
    </div>
</body>
</html>
