<?php
declare(strict_types=1);

function h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function arg_is_not_Num(string $arg): bool
{
    $arg = trim($arg);

    if ($arg === '') {
        return true;
    }

    $normalized = str_replace(',', '.', $arg);

    return !is_numeric($normalized);
}

function normalize_number(string $arg): float
{
    return (float)str_replace(',', '.', trim($arg));
}

function renderArrayState(array $arr): string
{
    $html = '<div class="array-state">';
    foreach ($arr as $index => $value) {
        $html .= '<div class="arr-element"><span class="arr-key">' . $index . '</span><span class="arr-val">' . $value . '</span></div>';
    }
    $html .= '</div>';
    return $html;
}

function logIteration(array &$steps, int &$iteration, array $arr): void
{
    $iteration++;
    $steps[] = [
        'iteration' => $iteration,
        'state' => $arr
    ];
}

function sorting_by_choice(array $arr, array &$steps, int &$iteration): array
{
    $n = count($arr);

    for ($i = 0; $i < $n - 1; $i++) {
        $min = $i;

        for ($j = $i + 1; $j < $n; $j++) {
            if ($arr[$j] < $arr[$min]) {
                $min = $j;
            }
            logIteration($steps, $iteration, $arr);
        }

        if ($min !== $i) {
            $temp = $arr[$i];
            $arr[$i] = $arr[$min];
            $arr[$min] = $temp;
            logIteration($steps, $iteration, $arr);
        }
    }

    return $arr;
}

function bubble_sort(array $arr, array &$steps, int &$iteration): array
{
    $n = count($arr);

    for ($j = 0; $j < $n - 1; $j++) {
        for ($i = 0; $i < $n - 1 - $j; $i++) {
            if ($arr[$i] > $arr[$i + 1]) {
                $temp = $arr[$i];
                $arr[$i] = $arr[$i + 1];
                $arr[$i + 1] = $temp;
            }
            logIteration($steps, $iteration, $arr);
        }
    }

    return $arr;
}

function shell_sort(array $arr, array &$steps, int &$iteration): array
{
    $n = count($arr);

    for ($gap = (int)ceil($n / 2); $gap >= 1; $gap = (int)ceil($gap / 2)) {
        for ($i = $gap; $i < $n; $i++) {
            $val = $arr[$i];
            $j = $i - $gap;

            while ($j >= 0 && $arr[$j] > $val) {
                $arr[$j + $gap] = $arr[$j];
                $j -= $gap;
                logIteration($steps, $iteration, $arr);
            }

            $arr[$j + $gap] = $val;
            logIteration($steps, $iteration, $arr);
        }

        if ($gap === 1) {
            break;
        }
    }

    return $arr;
}

function gnome_sort(array $arr, array &$steps, int &$iteration): array
{
    $i = 1;
    $j = 2;
    $n = count($arr);

    while ($i < $n) {
        if ($i === 0 || $arr[$i - 1] <= $arr[$i]) {
            $i = $j;
            $j++;
        } else {
            $temp = $arr[$i];
            $arr[$i] = $arr[$i - 1];
            $arr[$i - 1] = $temp;
            $i--;
        }
        logIteration($steps, $iteration, $arr);
    }

    return $arr;
}

function quick_sort_recursive(array &$arr, int $left, int $right, array &$steps, int &$iteration): void
{
    $i = $left;
    $j = $right;
    $pivot = $arr[(int)(($left + $right) / 2)];

    while ($i <= $j) {
        while ($arr[$i] < $pivot) {
            $i++;
            logIteration($steps, $iteration, $arr);
        }

        while ($arr[$j] > $pivot) {
            $j--;
            logIteration($steps, $iteration, $arr);
        }

        if ($i <= $j) {
            $temp = $arr[$i];
            $arr[$i] = $arr[$j];
            $arr[$j] = $temp;
            $i++;
            $j--;
            logIteration($steps, $iteration, $arr);
        }
    }

    if ($left < $j) {
        quick_sort_recursive($arr, $left, $j, $steps, $iteration);
    }

    if ($i < $right) {
        quick_sort_recursive($arr, $i, $right, $steps, $iteration);
    }
}

