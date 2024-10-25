<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] != 'user2') {
    header('Location: index.php');
    exit();
}
function spline($x1, $y1, $x2, $y2, $x3, $y3) {
    $h1 = $x2 - $x1;
    $h2 = $x3 - $x2;

    $a1 = ($y2 - $y1) / $h1;
    $a2 = ($y3 - $y2) / $h2;

    $b1 = 3 * (($y2 - $y1) / ($h1 * $h1)) - 2 * (($y3 - $y1) / ($h1 * $h2)) + (($y3 - $y2) / ($h2 * $h2));
    $b2 = 3 * (($y3 - $y2) / ($h2 * $h2)) - 2 * (($y3 - $y1) / ($h1 * $h2)) + (($y2 - $y1) / ($h1 * $h1));

    $c1 = (($y3 - $y1) / ($h1 * $h2)) - (($y2 - $y1) / ($h1 * $h1)) - $b1 * $h1 / 3;
    $c2 = (($y2 - $y1) / ($h1 * $h2)) - (($y3 - $y2) / ($h2 * $h2)) - $b2 * $h2 / 3;

    $splinePoints = [];
    $x = $x1;
    while ($x <= $x3) {
        if ($x <= $x2) {
            $y = $y1 + $a1 * ($x - $x1) + $b1 * pow($x - $x1, 2) / 2 + $c1 * pow($x - $x1, 3) / 6;
        } else {
            $y = $y2 + $a2 * ($x - $x2) + $b2 * pow($x - $x2, 2) / 2 + $c2 * pow($x - $x2, 3) / 6;
        }
        $splinePoints[] = ['x' => $x, 'y' => $y];
        $x += 0.01; 
    }

    return array(
        'result' => 'ok',
        'splinePoints' => $splinePoints,
    );
}


function getResult($params) {
    $method = $params['method'];
    switch ($method) {
        case 'sum': 
            return sum($params['a'], $params['b'], $params['c']);
        case 'derivative': 
            return derivative($params['func'], $params['x'], $params['eps']);
        case 'spline':
            return spline($params['x1'], $params['y1'], $params['x2'], $params['y2'], $params['x3'], $params['y3']);
    }
    return array(
        'result' => 'error',
        'error' => 'im broken'
    );
}



if (isset($_GET['method']) && !empty($_GET['method'])) {
    $method = $_GET['method'];
    echo(json_encode(getResult($_GET)));
} else {
    echo json_encode(array(
        'result' => 'error',
        'error' => 'missing method'
    ));
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Сплайны</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <a href="logout.php">Выйти</a>

    <h2>Сплайны</h2>
    <input id="x1" placeholder="x1">
    <input id="y1" placeholder="y1"><br>

    <input id="x2" placeholder="x2">
    <input id="y2" placeholder="y2"><br>

    <input id="x3" placeholder="x3">
    <input id="y3" placeholder="y3"><br>

    <button id="butSpl">Результат</button><br>
    <canvas id="canvas" width="500" height="500"></canvas>
</body>
</html>
