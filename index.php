<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

$username = htmlspecialchars($_SESSION['username']);
$role = $_SESSION['role'];
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Quiz App - Inicio</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Bienvenido, <?= $username ?></h1>

    <?php if ($role === 'instructor'): ?>
        <a href="quizzes/create.php">Crear cuestionario</a>
    <?php endif; ?>

    <a href="quizzes/list.php">Ver cuestionarios</a>
    <a href="results/view.php">Ver resultados</a>
    <a href="auth/logout.php">Cerrar sesión</a>
</body>
</html>