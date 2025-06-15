<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM questions WHERE question_id = ?");
$stmt->execute([$id]);
$question = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $q = $_POST['question_text'];
    $a = $_POST['option_a'];
    $b = $_POST['option_b'];
    $c = $_POST['option_c'];
    $d = $_POST['option_d'];
    $correct = $_POST['correct_option'];

    $stmt = $pdo->prepare("UPDATE questions SET question_text=?, option_a=?, option_b=?, option_c=?, option_d=?, correct_option=? WHERE question_id=?");
    $stmt->execute([$q, $a, $b, $c, $d, $correct, $id]);
    header("Location: manage_questions.php?quiz_id=" . $question['quiz_id']);
    exit();
}
?>

<h2>Editar Pregunta</h2>
<form method="POST">
    <textarea name="question_text"><?= htmlspecialchars($question['question_text']) ?></textarea><br>
    <input type="text" name="option_a" value="<?= $question['option_a'] ?>" required><br>
    <input type="text" name="option_b" value="<?= $question['option_b'] ?>" required><br>
    <input type="text" name="option_c" value="<?= $question['option_c'] ?>" required><br>
    <input type="text" name="option_d" value="<?= $question['option_d'] ?>" required><br>
    <select name="correct_option" required>
        <option value="a" <?= $question['correct_option'] == 'a' ? 'selected' : '' ?>>A</option>
        <option value="b" <?= $question['correct_option'] == 'b' ? 'selected' : '' ?>>B</option>
        <option value="c" <?= $question['correct_option'] == 'c' ? 'selected' : '' ?>>C</option>
        <option value="d" <?= $question['correct_option'] == 'd' ? 'selected' : '' ?>>D</option>
    </select><br>
    <button type="submit">Guardar</button>
</form>