function quick_sort(array $arr, array &$steps, int &$iteration): array
{
    if (count($arr) > 1) {
        quick_sort_recursive($arr, 0, count($arr) - 1, $steps, $iteration);
    }
    return $arr;
}

function native_sort_php(array $arr, array &$steps, int &$iteration): array
{
    sort($arr);
    logIteration($steps, $iteration, $arr);
    return $arr;
}

function getAlgorithmName(string $code): string
{
    return match ($code) {
        'choice' => 'Сортировка выбором',
        'bubble' => 'Пузырьковый алгоритм',
        'shell' => 'Алгоритм Шелла',
        'gnome' => 'Алгоритм садового гнома',
        'quick' => 'Быстрая сортировка',
        'native' => 'Встроенная функция PHP sort()',
        default => 'Неизвестный алгоритм',
    };
}

$algorithmCode = $_POST['algoritm'] ?? '';
$algorithmName = getAlgorithmName($algorithmCode);

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результат сортировки массива</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="page">
    <header class="page-header">
        <h1>Результат сортировки</h1>
        <p><?php echo h($algorithmName); ?></p>
    </header>

    <main class="card result-card">
<?php
if (!isset($_POST['element0'])) {
    echo '<p class="warning">Массив не задан, сортировка невозможна.</p>';
    echo '</main></div></body></html>';
    exit();
}

$arrLength = isset($_POST['arrLength']) ? (int)$_POST['arrLength'] : 0;

if ($arrLength <= 0) {
    echo '<p class="warning">Входных данных нет, сортировка невозможна.</p>';
    echo '</main></div></body></html>';
    exit();
}

$inputArray = [];

for ($i = 0; $i < $arrLength; $i++) {
    $key = 'element' . $i;
    $value = $_POST[$key] ?? '';

    if (arg_is_not_Num((string)$value)) {
        echo '<h2>Исходные данные</h2>';
        echo '<p class="warning">Элемент массива "' . h((string)$value) . '" не является числом. Сортировка не выполняется.</p>';
        echo '</main></div></body></html>';
        exit();
    }

    $inputArray[] = normalize_number((string)$value);
}

echo '<h2>Алгоритм</h2>';
echo '<p>' . h($algorithmName) . '</p>';

echo '<h2>Исходный массив</h2>';
echo renderArrayState($inputArray);

echo '<h2>Проверка валидности</h2>';
echo '<p class="success">Все элементы массива являются числами. Сортировка возможна.</p>';

$steps = [];
$iteration = 0;

$startTime = microtime(true);

$sortedArray = match ($algorithmCode) {
    'choice' => sorting_by_choice($inputArray, $steps, $iteration),
    'bubble' => bubble_sort($inputArray, $steps, $iteration),
    'shell'  => shell_sort($inputArray, $steps, $iteration),
    'gnome'  => gnome_sort($inputArray, $steps, $iteration),
    'quick'  => quick_sort($inputArray, $steps, $iteration),
    'native' => native_sort_php($inputArray, $steps, $iteration),
    default  => native_sort_php($inputArray, $steps, $iteration),
};

$endTime = microtime(true);
$elapsed = $endTime - $startTime;

echo '<h2>Процесс сортировки</h2>';

if (count($steps) === 0) {
    echo '<p>Массив уже отсортирован или не требует перестановок.</p>';
} else {
    foreach ($steps as $step) {
        echo '<div class="step-block">';
        echo '<div class="step-title">Итерация №' . $step['iteration'] . '</div>';
        echo renderArrayState($step['state']);
        echo '</div>';
    }
}

echo '<h2>Отсортированный массив</h2>';
echo renderArrayState($sortedArray);

echo '<div class="final-box">';
echo 'Сортировка завершена, проведено ' . $iteration . ' итераций. ';
echo 'Сортировка заняла ' . number_format($elapsed, 6, '.', '') . ' секунд.';
echo '</div>';
?>
    </main>
</div>
</body>
</html>