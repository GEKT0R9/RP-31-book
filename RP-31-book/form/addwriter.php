<?php
//Подключение БД
require('../connect_bd.php');
//Подключение фона(background)
include('../BG.php');
//Начало работы с HTML формой
echo '<form action="../process/process_addwriter.php" method="post" accept-charset="UTF-8"><p>';

//Запись в переменную результат запроса БД
$result = $dbc->query('SELECT title, id FROM books;');
//Преобразование результата запроса в массив
$result = $result->fetchAll();
//Проверка массива на заполненость
if (count($result) > 0) {
    echo '<select class="form-control" name="book">' .
        '<option value="Выберите книгу" selected="" disabled="">Выберите книгу</option>';
    for ($i = 0; $i < count($result); ++$i) {
        echo '<option value="' . $result[$i]['id'] . '">' . $result[$i]['title'] . '</option>';
    }
    echo '</select></p>';
} else {
    echo '<p>В настоящее время книг нет.</p>';
}

//Запись в переменную результат запроса БД
$result = $dbc->query('SELECT name, id FROM authors;');
//Преобразование результата запроса в массив
$result = $result->fetchAll();
//Проверка массива на заполненость
if (count($result) > 0) {
    echo '<select class="form-control" name="writer">' .
        '<option value="none" selected="" >Автор не из списка</option>';
    for ($i = 0; $i < count($result); ++$i) {
        echo '<option value="' . $result[$i]['id'] . '">' . $result[$i]['name'] . '</option>';
    }
    echo '</select></p>';
}

//Поле ввода автора
echo '<input name="name_a" placeholder="Имя автора">';
//Кнопка "Добавить"
echo '<p><input id="butt" type="submit" value="Добавить"></p>';
//Кнопка "На главную"
echo "<p><a href='../index.php'>На главную</a></p>";
echo '</form>';

