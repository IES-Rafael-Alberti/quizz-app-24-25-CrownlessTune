<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'instructor') {
    header("Location: ../index.php");
    exit;
}

require '../config/db.php';

$quizId = $_GET['quiz_id'] ?? null;

if (!$quizId) {
    header("Location: ../index.php");
    exit;
}

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = trim($_POST['question']);
    $a = trim($_POST['a']);
    $b = trim($_POST['b']);
    $c = trim($_POST['c']);
    $d = trim($_POST['d']);
    $correct = $_POST['correct'];

    $stmt = $pdo->prepare("INSERT INTO questions (quiz_id, question_text, option_a, option_b, option_c, option_d, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$quizId, $question, $a, $b, $c, $d, $correct]);

    $mensaje = "✅ Pregunta añadida correctamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Preguntas - Quiz App</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h1>Añadir Preguntas</h1>

        <?php if ($mensaje): ?>
            <p class="success"><?= $mensaje ?></p>
        <?php endif; ?>

        <form method="post" class="form">
            <label for="question">Pregunta:</label>
            <input type="text" id="question" name="question" required>

            <label for="a">Opción A:</label>
            <input type="text" id="a" name="a" required>

            <label for="b">Opción B:</label>
            <input type="text" id="b" name="b" required>

            <label for="c">Opción C:</label>
            <input type="text" id="c" name="c" required>

            <label for="d">Opción D:</label>
            <input type="text" id="d" name="d" required>

            <label for="correct">Opción correcta:</label>
            <select id="correct" name="correct" required>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>

            <button type="submit">Guardar pregunta</button>
        </form>

        <p><a href="list.php">← Finalizar y ver cuestionarios</a></p>
        <p><a href="../index.php">← Volver al inicio</a></p>
    </div>
</body>
</html>
