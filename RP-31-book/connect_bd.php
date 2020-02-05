<?php
try {
//    $dbc = new PDO("mysql:host=localhost;dbname=bookshop;charset=utf8", "root", "");
//    $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dsn = "mysql:host=localhost;dbname=book_shop;charset=utf8";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $dbc = new PDO($dsn, "root", "", $opt);
} catch (PDOException $err) {
    echo "Ошибка: не удается подключиться: " . $err->getMessage();
}