<?php
$result = null;
$out_text = '';

if (isset($_POST['A'])) {

    $A = str_replace(',', '.', $_POST['A']);
    $B = str_replace(',', '.', $_POST['B']);
    $C = str_replace(',', '.', $_POST['C']);

    $A = floatval($A);
    $B = floatval($B);
    $C = floatval($C);

    $task = $_POST['TASK'];

    // вычисление
    if ($task == 'mean') {
        $result = round(($A + $B + $C) / 3, 2);
        $task_name = 'Среднее арифметическое';
    } elseif ($task == 'perimeter') {
        $result = $A + $B + $C;
        $task_name = 'Периметр треугольника';
    } elseif ($task == 'volume') {
        $result = $A * $B * $C;
        $task_name = 'Объём параллелепипеда';
    } elseif ($task == 'sum') {
        $result = $A + $B + $C;
        $task_name = 'Сумма чисел';
    } elseif ($task == 'max') {
        $result = max($A, $B, $C);
        $task_name = 'Максимум';
    } else {
        $result = min($A, $B, $C);
        $task_name = 'Минимум';
    }

    $user_result = $_POST['RESULT'];

    // формируем отчет
    $out_text .= 'ФИО: ' . $_POST['FIO'] . '<br>';
    $out_text .= 'Группа: ' . $_POST['GROUP'] . '<br><br>';

    if ($_POST['ABOUT']) {
        $out_text .= $_POST['ABOUT'] . '<br><br>';
    }

    $out_text .= 'Задача: ' . $task_name . '<br>';
    $out_text .= "A=$A, B=$B, C=$C<br>";

    if ($user_result === '') {
        $out_text .= 'Задача самостоятельно решена не была<br>';
    } else {
        $out_text .= 'Ваш ответ: ' . $user_result . '<br>';
    }

    $out_text .= 'Правильный ответ: ' . $result . '<br>';

    if ($user_result == $result) {
        $out_text .= '<b>Тест пройден</b><br>';
    } else {
        $out_text .= '<b>Ошибка: тест не пройден</b><br>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ЛР6</title>

<style>
body { font-family: Arial; background:#eef2f7; padding:20px; }
.form-box, .result-box {
    background:white;
    padding:20px;
    border-radius:12px;
    max-width:600px;
    margin:auto;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}
input, select, textarea {
    width:100%;
    margin-bottom:10px;
    padding:8px;
}
button {
    padding:10px;
    background:#1f4e79;
    color:white;
    border:none;
}
.hidden { display:none; }
a.button {
    display:inline-block;
    margin-top:15px;
    padding:10px;
    background:#1f4e79;
    color:white;
    text-decoration:none;
}
</style>

<script>
function toggleEmail() {
    let el = document.getElementById('mailBlock');
    el.style.display = document.getElementById('sendMail').checked ? 'block' : 'none';
}
</script>

</head>

<body>

<?php if ($result !== null): ?>

<div class="result-box">
<?php echo $out_text; ?>

<?php if (isset($_POST['send_mail'])): ?>
    <br>Результаты отправлены на <?php echo $_POST['MAIL']; ?>
<?php endif; ?>

<br><a class="button" href="index.php">Повторить тест</a>

</div>

<?php else: ?>

<div class="form-box">

<form method="post">

<input name="FIO" placeholder="ФИО" required>
<input name="GROUP" placeholder="Группа" required>

<input name="A" value="<?php echo mt_rand(1,100); ?>">
<input name="B" value="<?php echo mt_rand(1,100); ?>">
<input name="C" value="<?php echo mt_rand(1,100); ?>">

<select name="TASK">
<option value="mean">Среднее арифметическое</option>
<option value="perimeter">Периметр</option>
<option value="volume">Объем</option>
<option value="sum">Сумма</option>
<option value="max">Максимум</option>
<option value="min">Минимум</option>
</select>

<input name="RESULT" placeholder="Ваш ответ">

<textarea name="ABOUT" placeholder="Немного о себе"></textarea>

<label>
<input type="checkbox" id="sendMail" name="send_mail" onclick="toggleEmail()">
Отправить на email
</label>

<div id="mailBlock" class="hidden">
<input name="MAIL" placeholder="Email">
</div>

<select name="VIEW">
<option>Версия для браузера</option>
<option>Версия для печати</option>
</select>

<button>Проверить</button>

</form>

</div>

<?php endif; ?>

</body>
</html>