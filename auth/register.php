<?php
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = ($_POST['role'] === 'instructor') ? 'instructor' : 'student';

    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$username, $password, $role]);

    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Quiz App</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Registro de Usuario</h1>

    <form method="post">
        <label>Usuario:</label>
        <input name="username" required><br>

        <label>Contraseña:</label>
        <input type="password" name="password" required><br>

        <label>Rol:</label>
        <select name="role" required>
            <option value="student">Estudiante</option>
            <option value="instructor">Instructor</option>
        </select><br><br>

        <button type="submit">Registrarse</button>
    </form>

    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
</body>
</html>
