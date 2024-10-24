<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] != 'user2') {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель управления пользователя 2</title>
</head>
<body>
    <h1>Добро пожаловать, пользователь 2!</h1>
    <a href="logout.php">Выйти</a>
</body>
</html>
