<?php
session_start();
require '../config/db.php';

$quizId = $_GET['quiz_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM questions WHERE quiz_id = ?");
    $stmt->execute([$quizId]);
    $questions = $stmt->fetchAll();

    $score = 0;
    foreach ($questions as $q) {
        $qid = $q['question_id'];
        if (isset($_POST["q$qid"]) && $_POST["q$qid"] === $q['correct_option']) {
            $score++;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO results (user_id, quiz_id, score, total_questions) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $quizId, $score, count($questions)]);

    echo "<h2>Has terminado el cuestionario</h2>";
    echo "<p>Puntuación: $score / " . count($questions) . "</p>";
    echo "<a href='list.php' class='btn'>Volver</a>";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM questions WHERE quiz_id = ?");
$stmt->execute([$quizId]);
$questions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Realizar Cuestionario</title>
    <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>
    <div class="container">
        <h2>Realizar cuestionario</h2>
        <form method="post">
            <?php foreach ($questions as $q): ?>
                <p class="question"><?= htmlspecialchars($q['question_text']) ?></p>
                <label><input type="radio" name="q<?= $q['question_id'] ?>" value="A" required> <?= htmlspecialchars($q['option_a']) ?></label><br>
                <label><input type="radio" name="q<?= $q['question_id'] ?>" value="B"> <?= htmlspecialchars($q['option_b']) ?></label><br>
                <label><input type="radio" name="q<?= $q['question_id'] ?>" value="C"> <?= htmlspecialchars($q['option_c']) ?></label><br>
                <label><input type="radio" name="q<?= $q['question_id'] ?>" value="D"> <?= htmlspecialchars($q['option_d']) ?></label><br>
            <?php endforeach; ?>
            <button type="submit" class="btn">Enviar</button>
        </form>
    </div>
</body>
</html>
