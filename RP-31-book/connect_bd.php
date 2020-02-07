<?php
//Пороверка блока try на ошибки
try {
//Запись в переменную данные о базе данных
    $dsn = "mysql:host=localhost;dbname=book_shop;charset=utf8";
//Запись в переменную параметры PDO
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
//Подключение к БД через PDO
    $dbc = new PDO($dsn, "root", "", $opt);
} catch (PDOException $err) {
//Вывод ошибки
    echo "Ошибка: не удается подключиться: " . $err->getMessage();
}
