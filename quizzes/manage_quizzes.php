<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$stmt = $pdo->query("SELECT * FROM quizzes");
$quizzes = $stmt->fetchAll();
?>

<h2>Administrar Cuestionarios</h2>
<a href="create_quiz.php">Crear nuevo</a>
<table border="1">
    <tr><th>Título</th><th>Descripción</th><th>Acciones</th></tr>
    <?php foreach ($quizzes as $quiz): ?>
        <tr>
            <td><?= htmlspecialchars($quiz['title']) ?></td>
            <td><?= htmlspecialchars($quiz['description']) ?></td>
            <td>
                <a href="edit_quiz.php?id=<?= $quiz['quiz_id'] ?>">Editar</a> |
                <a href="delete_quiz.php?id=<?= $quiz['quiz_id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este cuestionario?')">Eliminar</a> |
                <a href="manage_questions.php?quiz_id=<?= $quiz['quiz_id'] ?>">Preguntas</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
