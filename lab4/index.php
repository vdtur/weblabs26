<?php
declare(strict_types=1);

$studentName = 'Турбабин Вадим Дмитриевич';
$groupName = '241-353';
$labNumber = 'Лабораторная работа № А-4';

$pageTitle = $studentName . ' | ' . $groupName . ' | ' . $labNumber;

// Требуемое число колонок
$columnsCount = 4;

// Массив минимум из 10 разных элементов со структурами таблиц
$structures = array(
    'Январь*Февраль*Март#Апрель*Май*Июнь',
    'PHP*HTML*CSS*JS#MySQL*Git',
    'Кот*Собака#Попугай*Хомяк*Рыбка',
    'Красный*Синий*Зелёный#Жёлтый',
    'Apple*Banana*Orange#Grape*Kiwi#Peach',
    'Москва*СПб#Казань*Екатеринбург*Омск',
    'CPU*RAM*SSD#GPU',
    '1*2*3*4#5*6#7',
    'A*B*C#D#E*F*G*H',
    'Первая ячейка#Вторая строка*ячейка 2',
    // дополнительные спорные структуры для проверки условий
    '',
    '#',
    '*#**'
);

/**
 * Формирует HTML-код одной строки таблицы.
 * Если в строке нет ячеек — возвращает пустую строку.
 */
function getTR(string $data, int $columnsCount): string
{
    if ($columnsCount <= 0) {
        return '';
    }

    $cells = explode('*', $data);

    $hasNonEmptyCell = false;
    foreach ($cells as $cell) {
        if (trim($cell) !== '') {
            $hasNonEmptyCell = true;
            break;
        }
    }

    if (!$hasNonEmptyCell) {
        return '';
    }

    $result = '<tr>';

    for ($i = 0; $i < $columnsCount; $i++) {
        $value = $cells[$i] ?? '';
        $result .= '<td>' . htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8') . '</td>';
    }

    $result .= '</tr>';

    return $result;
}

/**
 * Выводит таблицу по строковой структуре.
 */
function outTable(string $structure, int $columnsCount): void
{
    if ($columnsCount <= 0) {
        echo '<p class="message error">Неправильное число колонок</p>';
        return;
    }

    $rows = explode('#', $structure);

    if (count($rows) === 0 || ($structure === '' && count($rows) === 1)) {
        echo '<p class="message warning">В таблице нет строк</p>';
        return;
    }

    $tableRowsHtml = '';

    foreach ($rows as $row) {
        $tableRowsHtml .= getTR($row, $columnsCount);
    }

    if ($tableRowsHtml === '') {
        echo '<p class="message warning">В таблице нет строк с ячейками</p>';
        return;
    }

    echo '<table class="data-table">';
    echo '<tbody>';
    echo $tableRowsHtml;
    echo '</tbody>';
    echo '</table>';
}
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
            <div class="header-text">
                <div><?php echo htmlspecialchars($studentName, ENT_QUOTES, 'UTF-8'); ?></div>
                <div><?php echo htmlspecialchars($groupName, ENT_QUOTES, 'UTF-8'); ?></div>
                <div><?php echo htmlspecialchars($labNumber, ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
        </div>
    </header>

    <main class="main-content">
        <section class="card">
            <h1>Вывод таблиц с использованием пользовательских функций</h1>

            <div class="intro">
                <p><strong>Число колонок:</strong> <?php echo $columnsCount; ?></p>
                <p><strong>Количество структур:</strong> <?php echo count($structures); ?></p>
            </div>

            <?php for ($i = 0; $i < count($structures); $i++): ?>
                <section class="table-section">
                    <h2><?php echo 'Таблица №' . ($i + 1); ?></h2>
                    <div class="structure-box">
                        <strong>Структура:</strong>
                        <code><?php echo htmlspecialchars($structures[$i], ENT_QUOTES, 'UTF-8'); ?></code>
                    </div>
                    <?php outTable($structures[$i], $columnsCount); ?>
                </section>
            <?php endfor; ?>
        </section>
    </main>

    <footer class="site-footer">
        <div>ЛР4: пользовательские функции и вывод таблиц</div>
    </footer>
</body>
</html>