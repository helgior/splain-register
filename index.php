<?php
session_start();

if (isset($_SESSION['user'])) {
    if ($_SESSION['user'] == 'user1') {
        header('Location: dashboard.php');
        exit();
    } elseif ($_SESSION['user'] == 'user2') {
        header('Location: dashboard2.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    
    if ($username == 'user1') {
        $_SESSION['user'] = 'user1';
        header('Location: dashboard.php');
        exit();
    } elseif ($username == 'user2') {
        $_SESSION['user'] = 'user2';
        header('Location: dashboard2.php');
        exit();
    } else {
        $error = "Неверное имя пользователя.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Вход</h1>
    <form method="POST">
        <input type="text" name="username" placeholder="Введите имя пользователя" required>
        <button type="submit">Войти</button>
    </form>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
