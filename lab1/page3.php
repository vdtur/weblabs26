<?php
$title = "Страница 3";
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

<?php $link="page2.php"; $name="Страница 2"; $current=false; ?>
<a href="<?php echo $link; ?>" class="<?php if($current) echo 'selected_menu'; ?>"><?php echo $name; ?></a>

<?php $link="page3.php"; $name="Страница 3"; $current=true; ?>
<a href="<?php echo $link; ?>" class="<?php if($current) echo 'selected_menu'; ?>"><?php echo $name; ?></a>
</header>

<div class="content">
<h1>Рейтинг и топы</h1>

<p>Существует множество рейтингов видеоигр, в которых оцениваются графика, сюжет, геймплей и популярность. В топ часто попадают проекты, которые оказали большое влияние на индустрию.
<br>Одной из таких игр является The Witcher 3:
Wild Hunt. Она получила множество наград и признание игроков по всему миру. <br>Также в список лучших игр часто включают
Red Dead Redemption 2, известную своей реалистичностью и атмосферой.
<br>Не стоит забывать и о многопользовательских играх, таких как Fortnite и Dota 2.
Они остаются популярными благодаря постоянным обновлениям и активному сообществу.

<table border="1">
<?php
echo "<tr><td>Игра</td><td>Тип</td><td>Особенность</td></tr>";
?>
<tr>
<td><?php echo "Red Dead Redemption 2"; ?></td>
<td><?php echo "Сюжетная"; ?></td>
<td><?php echo "Реалистичный открытый мир"; ?></td>
</tr>
<tr>
<td><?php echo "GTA V"; ?></td>
<td><?php echo "Сюжетная / Онлайн"; ?></td>
<td><?php echo "Большой город и свобода действий"; ?></td>
</tr>
<tr>
<td><?php echo "Counter-Strike 2"; ?></td>
<td><?php echo "Мультиплеер"; ?></td>
<td><?php echo "Соревновательный шутер"; ?></td>
</tr>
<tr>
<td><?php echo "Dota 2"; ?></td>
<td><?php echo "Мультиплеер"; ?></td>
<td><?php echo "Командная стратегия (MOBA)"; ?></td>
</tr>
<tr>
<td><?php echo "Fortnite"; ?></td>
<td><?php echo "Мультиплеер"; ?></td>
<td><?php echo "Battle Royale и строительство"; ?></td>
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