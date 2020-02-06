<?php
//Подключение БД
require('../connect_bd.php');
//Проверка на наличие данных в методе POST
if (empty($_POST)) {
    //Подключение фона (background)
    include('../BG.php');
    //Начало работы с HTML формой
    echo '<form action="deletewriter.php" method="post" accept-charset="UTF-8"><p>';
    //Запись в переменную результат запроса БД
    $result = $dbc->query('SELECT name, id FROM authors');
    //Преобразование результата запроса в массив
    $result = $result->fetchAll();
    //Проверка массива на заполненость
    if (count($result) > 0) {
        echo '<select class="form-control" name="marka">' .
            '<option value="Выберите автора" selected="" disabled="">Выберите книгу</option>';
        for ($i = 0; $i < count($result); ++$i) {
            echo '<option value="' . $result[$i]['id']. '">'. $result[$i]['name'] . '</option>';
        }
        echo '</select></p>';
    } else {
        echo '<p>В настоящее время авторов нет.</p>';
    }
    //Кнопка "Удалить"
    echo '<p><input id="butt" type="submit" value="Удалить"></p>';
    //Кнопка "На главную"
    echo "<p><a href='../index.php'>На главную</a></p>";
    echo '</form>';

} else {
    //Отправка запроса БД
    $dbc->query('DELETE FROM authors WHERE id = ' . $_POST['marka'] . ';');
    //Переадресация на главную
    header('Location: ../index.php');
}
