<?php
$title = "Главная страница";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $title; ?></title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<header>
<?php
$link = "page1.php";
$name = "Главная";
$current = true;
?>
<a href="<?php echo $link; ?>" class="<?php if($current) echo 'selected_menu'; ?>">
<?php echo $name; ?>
</a>

<?php
$link = "page2.php";
$name = "Страница 2";
$current = false;
?>
<a href="<?php echo $link; ?>" class="<?php if($current) echo 'selected_menu'; ?>">
<?php echo $name; ?>
</a>

<?php
$link = "page3.php";
$name = "Страница 3";
$current = false;
?>
<a href="<?php echo $link; ?>" class="<?php if($current) echo 'selected_menu'; ?>">
<?php echo $name; ?>
</a>
</header>

<div class="content">

<h1>Видеоигры</h1>
<h2>    </h2>

<p>Видеоигры — это одна из самых популярных форм развлечений в современном мире. Они представляют собой интерактивные программы, в которых игрок управляет персонажем или системой и взаимодействует с виртуальной средой.<br>
Игры могут быть как простыми, так и очень сложными, с продуманным сюжетом, графикой и механикой.
Современные видеоигры развиваются стремительными темпами.<br> Благодаря технологиям, таким как 3D-графика, искусственный интеллект и онлайн-сервисы, игроки могут погружаться в реалистичные миры и взаимодействовать с другими людьми по всему миру. Игры стали не только развлечением, но и частью культуры.
<br>Существует множество жанров видеоигр: шутеры, стратегии, ролевые игры, симуляторы и другие. Каждый жанр предлагает уникальный игровой опыт. Некоторые игры развивают реакцию и координацию, другие
— стратегическое мышление и внимание.

<table border="1">
<?php
echo "<tr><td>Жанр</td><td>Описание</td><td>Пример игры</td></tr>";
?>
<tr>
<td><?php echo "Шутер"; ?></td>
<td><?php echo "Игры со стрельбой и быстрой реакцией"; ?></td>
<td><?php echo "Counter-Strike 2"; ?></td>
</tr>
<tr>
<td><?php echo "Ролевая игра (RPG)"; ?></td>
<td><?php echo "Игры с развитием персонажа и сюжетом"; ?></td>
<td><?php echo "The Witcher 3"; ?></td>
</tr>
<tr>
<td><?php echo "Открытый мир"; ?></td>
<td><?php echo "Свободное исследование игрового мира"; ?></td>
<td><?php echo "GTA V"; ?></td>
</tr>
</table>

<br>

<?php
echo '<img src="photos/photo'.(date('s')%2+1).'.jpg" width="200">';
?>

</div>

<footer>
<?php 
date_default_timezone_set('Europe/Moscow');
echo "Сформировано " . date("d.m.Y H:i:s") . "          ";
echo "Турбабин В.Д. ст.уч.гр. 241-353, ЛР-1"?>
</footer>

</body>
</html>