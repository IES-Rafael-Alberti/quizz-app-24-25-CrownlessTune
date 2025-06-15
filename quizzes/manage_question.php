<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$quiz_id = $_GET['quiz_id'];
$stmt = $pdo->prepare("SELECT * FROM questions WHERE quiz_id = ?");
$stmt->execute([$quiz_id]);
$questions = $stmt->fetchAll();
?>

<h2>Preguntas del Cuestionario</h2>
<a href="add_question.php?quiz_id=<?= $quiz_id ?>">Añadir pregunta</a>
<table border="1">
    <tr><th>Pregunta</th><th>Acciones</th></tr>
    <?php foreach ($questions as $q): ?>
        <tr>
            <td><?= htmlspecialchars($q['question_text']) ?></td>
            <td>
                <a href="edit_question.php?id=<?= $q['question_id'] ?>">Editar</a> |
                <a href="delete_question.php?id=<?= $q['question_id'] ?>&quiz_id=<?= $quiz_id ?>" onclick="return confirm('¿Eliminar esta pregunta?')">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
