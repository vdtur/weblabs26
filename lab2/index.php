<?php
declare(strict_types=1);
date_default_timezone_set('Europe/Moscow');

/*
Вариант 10:
f(x) =
{
  3/x + x/3 - 5,                  при x <= 10
  (x - 7) * (x / 8),              при x > 10 и x < 20
  x * 3 + 2,                      при x >= 20
}
*/

$studentName = 'Турбабин Вадим Дмитриевич';
$groupName = '241-353';
$labNumber = 'Лабораторная работа № А-2';
$variantNumber = 'Вариант 10';

$pageTitle = $studentName . ' | ' . $groupName . ' | ' . $labNumber . ' | ' . $variantNumber;

// Явная инициализация переменных по условию
$startValue = -5.0;      // начальное значение аргумента
$stepsCount = 20;        // количество вычисляемых значений
$step = 1.5;             // шаг изменения аргумента
$minValue = -1000.0;     // минимальное значение функции, после которого остановка
$maxValue = 1000.0;      // максимальное значение функции, после которого остановка
$layoutType = 'D';       // A, B, C, D, E

$layoutNames = [
    'A' => 'Простая верстка текстом',
    'B' => 'Маркированный список',
    'C' => 'Нумерованный список',
    'D' => 'Табличная верстка',
    'E' => 'Блочная верстка',
];

function formatNumber(float $value): string
{
    return number_format(round($value, 3), 3, '.', '');
}

function calculateFunction(float $x): string|float
{
    // Вариант 10
    if ($x <= 10) {
        if ($x == 0.0) {
            return 'error';
        }
        return round(3 / $x + $x / 3 - 5, 3);
    }

    if ($x < 20) {
        return round(($x - 7) * ($x / 8), 3);
    }

    return round($x * 3 + 2, 3);
}

$rows = [];
$numericValues = [];

$x = $startValue;

// Цикл со счетчиком — основной для вывода страницы
for ($i = 0; $i < $stepsCount; $i++, $x += $step) {
    $f = calculateFunction($x);

    $rows[] = [
        'index' => $i + 1,
        'x' => round($x, 3),
        'f' => $f,
    ];

    if (is_float($f) || is_int($f)) {
        $numericValues[] = (float)$f;

        if ($f <= $minValue || $f >= $maxValue) {
            break;
        }
    }
}

$sum = 0.0;
$avg = 0.0;
$min = null;
$max = null;

if (count($numericValues) > 0) {
    $sum = array_sum($numericValues);
    $avg = $sum / count($numericValues);
    $min = min($numericValues);
    $max = max($numericValues);
}

// Дополнительно: показать остальные типы циклов для ЛР2
function buildRowsWhile(
    float $startValue,
    int $stepsCount,
    float $step,
    float $minValue,
    float $maxValue
): array {
    $rows = [];
    $x = $startValue;
    $i = 0;

    while ($i < $stepsCount) {
        $f = calculateFunction($x);

        $rows[] = [
            'index' => $i + 1,
            'x' => round($x, 3),
            'f' => $f,
        ];

        if ((is_float($f) || is_int($f)) && ($f <= $minValue || $f >= $maxValue)) {
            break;
        }

        $i++;
        $x += $step;
    }

    return $rows;
}

function buildRowsDoWhile(
    float $startValue,
    int $stepsCount,
    float $step,
    float $minValue,
    float $maxValue
): array {
    $rows = [];
    $x = $startValue;
    $i = 0;

    do {
        $f = calculateFunction($x);

        $rows[] = [
            'index' => $i + 1,
            'x' => round($x, 3),
            'f' => $f,
        ];

        if ((is_float($f) || is_int($f)) && ($f <= $minValue || $f >= $maxValue)) {
            break;
        }

        $i++;
        $x += $step;
    } while ($i < $stepsCount);

    return $rows;
}

