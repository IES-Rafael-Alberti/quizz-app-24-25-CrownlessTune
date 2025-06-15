<?php
session_start();
require '../config/db.php';

$stmt = $pdo->prepare("SELECT quizzes.title, results.score, results.total_questions, results.created_at 
                       FROM results JOIN quizzes ON results.quiz_id = quizzes.quiz_id
                       WHERE results.user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$results = $stmt->fetchAll();
?>

<h2>Resultados</h2>
<ul>
<?php foreach ($results as $r): ?>
    <li>
        <?= htmlspecialchars($r['title']) ?>:
        <?= $r['score'] ?>/<?= $r['total_questions'] ?> 
        (<?= $r['created_at'] ?>)
    </li>
<?php endforeach; ?>
</ul>
<a href="../index.php">Volver</a>
