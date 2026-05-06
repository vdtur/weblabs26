<?php
declare(strict_types=1);
mb_internal_encoding('UTF-8');

function h(string|int|float $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function isLetter(string $char): bool
{
    return preg_match('/^\p{L}$/u', $char) === 1;
}

function isLowerLetter(string $char): bool
{
    return isLetter($char)
        && $char === mb_strtolower($char, 'UTF-8')
        && $char !== mb_strtoupper($char, 'UTF-8');
}

function isUpperLetter(string $char): bool
{
    return isLetter($char)
        && $char === mb_strtoupper($char, 'UTF-8')
        && $char !== mb_strtolower($char, 'UTF-8');
}

function isDigitChar(string $char): bool
{
    return preg_match('/^\p{N}$/u', $char) === 1;
}

function isPunctuationChar(string $char): bool
{
    return preg_match('/^\p{P}$/u', $char) === 1;
}

function getCharacterCounts(string $text): array
{
    $result = [];
    $length = mb_strlen($text, 'UTF-8');

    for ($i = 0; $i < $length; $i++) {
        $char = mb_substr($text, $i, 1, 'UTF-8');
        $charLower = mb_strtolower($char, 'UTF-8');

        if (isset($result[$charLower])) {
            $result[$charLower]++;
        } else {
            $result[$charLower] = 1;
        }
    }

    ksort($result, SORT_STRING);
    return $result;
}

function getWordCounts(string $text): array
{
    $words = [];

    preg_match_all('/[\p{L}\p{N}]+/u', mb_strtolower($text, 'UTF-8'), $matches);

    foreach ($matches[0] as $word) {
        if (isset($words[$word])) {
            $words[$word]++;
        } else {
            $words[$word] = 1;
        }
    }

    ksort($words, SORT_STRING);
    return $words;
}

function analyzeText(string $text): array
{
    $length = mb_strlen($text, 'UTF-8');

    $letters = 0;
    $lowerLetters = 0;
    $upperLetters = 0;
    $punctuation = 0;
    $digits = 0;

    for ($i = 0; $i < $length; $i++) {
        $char = mb_substr($text, $i, 1, 'UTF-8');

        if (isLetter($char)) {
            $letters++;
        }

        if (isLowerLetter($char)) {
            $lowerLetters++;
        }

        if (isUpperLetter($char)) {
            $upperLetters++;
        }

        if (isPunctuationChar($char)) {
            $punctuation++;
        }

        if (isDigitChar($char)) {
            $digits++;
        }
    }

    $wordCounts = getWordCounts($text);
    $characterCounts = getCharacterCounts($text);

    return [
        'characters' => $length,
        'letters' => $letters,
        'lower_letters' => $lowerLetters,
        'upper_letters' => $upperLetters,
        'punctuation' => $punctuation,
        'digits' => $digits,
        'words' => array_sum($wordCounts),
        'character_counts' => $characterCounts,
        'word_counts' => $wordCounts,
    ];
}

$text = $_POST['data'] ?? '';
$text = trim($text);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результат анализа текста</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="container">
        <section class="card">
            <h1>Результат анализа</h1>

            <?php if ($text === ''): ?>
                <div class="error">Нет текста для анализа</div>
            <?php else: ?>
                <?php $result = analyzeText($text); ?>

                <h2>Исходный текст</h2>
                <div class="source-text"><?php echo nl2br(h($text)); ?></div>

                <h2>Информация о тексте</h2>
                <table>
                    <tr>
                        <td>Количество символов, включая пробелы</td>
                        <td><?php echo $result['characters']; ?></td>
                    </tr>
                    <tr>
                        <td>Количество букв</td>
                        <td><?php echo $result['letters']; ?></td>
                    </tr>
                    <tr>
                        <td>Количество строчных букв</td>
                        <td><?php echo $result['lower_letters']; ?></td>
                    </tr>
                    <tr>
                        <td>Количество заглавных букв</td>
                        <td><?php echo $result['upper_letters']; ?></td>
                    </tr>
                    <tr>
                        <td>Количество знаков препинания</td>
                        <td><?php echo $result['punctuation']; ?></td>
                    </tr>
                    <tr>
                        <td>Количество цифр</td>
                        <td><?php echo $result['digits']; ?></td>
                    </tr>
                    <tr>
                        <td>Количество слов</td>
                        <td><?php echo $result['words']; ?></td>
                    </tr>
                </table>

                <h2>Вхождения символов</h2>
                <table>
                    <tr>
                        <th>Символ</th>
                        <th>Количество</th>
                    </tr>
                    <?php foreach ($result['character_counts'] as $char => $count): ?>
                        <tr>
                            <td>
                                <?php
                                if ($char === ' ') {
                                    echo '[пробел]';
                                } elseif ($char === "\n") {
                                    echo '[перенос строки]';
                                } elseif ($char === "\r") {
                                    echo '[возврат каретки]';
                                } elseif ($char === "\t") {
                                    echo '[табуляция]';
                                } else {
                                    echo h($char);
                                }
                                ?>
                            </td>
                            <td><?php echo $count; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

                <h2>Список слов</h2>
                <table>
                    <tr>
                        <th>Слово</th>
                        <th>Количество вхождений</th>
                    </tr>
                    <?php foreach ($result['word_counts'] as $word => $count): ?>
                        <tr>
                            <td><?php echo h($word); ?></td>
                            <td><?php echo $count; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>

            <a href="index.html" class="button-link">Другой анализ</a>
        </section>
    </main>
</body>
</html>