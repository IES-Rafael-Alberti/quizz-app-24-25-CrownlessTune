<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: ../index.php");
        exit;
    } else {
        $error = "Credenciales incorrectas";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Quiz App</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Iniciar Sesión</h1>

    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="post">
        <label>Usuario:</label>
        <input name="username" required><br>
        <label>Contraseña:</label>
        <input type="password" name="password" required><br><br>
        <button type="submit">Entrar</button>
    </form>

    <p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
</body>
</html>
