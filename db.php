<?php
// Подключение к БД
function get_connection()
{
    static $pdo = null;

    $database_user = 'root';
    $database_password = 'root';

    if ($pdo === null) {
        $pdo = new PDO(
            'mysql:host=127.0.0.1',
            $database_user, $database_password
        );

        $pdo->exec('SET NAMES utf8;');
        $pdo->exec('USE itc_eshop;');
    }

    return $pdo;
}


function db_select($query)
{
    /** @var PDO $pdo */
    $pdo = get_connection();
    $statement = $pdo->query($query);

    $result = array();

    if ($statement) {
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }
    }

    return $result;
}

function db_query($query)
{
    /** @var PDO $pdo */
    $pdo = get_connection();

    return $pdo->exec($query);
}


// Пример использования статической переменной в функции
function sum($x)
{
    static $y = 0;

    $y += $x;

    return $y;
}