// Вычисляем, чтобы на защите можно было показать, что все три цикла исследованы
$rowsWhile = buildRowsWhile($startValue, $stepsCount, $step, $minValue, $maxValue);
$rowsDoWhile = buildRowsDoWhile($startValue, $stepsCount, $step, $minValue, $maxValue);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <img class="logo" src="Logo.jpg" alt="Логотип университета">
            <div class="header-text">
                <div><?php echo htmlspecialchars($studentName, ENT_QUOTES, 'UTF-8'); ?></div>
                <div><?php echo htmlspecialchars($groupName, ENT_QUOTES, 'UTF-8'); ?></div>
                <div><?php echo htmlspecialchars($labNumber, ENT_QUOTES, 'UTF-8'); ?></div>
                <div><?php echo htmlspecialchars($variantNumber, ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
        </div>
    </header>

    <main class="main-content">
        <section class="card">
            <h1>Табулирование функции</h1>

            <div class="info-grid">
                <div><strong>Начальное значение x:</strong> <?php echo formatNumber($startValue); ?></div>
                <div><strong>Количество вычислений:</strong> <?php echo $stepsCount; ?></div>
                <div><strong>Шаг:</strong> <?php echo formatNumber($step); ?></div>
                <div><strong>Минимум остановки:</strong> <?php echo formatNumber($minValue); ?></div>
                <div><strong>Максимум остановки:</strong> <?php echo formatNumber($maxValue); ?></div>
                <div><strong>Тип верстки:</strong> <?php echo htmlspecialchars($layoutType, ENT_QUOTES, 'UTF-8'); ?></div>
            </div>

            <h2>Функция варианта 10</h2>
            <div class="formula-block">
                <div>f(x) =</div>
                <div>3 / x + x / 3 - 5, при x ≤ 10</div>
                <div>(x - 7) * (x / 8), при 10 &lt; x &lt; 20</div>
                <div>x * 3 + 2, при x ≥ 20</div>
            </div>

            <h2>Результаты вычислений</h2>

            <?php switch ($layoutType): case 'A': ?>
                <div class="result-block">
                    <?php foreach ($rows as $index => $row): ?>
                        <?php
                        $xText = formatNumber((float)$row['x']);
                        $fText = is_numeric($row['f']) ? formatNumber((float)$row['f']) : (string)$row['f'];
                        ?>
                        <?php if ($index > 0) { echo '<br>'; } ?>
                        <?php echo 'f(' . $xText . ')=' . $fText; ?>
                    <?php endforeach; ?>
                </div>

            <?php break; case 'B': ?>
                <ul class="result-list">
                    <?php foreach ($rows as $row): ?>
                        <?php
                        $xText = formatNumber((float)$row['x']);
                        $fText = is_numeric($row['f']) ? formatNumber((float)$row['f']) : (string)$row['f'];
                        ?>
                        <li><?php echo 'f(' . $xText . ')=' . $fText; ?></li>
                    <?php endforeach; ?>
                </ul>

            <?php break; case 'C': ?>
                <ol class="result-list">
                    <?php foreach ($rows as $row): ?>
                        <?php
                        $xText = formatNumber((float)$row['x']);
                        $fText = is_numeric($row['f']) ? formatNumber((float)$row['f']) : (string)$row['f'];
                        ?>
                        <li><?php echo 'f(' . $xText . ')=' . $fText; ?></li>
                    <?php endforeach; ?>
                </ol>

            <?php break; case 'D': ?>
                <table class="result-table">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>x</th>
                            <th>f(x)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td><?php echo (int)$row['index']; ?></td>
                                <td><?php echo formatNumber((float)$row['x']); ?></td>
                                <td>
                                    <?php
                                    echo is_numeric($row['f'])
                                        ? formatNumber((float)$row['f'])
                                        : htmlspecialchars((string)$row['f'], ENT_QUOTES, 'UTF-8');
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php break; case 'E': ?>
                <div class="blocks-wrapper">
                    <?php foreach ($rows as $row): ?>
                        <?php
                        $xText = formatNumber((float)$row['x']);
                        $fText = is_numeric($row['f']) ? formatNumber((float)$row['f']) : (string)$row['f'];
                        ?>
                        <div class="value-block"><?php echo 'f(' . $xText . ')=' . $fText; ?></div>
                    <?php endforeach; ?>
                </div>

            <?php break; default: ?>
                <p>Неизвестный тип верстки.</p>
            <?php endswitch; ?>

            <h2>Статистика</h2>
            <div class="stats-grid">
                <div><strong>Минимальное значение:</strong> <?php echo $min !== null ? formatNumber((float)$min) : 'нет данных'; ?></div>
                <div><strong>Максимальное значение:</strong> <?php echo $max !== null ? formatNumber((float)$max) : 'нет данных'; ?></div>
                <div><strong>Сумма значений:</strong> <?php echo count($numericValues) > 0 ? formatNumber($sum) : 'нет данных'; ?></div>
                <div><strong>Среднее арифметическое:</strong> <?php echo count($numericValues) > 0 ? formatNumber($avg) : 'нет данных'; ?></div>
            </div>

            <h2>Исследование циклов</h2>
            <div class="cycle-note">
                <p><strong>Цикл for:</strong> основной в этой работе, потому что заранее известно максимальное количество вычисляемых значений.</p>
                <p><strong>Цикл while:</strong> подходит, но требует ручной инициализации счётчика и увеличения значений.</p>
                <p><strong>Цикл do...while:</strong> гарантирует хотя бы одну итерацию, но для данной задачи менее удобен.</p>
                <p><strong>Оптимальный выбор:</strong> <code>for</code>.</p>
                <p><strong>Проверка:</strong> for = <?php echo count($rows); ?> строк, while = <?php echo count($rowsWhile); ?> строк, do...while = <?php echo count($rowsDoWhile); ?> строк.</p>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div>Тип верстки: <?php echo htmlspecialchars($layoutNames[$layoutType] ?? 'Неизвестно', ENT_QUOTES, 'UTF-8'); ?></div>
    </footer>
</body>
</html>