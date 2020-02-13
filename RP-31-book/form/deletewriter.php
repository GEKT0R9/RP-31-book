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
    $result = $dbc->query('SELECT books.title, authors.name, books.id as idB, authors.id as idA FROM books,authors,books_authors WHERE books_authors.id_books = books.id AND books_authors.id_author = authors.id');
    //Преобразование результата запроса в массив
    $result = $result->fetchAll();
    //Проверка массива на заполненость
    //Создание списка авторов на форме
    if (count($result) > 0) {
        echo '<select class="form-control" name="marka">' .
            '<option value="Выберите автора" selected="" disabled="">Выберите автора</option>';
        for ($i = 0; $i < count($result); ++$i) {
            echo '<option value="' . $result[$i]['idA'] . '|' . $result[$i]['idB'] . '">' . $result[$i]['name'] . ' - ' . $result[$i]['title'] . '</option>';
        }
        echo '</select></p>';
    } else {
        echo '<p>В настоящее время авторов нет.</p>';
    }
    //Checkbox
    echo '<input type="checkbox" id="all" name="all"><label for="all">Удалить автора из всех книг</label>';
    //Кнопка "Удалить"
    echo '<p><input id="butt" type="submit" value="Удалить"></p>';
    //Кнопка "На главную"
    echo "<p><a href='../index.php'>На главную</a></p>";
    echo '</form>';

} else {
    //Преобразование строки с ID в массив ID
    $IDarr = explode('|', $_POST['marka']);
    if ($_POST['all'] == 'on') {
        //Отправка запроса БД
        $dbc->query('DELETE FROM authors WHERE id = ' . $IDarr[0] . ';');
    } else {
        //Отправка запроса БД
        $dbc->query('DELETE FROM books_authors WHERE id_author = '.$IDarr[0].' AND id_books = '.$IDarr[1].';');
    }
    //Переадресация на главную
    header('Location: ../index.php');
}
