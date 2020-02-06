<?php
require('../connect_bd.php');
if (empty($_POST)) {
    include('../BG.php');
    echo '<form action="delete.php" method="post" accept-charset="UTF-8"><p>';
    $result = $dbc->query('SELECT books.title, authors.name, books.id as idB, authors.id as idA FROM books,authors,books_authors WHERE books_authors.id_books = books.id AND books_authors.id_author = authors.id');
    $result = $result->fetchAll();

    if (count($result) > 0) {
        echo '<select class="form-control" name="marka">' .
            '<option value="Выберите книгу" selected="" disabled="">Выберите книгу</option>';
        for ($i = 0;$i<count($result);++$i){
            echo '<option value="'.$result[$i]['idA'].'|'.$result[$i]['idB'].'">'.$result[$i]['title'].' - '.$result[$i]['name'].'</option>';
        }
        echo '</select></p>';
    } else {
        echo '<p>В настоящее время книг нет.</p>';
    }
    echo '<p><input id="butt" type="submit" value="Удалить"></p>';
    echo "<p><a href='../index.php'>На главную</a></p>";
    echo '</form>';

} else {
    $IDarr = explode('|',$_POST['marka']);
    $dbc->query('DELETE FROM books_authors WHERE id_author = '.$IDarr[0].' AND id_books = '.$IDarr[1].';');
    $dbc->query('DELETE FROM authors WHERE id = '.$IDarr[0].';');
    $dbc->query('DELETE FROM books WHERE id = '.$IDarr[1].';');
    header('Location: ../index.php');
}