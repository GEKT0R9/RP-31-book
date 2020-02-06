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

require('../connect_bd.php');
if (empty($_POST)) {
    include('../BG.php');
    echo '<form action="addwriter.php" method="post" accept-charset="UTF-8"><p>';
    $result = $dbc->query('SELECT title, id FROM books;');
    $result = $result->fetchAll();

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
    echo '<input name="name_a" placeholder="Имя автора">';
    echo '<p><input id="butt" type="submit" value="Добавить"></p>';
    echo "<p><a href='../index.php'>На главную</a></p>";
    echo '</form>';

} else {
    if (!empty(trim($_POST['name_a']))) {
        $name_a = trim(addslashes($_POST['name_a']));
    } else {
        fail('Укажите автора', false);
    }
    $idB = $_POST['marka'];
    $sql = "INSERT INTO authors (name) VALUES ('$name_a')";
    $dbc->query($sql);
    $sql = $dbc->query("SELECT id FROM authors");
    $sql = $sql->fetchAll();
    $sql = $sql[count($sql)-1];
    $idA = $sql['id'];

    $sql = "INSERT INTO books_authors (id_author, id_books) VALUES ('$idA','$idB')";
    $dbc->query($sql);

    header('Location: ../index.php');
}