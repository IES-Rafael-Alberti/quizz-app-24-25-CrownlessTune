<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'];
$quiz_id = $_GET['quiz_id'];

$stmt = $pdo->prepare("DELETE FROM questions WHERE question_id = ?");
$stmt->execute([$id]);
header("Location: manage_questions.php?quiz_id=$quiz_id");
exit();
