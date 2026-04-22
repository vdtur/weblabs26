<?php
declare(strict_types=1);
date_default_timezone_set('Europe/Moscow');

$studentName = 'Турбабин Вадим Дмириевич';
$groupName = '241-353';
$labNumber = 'Лабораторная работа № А-5';

$pageTitle = $studentName . ' | ' . $groupName . ' | ' . $labNumber;

// Параметры
$htmlType = $_GET['html_type'] ?? 'TABLE'; // по умолчанию табличная верстка
$content = $_GET['content'] ?? null;       // по умолчанию вся таблица

if ($htmlType !== 'TABLE' && $htmlType !== 'DIV') {
    $htmlType = 'TABLE';
}

if ($content !== null) {
    $content = (int)$content;
    if ($content < 2 || $content > 9) {
        $content = null;
    }
}

function h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function getMainMenuLink(string $type, ?int $content): string
{
    $link = '?html_type=' . $type;
    if ($content !== null) {
        $link .= '&content=' . $content;
    }
    return $link;
}

function getSideMenuLink(?int $number, string $htmlType): string
{
    $link = '?';
    $parts = [];

    if ($htmlType === 'DIV') {
        $parts[] = 'html_type=DIV';
    } elseif (isset($_GET['html_type']) && $_GET['html_type'] === 'TABLE') {
        $parts[] = 'html_type=TABLE';
    }

    if ($number !== null) {
        $parts[] = 'content=' . $number;
    }

    if (count($parts) === 0) {
        return 'index.php';
    }

    return '?' . implode('&', $parts);
}

// Возвращает число как ссылку, если это возможно.
// Ссылка всегда сбрасывает тип верстки: html_type НЕ передается.
function outNumAsLink(int $x): string
{
    if ($x >= 2 && $x <= 9) {
        return '<a class="inline-number-link" href="?content=' . $x . '">' . $x . '</a>';
    }
    return (string)$x;
}

// Возвращает одну строку столбца таблицы умножения
function getRowLine(int $n, int $i): string
{
    return outNumAsLink($n) . ' × ' . outNumAsLink($i) . ' = ' . outNumAsLink($n * $i);
}

// Выводит один столбец таблицы умножения в табличной форме
function outTableColumn(int $n): void
{
    echo '<table class="mult-table">';
    echo '<tbody>';
    for ($i = 2; $i <= 9; $i++) {
        echo '<tr>';
        echo '<td>' . getRowLine($n, $i) . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}

// Выводит всю таблицу умножения или один столбец в табличной форме
function outTableForm(?int $content): void
{
    if ($content === null) {
        echo '<div class="table-grid">';
        for ($n = 2; $n <= 9; $n++) {
            echo '<div class="table-card">';
            echo '<h3>На ' . $n . '</h3>';
            outTableColumn($n);
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<div class="single-table-card">';
        echo '<h3>Таблица умножения на ' . $content . '</h3>';
        outTableColumn($content);
        echo '</div>';
    }
}

// Выводит один столбец таблицы умножения в блочной форме
function outDivColumn(int $n, bool $single = false): void
{
    $className = $single ? 'div-column-single' : 'div-column';

    echo '<div class="' . $className . '">';
    echo '<h3>На ' . $n . '</h3>';

    for ($i = 2; $i <= 9; $i++) {
        echo '<div class="div-line">' . getRowLine($n, $i) . '</div>';
    }

    echo '</div>';
}

// Выводит всю таблицу умножения или один столбец в блочной форме
function outDivForm(?int $content): void
{
    if ($content === null) {
        echo '<div class="div-grid">';
        for ($n = 2; $n <= 9; $n++) {
            outDivColumn($n, false);
        }
        echo '</div>';
    } else {
        echo '<div class="div-single-wrapper">';
        outDivColumn($content, true);
        echo '</div>';
    }
}

// Информация для подвала
if ($htmlType === 'TABLE') {
    $layoutTitle = 'Табличная вёрстка';
} else {
    $layoutTitle = 'Блочная вёрстка';
}

if ($content === null) {
    $contentTitle = 'Полная таблица умножения';
} else {
    $contentTitle = 'Таблица умножения на ' . $content;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo h($pageTitle); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <div class="title-block">
                <div class="site-title"><?php echo h($labNumber); ?></div>
                <div class="site-subtitle"><?php echo h($studentName . ' | ' . $groupName); ?></div>
            </div>

            <nav class="top-menu">
                <a
                    href="<?php echo h(getMainMenuLink('TABLE', $content)); ?>"
                    <?php
                    if (isset($_GET['html_type']) && $_GET['html_type'] === 'TABLE') {
                        echo 'class="selected"';
                    }
                    ?>
                >Табличная вёрстка</a>

                <a
                    href="<?php echo h(getMainMenuLink('DIV', $content)); ?>"
                    <?php
                    if (isset($_GET['html_type']) && $_GET['html_type'] === 'DIV') {
                        echo 'class="selected"';
                    }
                    ?>
                >Блочная вёрстка</a>
            </nav>
        </div>
    </header>

    <div class="page-layout">
        <aside class="side-menu">
            <h2>Содержание</h2>

            <a
                href="<?php echo h(getSideMenuLink(null, $htmlType)); ?>"
                <?php
                if (!isset($_GET['content'])) {
                    echo 'class="selected"';
                }
                ?>
            >Всё</a>

            <?php for ($i = 2; $i <= 9; $i++): ?>
                <a
                    href="<?php echo h(getSideMenuLink($i, $htmlType)); ?>"
                    <?php
                    if (isset($_GET['content']) && (int)$_GET['content'] === $i) {
                        echo 'class="selected"';
                    }
                    ?>
                ><?php echo 'Таблица умножения на ' . $i; ?></a>
            <?php endfor; ?>
        </aside>

        <main class="content-area">
            <section class="content-card">
                <h1><?php echo h($contentTitle); ?></h1>

                <?php
                if ($htmlType === 'TABLE') {
                    outTableForm($content);
                } else {
                    outDivForm($content);
                }
                ?>
            </section>
        </main>
    </div>

    <footer class="site-footer">
        <div><?php echo h($layoutTitle); ?></div>
        <div><?php echo h($contentTitle); ?></div>
        <div><?php echo date('d.m.Y H:i:s'); ?></div>
    </footer>
</body>
</html>