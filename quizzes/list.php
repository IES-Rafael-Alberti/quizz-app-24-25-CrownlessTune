<?php
session_start();
require '../config/db.php';

$stmt = $pdo->query("SELECT * FROM quizzes");
$quizzes = $stmt->fetchAll();

$isInstructor = isset($_SESSION['user_id']) && $_SESSION['role'] === 'instructor';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cuestionarios - Quiz App</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Cuestionarios disponibles</h1>

        <?php if (count($quizzes) === 0): ?>
            <p>No hay cuestionarios disponibles.</p>
        <?php else: ?>
            <ul class="quiz-list">
                <?php foreach ($quizzes as $quiz): ?>
                    <li class="quiz-item">
                        <h3><?= htmlspecialchars($quiz['title']) ?></h3>
                        <p><?= htmlspecialchars($quiz['description']) ?></p>
                        <a class="btn" href="take.php?quiz_id=<?= $quiz['quiz_id'] ?>">Hacer cuestionario</a>

                        <?php if ($isInstructor): ?>
                            <a class="btn secondary" href="edit.php?quiz_id=<?= $quiz['quiz_id'] ?>">Editar</a>
                            <a class="btn danger" href="delete.php?quiz_id=<?= $quiz['quiz_id'] ?>" onclick="return confirm('¿Estás seguro de que quieres borrar este cuestionario?');">Borrar</a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <p><a href="../index.php">← Volver al inicio</a></p>
    </div>
</body>
</html>
