<?php
$title = "Страница 2";
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
<?php $link="page1.php"; $name="Главная"; $current=false; ?>
<a href="<?php echo $link; ?>" class="<?php if($current) echo 'selected_menu'; ?>"><?php echo $name; ?></a>

<?php $link="page2.php"; $name="Страница 2"; $current=true; ?>
<a href="<?php echo $link; ?>" class="<?php if($current) echo 'selected_menu'; ?>"><?php echo $name; ?></a>

<?php $link="page3.php"; $name="Страница 3"; $current=false; ?>
<a href="<?php echo $link; ?>" class="<?php if($current) echo 'selected_menu'; ?>"><?php echo $name; ?></a>
</header>

<div class="content">
<h1>Собственное мнение</h1>

<p>Среди огромного количества видеоигр каждый игрок выбирает для себя любимые проекты. Лично мне нравятся игры с открытым миром и интересным сюжетом. Такие игры позволяют исследовать большие локации, выполнять задания и погружаться в атмосферу.<br>
Одной из самых популярных игр является Grand Theft Auto V. В ней игрок может свободно перемещаться по городу, выполнять миссии и взаимодействовать с окружающим миром.<br> Также популярностью пользуются игры серии The Witcher, которые известны своим глубоким сюжетом и проработанными персонажами.
<br> Многие игроки также любят соревновательные игры, такие как Counter-Strike 2.
В них важна реакция, командная работа и стратегия. Такие игры особенно популярны в киберспорте.

<table border="1">
<?php
echo "<tr><td>Игра</td><td>Жанр</td><td>Год выпуска</td></tr>";
?>
<tr>
<td><?php echo "GTA V"; ?></td>
<td><?php echo "Открытый мир"; ?></td>
<td><?php echo "2013"; ?></td>
</tr>
<tr>
<td><?php echo "The Witcher 3"; ?></td>
<td><?php echo "RPG"; ?></td>
<td><?php echo "2015"; ?></td>
</tr>
<tr>
<td><?php echo "Counter-Strike 2"; ?></td>
<td><?php echo "Шутер"; ?></td>
<td><?php echo "2023"; ?></td>
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
echo "Сформировано " . date("d.m.Y H:i:s"); ?>
</footer>

</body>
</html>