<?php

require('../connect_bd.php');
if (empty($_POST)) {
    include('../BG.php');
    echo '<form action="deletewriter.php" method="post" accept-charset="UTF-8"><p>';
    $result = $dbc->query('SELECT name, id FROM authors');
    $result = $result->fetchAll();

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
    echo '<p><input id="butt" type="submit" value="Удалить"></p>';
    echo "<p><a href='../index.php'>На главную</a></p>";
    echo '</form>';

} else {
    $dbc->query('DELETE FROM authors WHERE id = ' . $_POST['marka'] . ';');
    header('Location: ../index.php');
}