<?php
function fail($str, $id = true)
{
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

    $sql = "INSERT INTO books (title, price) VALUES ('$name', '$price')";
    $dbc->query($sql);
    $sql = $dbc->query("SELECT id FROM books");
    $sql = $sql->fetchAll();
    $sql = $sql[count($sql)-1];
    $idB = $sql['id'];

    $sql = "INSERT INTO authors (name) VALUES ('$name_a')";
    $dbc->query($sql);
    $sql = $dbc->query("SELECT id FROM authors");
    $sql = $sql->fetchAll();
    $sql = $sql[count($sql)-1];
    $idA = $sql['id'];

    $sql = "INSERT INTO books_authors (id_author, id_books) VALUES ('$idA','$idB')";
    $dbc->query($sql);


    //Перессылка на главную
    header('Location: ../index.php');

    //////////////////////////////////////
}