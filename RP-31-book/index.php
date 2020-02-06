<?php
//Подключение фона (background)
include('BG.php');
//подключение бд
require('connect_bd.php');
//Работа с HTML формой
echo '<div><table class="form">';
echo '<button class="icon-btn add-btn">
        <div class="add-icon"></div>
        <div type="" class="btn-txt"><a href="form/addbook.php">Добавить книгу</a></div>
      </button>
      <button  class="icon-btn add-btn">
        <div class="btn-txt"><a href="form/delete.php">Удалить книгу</a></div>
      </button>
      <button class="icon-btn add-btn">
        <div class="add-icon"></div>
        <div type="" class="btn-txt"><a href="form/addwriter.php">Добавить автора</a></div>
      </button>
      <button  class="icon-btn add-btn">
        <div class="btn-txt"><a href="form/deletewriter.php">Удалить автора</a></div>
      </button>';
//Отправка запроса в БД и запись результата в переменную
$sql = $dbc->query('SELECT books.*, authors.* FROM books,authors,books_authors WHERE books_authors.id_books = books.id AND books_authors.id_author = authors.id');
//Преобразование результата запроса в массив
$sql = $sql->fetchAll();
//Работа с таблицей
echo '<tr class="tr"><td>Название</td><td>Цена</td><td>Автор</td></tr>';
//Запись данных в таблицу
foreach ($sql as $row) {
    echo '<tr class="tr">';
    echo '<td>' . $row['title'] . '</td>';
    echo '<td>' . $row['price'] . '</td>';
    echo '<td>' . $row['name'] . '</td>';
    echo '</tr>';

}
echo '</table></div>';
