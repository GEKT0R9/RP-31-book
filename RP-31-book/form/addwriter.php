<?php
//Функция вывода ошибки ввода
function fail($str, $id = true)
{
    //Подключение фона(background)
    include('../BG.php');
    echo '<title>РНР- Ошибка</title>';
    if ($id) {
        echo "<p>Пожалуйста, укажите $str.</p>";
    } else {
        echo "<p>$str.</p>";
    }
    echo "<p><a href='../index.php'>Заполнить заново</a></p>";
    exit();
}
//Подключение БД
require('../connect_bd.php');
//Проверка на заполненость метода POST
if (empty($_POST)) {
    //Подключение фона(background)
    include('../BG.php');
    //Начало работы с HTML формой
    echo '<form action="addwriter.php" method="post" accept-charset="UTF-8"><p>';
    //Запись в переменную результат запроса БД
    $result = $dbc->query('SELECT title, id FROM books;');
    //Преобразование результата запроса в массив
    $result = $result->fetchAll();
    //Проверка массива на заполненость
    if (count($result) > 0) {
        echo '<select class="form-control" name="marka">' .
            '<option value="Выберите книгу" selected="" disabled="">Выберите книгу</option>';
        for ($i = 0; $i < count($result); ++$i) {
            echo '<option value="'.$result[$i]['id'].'">'.$result[$i]['title'].'</option>';
        }
        echo '</select></p>';
    } else {
        echo '<p>В настоящее время книг нет.</p>';
    }
    //Поле ввода автора
    echo '<input name="name_a" placeholder="Имя автора">';
    //Кнопка "Добавить"
    echo '<p><input id="butt" type="submit" value="Добавить"></p>';
    //Кнопка "На главную"
    echo "<p><a href='../index.php'>На главную</a></p>";
    echo '</form>';

} else {
    //Проверка
    if (!empty(trim($_POST['name_a']))) {
        $name_a = trim(addslashes($_POST['name_a']));
    } else {
        fail('Укажите автора', false);
    }
    //Запись в переменную данные метода POST
    $idB = $_POST['marka'];
    //Запись в переменную SQL запроса
    $sql = "INSERT INTO authors (name) VALUES ('$name_a')";
    //Отправка запроса БД
    $dbc->query($sql);
    //Отправка запроса БД и запись результата в переменную
    $sql = $dbc->query("SELECT id FROM authors");
    //Преобразование результата запроса в двумерный массив
    $sql = $sql->fetchAll();
    //Запись в одномерный массив последней строки двумерного
    $sql = $sql[count($sql)-1];
    //Запись в переменную ID
    $idA = $sql['id'];
    //Запись в переменную SQL запроса
    $sql = "INSERT INTO books_authors (id_author, id_books) VALUES ('$idA','$idB')";
    //Отправка запроса БД
    $dbc->query($sql);
    //Переадресация на главную
    header('Location: ../index.php');
}
