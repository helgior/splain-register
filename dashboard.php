<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] != 'user1') {
    header('Location: index.php');
    exit();
}

// Функция для расчета производной
function calculate_derivative($function, $point, $epsilon) {
    // Создаем анонимную функцию для вычисления значения функции
    $f = function($x) use ($function) {
        return eval('return ' . str_replace('x', $x, $function) . ';');
    };
    
    // Вычисляем производную с использованием конечных разностей
    $derivative = ($f($point + $epsilon) - $f($point - $epsilon)) / (2 * $epsilon);
    
    return $derivative;
}

$result = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $function = $_POST['function'];
    $point = floatval($_POST['point']);
    $epsilon = floatval($_POST['epsilon']);
    
    // Проверка на корректность введенной функции
    if (!empty($function) && is_numeric($point) && is_numeric($epsilon) && $epsilon > 0) {
        $result = calculate_derivative($function, $point, $epsilon);
    } else {
        $error = "Пожалуйста, введите корректные значения.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель управления пользователя 1</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <h1>Вычисление производной в точке</h1>
    <a href="logout.php">Выйти</a>

    <h2>Расчет производной функции</h2>
    <form method="POST">
        <label for="function">Функция (например, x*x для x^2):</label><br>
        <input type="text" name="function" placeholder="x*x" required><br>
        
        <label for="point">Точка (например, 2):</label><br>
        <input type="number" name="point" step="any" placeholder="2" required><br>
        
        <label for="epsilon">Эпсилон (например, 0.01):</label><br>
        <input type="number" name="epsilon" step="any" placeholder="0.01" required><br>
        
        <button type="submit">Вычислить производную</button>
    </form>

    <?php if (isset($result)) echo "<p>Значение производной: $result</p>"; ?>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
