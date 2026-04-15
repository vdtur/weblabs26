<?php

// строка
if (!isset($_GET['store'])) {
    $_GET['store'] = '';
}

// счётчик
if (!isset($_GET['count'])) {
    $_GET['count'] = 0;
}

// если нажали кнопку
if (isset($_GET['key'])) {
    if ($_GET['key'] == 'reset') {
        $_GET['store'] = ''; // очищаем строку
    } else {
        $_GET['store'] .= $_GET['key']; // добавляем цифру
    }

    $_GET['count']++; // УВЕЛИЧИВАЕМ СЧЁТЧИК ВСЕГДА
}

$result = $_GET['store'];
$clicks = $_GET['count'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>ЛР3</title>

<style>
body {
    font-family: Arial;
    text-align: center;
    background: #f0f0f0;
}

.result {
    width: 300px;
    height: 60px;
    margin: 20px auto;
    background: white;
    border: 2px solid #333;
    font-size: 24px;
    line-height: 60px;
}

.keyboard {
    width: 300px;
    margin: auto;
}

a {
    display: inline-block;
    width: 60px;
    height: 60px;
    margin: 5px;
    line-height: 60px;
    background: #4da6ff;
    color: white;
    text-decoration: none;
    font-size: 20px;
    border-radius: 8px;
}

a:hover {
    background: #3399ff;
}

.reset {
    width: 200px;
    background: red;
}
footer {
    margin-top: 20px;
}
</style>
</head>

<body>

<h1>Виртуальная клавиатура</h1>

<div class="result">
    <?php echo $result; ?>
</div>

<div class="keyboard">

<?php
// кнопки 1-9
for ($i = 1; $i <= 9; $i++) {
    echo '<a href="?key='.$i.'&store='.$result.'&count='.$clicks.'">'.$i.'</a>';
}

// кнопка 0
echo '<br><a href="?key=0&store='.$result.'&count='.$clicks.'">0</a>';
?>

<br>

<a class="reset" href="?key=reset&store=<?php echo $result; ?>&count=<?php echo $clicks; ?>">СБРОС</a>

</div>

<footer>
    Нажатий: <?php echo $clicks; ?>
</footer>

</body>
</html>