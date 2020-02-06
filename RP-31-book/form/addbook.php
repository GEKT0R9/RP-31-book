<?php
//Подключенеие фона (background)
include('../BG.php');
//Работа с HTML формой
echo '<form method="POST" action="' . '../process/process.php' . '">
        <input name="name" placeholder="Название книги">
        <input name="price" placeholder="Цена">
        <input name="name_a" placeholder="Имя автора">
        <button type="submit" class="but">Добавить</button>
        <p><a href=\'../index.php\'>На главную</a></p>
    </form>';
