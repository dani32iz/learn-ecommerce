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

        // Каждая ошибка при работе с БД вызовет выброс исключения
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $pdo->exec('SET NAMES utf8;');
        $pdo->exec('USE itc_eshop;');
    }

    return $pdo;
}

/**
 * Выборка табличных данных из БД
 *
 * @param string $query SELECT SQL-запрос
 * @param array $params Список именованных параметров и их значений, например: array(':email' => 'foo@bar.com')
 *
 * @return array Строки таблицы БД
 */
function db_select($query, $params = array())
{
    /** @var PDO $pdo */
    $pdo = get_connection();

    $statement = $pdo->prepare($query);

    $statement->execute($params);

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Выполняет SQL-запрос (INSERT/UPDATE/DELETE/REPLACE/ALTER/...).
 *
 * @param string $query SQL-запрос
 * @param array $params Список именованных параметров и их значений, например: array(':email' => 'foo@bar.com')
 *
 * @return int Количество затронутых строк (сколько строк было вставлено или изменено или удалено в таблице)
 */
function db_query($query, $params = array())
{
    /** @var PDO $pdo */
    $pdo = get_connection();

    $statement = $pdo->prepare($query);
    $statement->execute($params);

    return $statement->rowCount();
}


// Пример использования статической переменной в функции
function sum($x)
{
    static $y = 0;

    $y += $x;

    return $y;
}


