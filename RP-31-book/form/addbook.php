<?php
include('../BG.php');
echo '<form method="POST" action="' . '../process/process.php' . '">
        <input name="name" placeholder="Название книги">
        <input name="price" placeholder="Цена">
        <input name="name_a" placeholder="Имя автора">
        <button type="submit" class="but">Добавить</button>
    </form>';