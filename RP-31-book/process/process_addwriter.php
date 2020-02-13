<?php
//Функция вывода ошибки ввода
function fail($str, $id = true)
{
    //Подключение фона(background)
    include('../BG.php');
    //Вывод ошибки
    echo '<title>РНР- Ошибка</title>';
    if ($id) {
        echo "<p>Пожалуйста, укажите $str.</p>";
    } else {
        echo "<p>$str.</p>";
    }
    //Кнопка "Заполнить заново"
    echo "<p><a href='../form/addwriter.php'>Заполнить заново</a></p>";
    exit();
}
//Проверки
if (!empty(trim($_POST['book']))) {
    $idB = trim(addslashes($_POST['book']));
} else {
    fail('Вы не выбрали книгу', false);
}
require('../connect_bd.php');
if ($_POST['writer'] == 'none') {
    if (!empty(trim($_POST['name_a']))) {
        $name_a = trim(addslashes($_POST['name_a']));
    } else {
        fail('Укажите автора', false);
    }


    //Запись в переменную SQL запроса
    $sql = "INSERT INTO authors (name) VALUES ('$name_a')";
    //Отправка запроса БД
    $dbc->query($sql);
    //Отправка запроса БД и запись результата в переменную
    $sql = $dbc->query("SELECT id FROM authors");
    //Преобразование результата запроса в двумерный массив
    $sql = $sql->fetchAll();
    //Запись в одномерный массив последней строки двумерного
    $sql = $sql[count($sql) - 1];
    //Запись в переменную ID
    $idA = $sql['id'];
} else {
    $idA = $_POST['writer'];
}
//Запись в переменную SQL запроса
$sql = "INSERT INTO books_authors (id_author, id_books) VALUES ('$idA','$idB')";
//Отправка запроса БД
$dbc->query($sql);
//Переадресация на главную
header('Location: ../index.php');
