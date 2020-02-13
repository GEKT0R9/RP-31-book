<?php
//Подключение БД
require('../connect_bd.php');
//Проверка на наличие данных в методе POST
if (empty($_POST)) {
    //Подключение фона (background)
    include('../BG.php');
    //Начало работы с HTML формой
    echo '<form action="editbook.php" method="post" accept-charset="UTF-8"><p>';
    //Запись в переменную результат запроса БД
    $result = $dbc->query('
    SELECT
    nado.title, GROUP_CONCAT(nado.name SEPARATOR \', \') as name, nado.idB as idB
    FROM(
        SELECT books.title as title, books.id as idB, authors.name as name 
        FROM books,authors,books_authors
        WHERE books_authors.id_books = books.id AND books_authors.id_author = authors.id
    ) AS nado
    GROUP BY nado.title, nado.idB
    ');
    //Преобразование результата запроса в массив
    $result = $result->fetchAll();
    //Проверка массива на заполненость
    //Создание списка книг на форме
    if (count($result) > 0) {
        echo '<select class="form-control" name="marka">' .
            '<option value="Выберите книгу" selected="" disabled="">Выберите книгу</option>';
        for ($i = 0; $i < count($result); ++$i) {
            echo '<option value="' . $result[$i]['idB'] . '">' . $result[$i]['title'] . ' - ' . $result[$i]['name'] . '</option>';
        }
        echo '</select></p>';
    } else {
        echo '<p>В настоящее время книг нет.</p>';
    }
    //Кнопка "Удалить"
    echo '<p><input id="butt" type="submit" value="Редактировать"></p>';
    //Кнопка "На главную"
    echo "<p><a href='../index.php'>На главную</a></p>";
    echo '</form>';

} else {
    //Подключение фона (background)
    include('../BG.php');
    //Запись в переменную результат запроса БД
    $result = $dbc->query('SELECT authors.name FROM books_authors, authors WHERE authors.id = books_authors.id_author AND id_books = ' . $_POST['marka']);
    //Преобразование результата запроса в переменную
    $resultA = $result->fetchAll();
    //Запись в переменную результат запроса БД
    $result = $dbc->query('SELECT title,price FROM books WHERE id = ' . $_POST['marka']);
    //Преобразование результата запроса в переменную
    $result = $result->fetchAll()[0];
    //Работа с HTML формой
    echo '<form method="POST" action="' . '../process/process_editbook.php' . '">
        Название книги: <input name="name" placeholder="Название книги" value="' . $result['title'] . '"><br>
        Цена:<input name="price" placeholder="Цена" value="' . $result['price'] . '" ><br>
        <input name="idB" value="'.$_POST['marka'].'|'.count($resultA).'" style="display: none;">';
    //Форма полей ввода для авторов
    for ($i = 0; $i < count($resultA); ++$i) {
        echo 'Автор №'.($i+1).'<input name="name_a' . $i . '" placeholder="Имя автора" value="' . $resultA[$i]['name'] . '"><br>';
    }
    //Кнопки "Изменить" и "На главную"
    echo '<br><button type="submit" class="but">Изменить</button>
          <p><a href=\'../index.php\'>На главную</a></p>
          </form>';
}