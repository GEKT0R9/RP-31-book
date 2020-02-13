<?php
//Функция вывода ошибки ввода
function fail($str, $id = true)
{
    //Подключение фона(background)
    include('../BG.php');
    //Вывод ошибки
    echo '<title>Ошибка ввода</title>';
    if ($id) {
        echo "<p>Пожалуйста, укажите $str.</p>";
    } else {
        echo "<p>$str.</p>";
    }
    //Кнопка "Заполнить заново"
    echo "<p><a href='../form/addbook.php'>Заполнить заново</a></p>";
    exit();
}
//Проверка на заполненость метода POST
if (isset($_POST)) {

    //Проверки
    if (!empty(trim($_POST['name']))) {
        $name = trim(addslashes($_POST['name']));
    } else {
        fail('название книги');
    }

    if(is_numeric(trim($_POST['price'])))
    {
        if (!empty(trim($_POST['price']))) {
            $price = trim(addslashes($_POST['price']));
        } else {
            fail('цену книги');
        }
    } else {
        fail('Неверный формат поля: "цена"', false);
    }

    if (!empty(trim($_POST['name_a']))) {
        $name_a = trim(addslashes($_POST['name_a']));
    } else {
        fail('Укажите автора', false);
    }
    //Подключение БД
    require('../connect_bd.php');
    //Запись в переменную SQL запроса
    $sql = "INSERT INTO books (title, price) VALUES ('$name', '$price')";
    //Отправка запроса БД
    $dbc->query($sql);
    //Отправка запроса БД и запись результата в переменную
    $sql = $dbc->query("SELECT id FROM books");
    //Преобразование результата запроса в массив
    $sql = $sql->fetchAll();
    //Запись в одномерный массив последней строки двумерного
    $sql = $sql[count($sql)-1];
    //Запись в переменную ID книги
    $idB = $sql['id'];
    
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
    //Запись в переменную ID автора
    $idA = $sql['id'];
    //Запись в переменную SQL запроса
    $sql = "INSERT INTO books_authors (id_author, id_books) VALUES ('$idA','$idB')";
    //Отправка запроса БД
    $dbc->query($sql);
}
//Перессылка на главную
header('Location: ../index.php');
