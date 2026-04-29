<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лабораторная работа № А-7</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function setHTML(element, txt) {
            if ('innerHTML' in element) {
                element.innerHTML = txt;
            } else {
                var range = document.createRange();
                range.selectNodeContents(element);
                range.deleteContents();
                var fragment = range.createContextualFragment(txt);
                element.appendChild(fragment);
            }
        }

        function addElement() {
            var table = document.getElementById('elements');
            var index = table.rows.length;

            var row = table.insertRow(index);

            var cellIndex = row.insertCell(0);
            cellIndex.className = 'index_cell';
            setHTML(cellIndex, index + ':');

            var cellInput = row.insertCell(1);
            cellInput.className = 'input_cell';
            setHTML(cellInput, '<input type="text" name="element' + index + '" class="array-input">');

            document.getElementById('arrLength').value = table.rows.length;
        }
    </script>
</head>
<body>
    <div class="page">
        <header class="page-header">
            <h1>Лабораторная работа № А-7</h1>
            <p>Ввод данных и сортировка массивов</p>
        </header>

        <main class="card">
            <form action="sort.php" method="post" target="_blank" class="array-form">
                <div class="form-row">
                    <label for="algoritm">Алгоритм сортировки</label>
                    <select name="algoritm" id="algoritm" class="full-control">
                        <option value="choice">Сортировка выбором</option>
                        <option value="bubble">Пузырьковый алгоритм</option>
                        <option value="shell">Алгоритм Шелла</option>
                        <option value="gnome">Алгоритм садового гнома</option>
                        <option value="quick">Быстрая сортировка</option>
                        <option value="native">Встроенная функция PHP</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>Элементы массива</label>
                    <table id="elements" class="elements-table">
                        <tr>
                            <td class="index_cell">0:</td>
                            <td class="input_cell">
                                <input type="text" name="element0" class="array-input">
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="arrLength" id="arrLength" value="1">
                </div>

                <div class="button-row">
                    <input type="button" value="Добавить еще один элемент" onclick="addElement()" class="btn secondary-btn">
                    <input type="submit" value="Сортировать массив" class="btn primary-btn">
                </div>
            </form>
        </main>
    </div>
</body>
</html>