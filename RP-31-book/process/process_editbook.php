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
    echo "<p><a href='../form/editbook.php'>Заполнить заново</a></p>";
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

    if (is_numeric(trim($_POST['price']))) {
        if (!empty(trim($_POST['price']))) {
            $price = trim(addslashes($_POST['price']));
        } else {
            fail('цену книги');
        }
    } else {
        fail('Неверный формат поля: "цена"', false);
    }
    //Преобразование строки формата "a|b" (где "a" id книги, а "b" кол-во авторов) в массив 2 строк
    $IDarr = explode('|',$_POST['idB']);
    //Запись элементов массива в переменные
    $idB = $IDarr[0];
    $count = $IDarr[1];
    //Создание массива
    $name_a = array();
    //Заполнение массива авторами
    for ($i = 0;$i<$count;++$i){
        if (!empty(trim($_POST['name_a'.$i.'']))) {
            $name_a[$i] = trim(addslashes($_POST['name_a'.$i.'']));
        } else {
            fail('Укажите автора №'.($i+1).'', false);
        }
    }
    //Подключение БД
    require('../connect_bd.php');
    //Запись в переменную SQL запроса
    $sql = "UPDATE books SET title = '$name', price = '$price' WHERE id = '$idB'";
    //Отправка запроса БД
    $dbc->query($sql);
    //Отправка запроса БД и запись результата в переменную
    $sql = $dbc->query("SELECT id_author as idA FROM books_authors WHERE id_books = '$idB'");
    //Преобразование результата запроса в массив
    $sql = $sql->fetchAll();
    //Цикл с запросом БД
    for($i = 0;$i<count($sql);++$i){
        $idA = $sql[$i]['idA'];
        $dbc->query("UPDATE authors SET name = '$name_a[$i]' WHERE id = '$idA'");
    }
}
//Перессылка на главную
header('Location: ../index.php');