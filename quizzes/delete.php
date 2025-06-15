<?php
require_once '../config/db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'instructor') {
    header('Location: ../auth/login.php');
    exit();
}

if (!isset($_GET['quiz_id'])) {
    header('Location: list.php');
    exit();
}

$id = $_GET['quiz_id'];

$stmt = $pdo->prepare("DELETE FROM quizzes WHERE quiz_id = ?");
$stmt->execute([$id]);

header("Location: list.php");
exit();
